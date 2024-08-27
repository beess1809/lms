<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Models\Master\Category;
use App\Models\Master\ModuleType;
use App\Models\Module\Module;
use App\Models\Module\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Response;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab_id)
    {
        $data['tab_id'] = $tab_id;
        return view('module.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::all();
        $data['types'] = ModuleType::all();
        $data['model'] = new Module();
        return view('module.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category'  => 'required',
            'title'      => 'required',
            'type'  => 'required',
            'description'  => 'required',
        ]);

        $model = new Module();
        $model->title = $request->title;
        $model->description = $request->description;
        $model->category_id = $request->category;
        $model->module_type_id = $request->type;
        $model->expired_at = $request->expired_at;
        $model->is_active = 0;
        $model->created_by = Auth::user()->uuid;
        $model->save();

        $content = returnJson(true, route('module.show', ['id' => base64_encode($model->id)]));
        $status = 200;


        return (new Response($content, $status))
            ->header('Content-Type', 'json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = base64_decode($id);
        $model = Module::find($id);
        return view('module.show', ['model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = base64_decode($id);
        $model = Module::find($id);
        $data['categories'] = Category::all();
        $data['types'] = ModuleType::all();
        $data['model'] =  Module::find($id);
        return view('module.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category'  => 'required',
            'title'      => 'required',
            'type'  => 'required',
            'description'  => 'required',
        ]);

        $id = base64_decode($id);
        $model = Module::find($id);
        $model->title = $request->title;
        $model->description = $request->description;
        $model->category_id = $request->category;
        $model->module_type_id = $request->type;
        $model->expired_at = $request->expired_at;
        $model->created_by = Auth::user()->uuid;
        $model->save();

        $content = returnJson(true, '');
        $status = 200;

        return (new Response($content, $status))
            ->header('Content-Type', 'json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $model = Module::find($id);
        $model->delete();
    }

    public function isActive(Request $request)
    {
        $model = Module::find($request->id);

        if ($model->is_active == 1) {
            $model->is_active = 0;
        } else {
            $model->is_active = 1;
        }

        $model->save();
    }

    public function dataTables($category)
    {

        if ($category == 'mandatory') {
            $query = Module::where('category_id', 1);
        } else {
            $query = Module::where('category_id', 2);
        }
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', function ($model) {
                if ($model->is_active == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $html = '
                <div class="border-table">
                    <div class="row">
                        <div class="col-sm-9" onClick=clicked("' . route('module.show', ['id' => base64_encode($model->id)]) . '")>
                            <div class="center">
                                ' . $model->title . '
                            </div>
                        </div>
                        <div class="col-sm-3 ">
                            <div class="float-sm-right">
                                <label class="switch">
                                    <input type="checkbox"' . $checked . ' onChange="toogle(' . $model->id . ');" class="toogle" value="' . $model->is_active . '">
                                    <span class="slider round"></span>
                                </label>
                                <button type="button" class="btn btn-sm btn-outline-phintraco dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-top: 0.5rem;">
                                    <i class="fas fa-cog"></i> Setting</a>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item modal-show" href="' . route('module.edit', ['id' => base64_encode($model->id)]) . '"><i class="fa fa-edit" style="color: var(--navy)"></i> Edit</a>
                                    <a class="dropdown-item btn-delete" href="' . route('module.destroy', ['id' => base64_encode($model->id)]) . '"><i class="fa fa-trash" style="color: var(--navy)"></i> Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                return $html;
            })
            ->rawColumns(['module'])
            ->make(true);
    }

    function module($id)
    {
        $id = base64_decode($id);
        $model = Module::find($id);
        $model->count = Training::where('module_id', $id)->count();
        return view('trainee.module', ['model' => $model]);
    }
}
