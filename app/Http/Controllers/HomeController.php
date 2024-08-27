<?php

namespace App\Http\Controllers;

use App\Models\Master\Department;
use App\Models\Module\Module;
use App\Models\Module\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function datatables(Request $request)
    {

        $query = Module::where('is_active', 1)->where('expired_at', '>', date('Y-m-d'))->orWhereNull('expired_at');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', function ($model) {
                $training = Training::rightJoin('trainee_trainings as tt', 'trainings.id', '=', 'tt.training_id')->where('module_id', $model->id)->where('tt.employee_uuid', Auth::user()->uuid)->get();
                $status = count($training) > 0 ? ((count($training) == $model->training->count()) ? 'Complete' : 'Process') : 'Not Started';
                $html = '
                <div class="border-table">
                    <div class="row">
                        <div class="col-sm-8" onClick=clicked("' . route('trainee.module', ['id' => base64_encode($model->id)]) . '")>
                            <div class="list-training-title">
                            ' . $model->title . '
                            </div>
                            <div class="row">
                            <div class="list-training-content">
                                <div class="icon">
                                    <img src="' . asset("img/icon/toga.svg") . '" alt="">
                                </div>
                                <div class="detail">Total Training
                                    <br>
                                    <span>' . count($training) . '/' . $model->training->count() . '</span>
                                </div>
                            </div>
                            <div class="list-training-content">
                                <div class="icon">
                                    <img src="' . asset("img/icon/load.svg") . '" alt="">
                                </div>
                                <div class="detail">Status
                                    <br>
                                    <span>' . $status . '</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-4" style="align-self:center">
                            <span class="border-table float-sm-right" style="width: fit-content !important;">
                                ' . $model->category->name . '
                            </span>
                        </div>
                    </div>
                </div>';
                return $html;
            })
            ->rawColumns(['module'])
            ->make(true);
    }

    public function getDepartment(Request $request)
    {
        $company_id = $request->company_id;
        $project = Department::where('company_id', $company_id)->get();

        return response()->json($project);
    }
}
