<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Module\Training;
use App\Models\Module\TrainingSub;
use App\Models\Trainee\TraineeModule;
use App\Models\Trainee\TraineeTraining;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use DateTime;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($module_id)
    {
        $data['model'] = new Training();
        $data['module_id'] = $module_id;
        $data['parents'] = Training::where('module_id', $module_id)->get();
        return view('training.form', $data);
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
            'title'  => 'required',
            'passing_grade' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $model = new Training();
            $model->title = $request->title;
            $model->module_id = $request->module_id;
            $model->type = $request->type;
            $model->parent_training = $request->parent;
            $model->description = $request->description;
            $model->passing_grade = $request->passing_grade;
            $model->number_questions = $request->number_questions;
            $model->duration = $request->duration;
            $model->expired_at = $request->expired_at;
            $model->is_active = 0;
            $model->created_by = Auth::user()->uuid;
            $model->save();
            DB::commit();

            $content = returnJson(true, '');
            $status = 200;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            $content = returnJson(false, '');
            $status = 200;
        }


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
        $data['model'] = Training::find($id);
        $data['training_id'] = $id;
        $data['sub'] = new TrainingSub();
        $data['data'] = $data;
        $data['data']['edit'] = false;

        return view('training.show', $data);
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

        $data['model'] =  Training::find($id);
        $data['module_id'] = $data['model']->module_id;
        $data['parents'] = Training::where('module_id', $data['model']->module_id)->get();
        return view('training.form', $data);
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
            'title'  => 'required',
            'passing_grade' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        $id = base64_decode($id);

        DB::beginTransaction();
        try {
            $model = Training::find($id);
            $model->title = $request->title;
            $model->module_id = $request->module_id;
            $model->type = $request->type;
            $model->parent_training = $request->parent;
            $model->description = $request->description;
            $model->passing_grade = $request->passing_grade;
            $model->number_questions = $request->number_questions;
            $model->duration = $request->duration;
            $model->expired_at = $request->expired_at;
            $model->is_active = 0;
            $model->created_by = Auth::user()->uuid;
            $model->save();
            DB::commit();

            $content = returnJson(true, '');
            $status = 200;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            $content = returnJson(false, '');
            $status = 200;
        }


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
        $model = Training::find($id);
        $model->delete();
    }

    public function dataTables($module_id)
    {
        $query = Training::where('module_id', $module_id);

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
                    <div class="col-sm-9">
                        <div class="list-training-title">
                            ' . $model->title . '
                        </div>
                        <div class="row">
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
                                    <span>' . ($model->point ? $model->score : "-") . '</span>
                                </div>
                            </div>
                            <div class="list-training-content">
                                <div class="icon">
                                    <img src="' . asset("img/icon/load.svg") . '" alt="">
                                </div>
                                <div class="detail">Status
                                    <br>
                                    <span>Process</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 " style="align-self: center;">
                        <div class="float-sm-right">
                            <button type="button"
                                class="btn btn-sm btn-outline-phintraco dropdown-toggle btn-sm rounded-pill"
                                data-toggle="dropdown" aria-expanded="false" style="margin-top: 0.5rem;">
                                <i class="fas fa-cog"></i> Setting</a>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item modal-show" href="' . route('training.edit', ['id' => base64_encode($model->id)]) . '" title="Edit Training"><i class="fa fa-edit" style="color: var(--navy)"></i> Edit</a>
                            <a class="dropdown-item btn-delete" href="' . route('training.destroy', ['id' => base64_encode($model->id)]) . '" title="' . $model->title . '"><i class="fa fa-trash" style="color: var(--navy)"></i> Delete</a>
                            </div>
                            <a href="' . route('training.show', ['id' => base64_encode($model->id)]) . '" class="btn btn-phintraco" style="padding-inline: 1.5rem;margin-left: 0.5rem;"> View</a>
                        </div>
                    </div>
                </div>
            </div>';
                return $html;
            })
            ->rawColumns(['module'])
            ->make(true);
    }

    public function datatableTrainee(Request $request)
    {
        $query = Training::where('module_id', $request->module_id)->where('type', 1);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', function ($model) {
                if ($model->is_active == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $trainee = $model->traineeEmployee;

                if ($trainee) {
                    $pass =  !is_null($trainee->point) ? ($trainee->is_passed > 0 ? '<span class="badge badge-success">Lulus</span>' : '<span class="badge badge-danger">Tidak Lulus</span>') : '';

                    $status = !is_null($trainee->point) ? 'Selesai' : 'Dalam Penilaian';

                    if (!isset($trainee->finished_at)) {
                        $status = 'Belum Selesai';
                        $button = '<button type="button" class="btn btn-phintraco" onClick=clicked("' . route('trainee.training', ['id' => base64_encode($model->id)]) . '")>Lanjutkan</button>';
                    } else {
                        $button = '';
                    }
                    $score = $trainee->point;
                } else {
                    $pass = "";
                    $status = "Belum Dikerjakan";
                    $button = '<button type="button" class="btn btn-phintraco" onClick=clicked("' . route('trainee.training', ['id' => base64_encode($model->id)]) . '")>Mulai</button>';
                    $score = "-";
                }

                $html = '
                <div class="border-table">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="list-training-title">
                            ' . $model->title . '
                        </div>
                        <div class="row">
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
                                    <span>' . $score . '</span>
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
                    <div class="col-sm-4 " style="align-self: center;">
                        <div class="float-sm-right">
                            ' . $button . '
                        </div>
                    </div>
                </div>
            </div>';
                return $html;
            })
            ->rawColumns(['module'])
            ->make(true);
    }

    public function datatableTraineeRemedial(Request $request)
    {
        $query = Training::where('module_id', $request->module_id)->where('type', 2);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', function ($model) {
                if ($model->is_active == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $trainee = $model->traineeEmployee;

                if ($trainee) {
                    $pass =  !is_null($trainee->point) ? ($trainee->is_passed > 0 ? '<span class="badge badge-success">Lulus</span>' : '<span class="badge badge-danger">Tidak Lulus</span>') : '';

                    $status = !is_null($trainee->point) ? 'Selesai' : 'Dalam Penilaian';

                    if (!isset($trainee->finished_at)) {
                        $status = 'Belum Selesai';
                        $button = '<button type="button" class="btn btn-phintraco" onClick=clicked("' . route('trainee.training', ['id' => base64_encode($model->id)]) . '")>Lanjutkan</button>';
                    } else {
                        $button = '';
                    }
                    $score = $trainee->point;
                } else {
                    $pass = "";
                    $status = "Belum Dikerjakan";
                    $button = '<button type="button" class="btn btn-phintraco" onClick=clicked("' . route('trainee.training', ['id' => base64_encode($model->id)]) . '")>Mulai</button>';
                    $score = "-";
                }

                $html = '
                <div class="border-table">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="list-training-title">
                            ' . $model->title . '
                        </div>
                        <div class="row">
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
                                    <span>' . $score . '</span>
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
                    <div class="col-sm-4 " style="align-self: center;">
                        <div class="float-sm-right">
                            ' . $button . '
                        </div>
                    </div>
                </div>
            </div>';
                return $html;
            })
            ->rawColumns(['module'])
            ->make(true);
    }

    public function datatableTraineeFeedback(Request $request)
    {
        $query = Training::where('module_id', $request->module_id)->where('type', 3);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', function ($model) {
                if ($model->is_active == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $trainee = $model->traineeEmployee;

                if ($trainee) {
                    $pass =  !is_null($trainee->point) ? ($trainee->is_passed > 0 ? '<span class="badge badge-success">Lulus</span>' : '<span class="badge badge-danger">Tidak Lulus</span>') : '';

                    $status = !is_null($trainee->point) ? 'Selesai' : 'Dalam Penilaian';

                    if (!isset($trainee->finished_at)) {
                        $status = 'Belum Selesai';
                        $button = '<button type="button" class="btn btn-phintraco" onClick=clicked("' . route('trainee.training', ['id' => base64_encode($model->id)]) . '")>Lanjutkan</button>';
                    } else {
                        $button = '';
                    }
                    $score = $trainee->point;
                } else {
                    $pass = "";
                    $status = "Belum Dikerjakan";
                    $button = '<button type="button" class="btn btn-phintraco" onClick=clicked("' . route('trainee.training', ['id' => base64_encode($model->id)]) . '")>Mulai</button>';
                    $score = "-";
                }

                $html = '
                <div class="border-table">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="list-training-title">
                            ' . $model->title . '
                        </div>
                        <div class="row">
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
                                    <span>' . $score . '</span>
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
                    <div class="col-sm-4 " style="align-self: center;">
                        <div class="float-sm-right">
                            ' . $button . '
                        </div>
                    </div>
                </div>
            </div>';
                return $html;
            })
            ->rawColumns(['module'])
            ->make(true);
    }

    public function training($id)
    {
        $id = base64_decode($id);
        $data['model'] = Training::find($id);
        $max_question = $data['model']->number_questions < 2 ?  2 : $data['model']->number_questions;
        if ($data['model']->type != 3) { //jika general dan remedial
            $data['training'] = TrainingSub::where('training_id', $id)->get()->shuffle()->shift($max_question);
        } else { //jika feedback
            $data['training'] = TrainingSub::where('training_id', $id)->get()->shift($max_question);
        }
        $parent = Training::find($data['model']->parent_training);

        $now = date('Y-m-d H:i:s');

        if (!$data['model']->traineeEmployee) {
            $model = new TraineeTraining();
            $model->training_id = $data['model']->id;
            $model->started_at = $now;
            $model->employee_uuid = Auth::user()->uuid;
            // $model->finished_at = date('Y-m-d H:i:s');
            $model->is_passed = 0;
            $model->created_by = Auth::user()->uuid;
            $model->save();
        } else {
            $model = $data['model']->traineeEmployee;
        }
        $now = new DateTime();

        $data['started_at'] = $model->started_at;
        $start_at = Carbon::createFromFormat('Y-m-d H:i:s', $model->started_at);
        $finish_at = $start_at->addMinutes($data['model']->duration)->format('Y-m-d H:i:s');
        $finish = Carbon::createFromFormat('Y-m-d H:i:s', $finish_at);

        $remain = $now->diff($finish);

        $remain_minutes = ($remain->days * 24 * 60) + ($remain->h * 60) + $remain->i;
        $remain_seconds = $remain->s;

        $data['remain_minutes'] = $remain_minutes;
        $data['remain_seconds'] = $remain_seconds;
        $data['finished_at'] = $finish_at;
        if ($parent) {
            if (isset($parent->traineeEmployee)) {
                return view('trainee.training', $data);
            } else {
                return redirect()->back()->with('alert.failed', 'Please participate in the previous training');
            }
        } else {
            if ($data['model']->traineeEmployee && isset($data['model']->traineeEmployee->finished_at)) {
                return redirect()->back()->with('alert.failed', 'You`re already participate in this training');
            } else {
                return view('trainee.training', $data);
            }
        }
    }

    function submit(Request $request)
    {
        $true = 0;
        $false = 0;
        $sub = TrainingSub::where('training_id', $request->training_id)->where('training_type_id', 1)->get();
        $training = Training::find($request->training_id);
        $module = Module::find($training->module_id);
        // $count = $module->training->count();
        $count = $training->number_questions;

        $trainee = $training->traineeEmployee;

        $sum = $count;
        $answer = [];

        $question_random = [];
        foreach ($sub as $key => $value) {
            if (array_key_exists($value->question->id, $request->question)) {
                $question_random['question_id'][] = $value->question->id;
                $question_random['answer_id'][] = $value->question->answer_id;
            }

            // if (array_key_exists($value->question->id, $request->question)) {

            //     if ($request->question[$value->question->id] == $request->answer[$value->question->id]) {
            //         $true += 1;
            //         $score = 100;
            //     } else {
            //         $false += 1;
            //         $score = 0;
            //     }
            //     $answer[] = [
            //         'question_id' => $value->question->id,
            //         'answer_id' => $request->question[$value->question->id],
            //         'score' => $score
            //     ];
            // } else {
            //     $false += 1;
            // }
        }

        if ($question_random) {
            foreach ($question_random['question_id'] as $key => $question) {
                if ($request->question[$question_random['question_id'][$key]] == $request->answer[$question_random['question_id'][$key]]) {
                    $true += 1;
                    $score = 100;
                } else {
                    $false += 1;
                    $score = 0;
                }
                $answer[] = [
                    'question_id' => $question_random['question_id'][$key],
                    'answer_id' => $request->answer[$question_random['question_id'][$key]],
                    'score' => $score
                ];
            }
        }

        $score = $sum > 0 ? ($true / $sum) * 100 : 100;
        DB::beginTransaction();
        try {
            $model = TraineeTraining::find($trainee->id);
            $model->correct = $true;
            $model->wrong = $false;
            $model->answer = json_encode($answer);
            $model->score = $score;
            $model->finished_at = date('Y-m-d H:i:s');
            $model->is_passed = ($model->score >= $training->passing_grade ? 1 : 0);
            $model->updated_by = Auth::user()->uuid;



            if ($model->save()) {
                $trainingCount = Training::rightJoin('trainee_trainings as tt', 'trainings.id', '=', 'tt.training_id')->where('module_id', $module->id)->where('tt.employee_uuid', Auth::user()->uuid)->get();
                $traineeModule = TraineeModule::where('employee_uuid', Auth::user()->uuid)->where('module_id', $module->id)->first();
                // $point = round(($score / $count), 2);
                if (!$traineeModule) {
                    $traineeModule = new TraineeModule();
                    // $traineeModule->point = $point;
                }
                // $traineeModule->point = $traineeModule->point + $point;
                $traineeModule->employee_uuid = Auth::user()->uuid;
                $traineeModule->module_id = $module->id;
                $traineeModule->finished_at = ($trainingCount->count() == $count) ?  date('Y-m-d H:i:s') : null;
                $traineeModule->is_passed = ($trainingCount->count() == $count) ? 1 : 0;
                $traineeModule->created_by = Auth::user()->uuid;
                $traineeModule->updated_at = date('Y-m-d H:i:s');
                $traineeModule->save();
            }
            DB::commit();

            return redirect()->route('trainee.module', ['id' => $request->module_id])->with('alert.success', 'Thank You for Your Participation');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->route('trainee.module', ['id' => $request->module_id])->with('alert.failed', 'Sorry, Please Try Again');
        }
    }

    public function getTrainings(Request $request)
    {
        $module_id = $request->module_id;
        $project = Training::where('module_id', $module_id)->get();

        return response()->json($project);
    }

    function submitNilai(Request $request)
    {
        $training_id = base64_decode($request->training_id);
        $module_id = base64_decode($request->module_id);
        $id = base64_decode($request->id);
        $training = Training::find($training_id);
        $module = Module::find($module_id);
        $uuid = base64_decode($request->uuid);
        $answer = [];
        $total = 0;

        if ($request->question) {
            foreach ($request->question as $key => $value) {
                $answer[] = [
                    'question_id' => $value,
                    'answer_id' => $request->answer[$key],
                    'score' => $request->score[$key]
                ];
                $total += $request->score[$key];
            }

            $point = $total / count($request->question);
        } else {
            $point = 100;
        }

        $traineeModule = TraineeModule::where('module_id', $module_id)->where('employee_uuid', $uuid)->first();
        $totalTraining = Training::where('module_id', $module_id)->where('type', 1)->count();

        $last_point = $traineeModule ? ($traineeModule->point * $totalTraining) : 0;

        DB::beginTransaction();
        try {
            $model = TraineeTraining::find($id);

            if ($training->type == 1) {
                if (!isset($model->point)) {
                    $module_point = ($last_point + $point) / $totalTraining;
                    if ($traineeModule) {
                        $traineModule_update = TraineeModule::find($traineeModule->id);
                    } else {
                        $traineModule_update = new TraineeModule();
                        $traineModule_update->employee_uuid = $uuid;
                    }
                    $traineModule_update->point = $module_point;
                    $traineModule_update->is_passed = ($module_point >= $module->passing_grade ? 1 : 0);
                    $traineModule_update->save();
                }
            }
            $model->answer = json_encode($answer);
            $model->score = $point;
            $model->point = $point;
            $model->is_passed = ($model->score >= $training->passing_grade ? 1 : 0);
            $model->updated_by = Auth::user()->uuid;
            $model->save();




            DB::commit();
            return redirect()->back()->with('alert.success', 'Submit nilai Berhasil');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            dd($e);
            return redirect()->back()->with('alert.failed', 'Maaf Terjadi Kesalahan, Silahkan Coba Lagi');
        }
    }
}
