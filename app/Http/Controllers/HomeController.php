<?php

namespace App\Http\Controllers;

use App\Models\Master\Department;
use App\Models\Module\Module;
use App\Models\Module\Training;
use App\Models\Trainee\TraineeModule;
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

        $query = Module::where('is_active', 1)->where(function ($query) {
            $query->where('expired_at', '>=', date('Y-m-d'));
            $query->orWhereNull('expired_at');
        });

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', function ($model) {
                $training = Training::rightJoin('trainee_trainings as tt', 'trainings.id', '=', 'tt.training_id')
                    ->where('module_id', $model->id)
                    ->where('tt.employee_uuid', Auth::user()->uuid)
                    ->where('type', 1)
                    ->orWhere('type', 4)
                    ->get();
                $totalTraining = Training::where('module_id', $model->id)
                    ->where('type', 1)
                    ->orWhere('type', 4)
                    ->count();
                $status = count($training) > 0 ? ((count($training) == $totalTraining) ? 'Complete' : 'Process') : 'Not Started';
                $module = TraineeModule::where('module_id', $model->id)->where('employee_uuid', Auth::user()->uuid)->first();

                if (!isset($module->point)) {
                    $module_point = 0;
                    $pass = '';
                } else {
                    $module_point = $module->point;
                    if ($module_point > $model->passing_grade) {
                        $pass = '<span class="badge badge-success">Lulus</span>';
                    } else {
                        $pass = '<span class="badge badge-danger">Tidak Lulus</span>';
                    }
                }
                $html = '
                <div class="border-table">
                    <div class="row">
                        <div class="col-sm-8"  style="cursor:pointer" onClick=clicked("' . route('trainee.module', ['id' => base64_encode($model->id)]) . '")>
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
                                        <span>' . count($training) . '/' . $totalTraining . '</span>
                                    </div>
                                </div>
                                <div class="list-training-content">
                                    <div class="icon">
                                        <img src="' . asset("img/icon/toga.svg") . '" alt="">
                                    </div>
                                    <div class="detail">Mastery Score
                                        <br>
                                        <span>' . $model->passing_grade . '</span>
                                    </div>
                                </div>
                                <div class="list-training-content">
                                    <div class="icon">
                                        <img src="' . asset("img/icon/thropy.svg") . '" alt="">
                                    </div>
                                    <div class="detail">Score
                                        <br>
                                        <span>' . $module_point . '</span>
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
                                 <div class="list-training-content">
                                    <div class="align-self-center">
                                        ' . $pass . '
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
