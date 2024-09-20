<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Models\Master\Company;
use App\Models\Module\Module;
use App\Models\Module\Training;
use App\Models\Module\TrainingSub;
use App\Models\Trainee\TraineeModule;
use App\Models\Trainee\TraineeTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['companies'] = Company::all();
        return view('report.index', $data);
    }

    public function detail($id)
    {
        $id = base64_decode($id);
        $exp = explode('|', $id);
        $data['model'] = Training::find($exp[0]);
        $data['training_id'] = $exp[0];
        $data['module_id'] = $data['model']->module_id;
        $data['uuid'] = $exp[1];
        $data['sub'] = new TrainingSub();
        $data['data'] = $data;
        $data['data']['edit'] = false;
        $data['id'] = $exp[2];

        return view('report.detail_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatables(Request $request)
    {
        $query = TraineeTraining::join('PECDB.employees as e', 'e.uuid', 'trainee_trainings.employee_uuid')
            ->join('trainings as t', 't.id', 'trainee_trainings.training_id')
            ->join('modules as m', 't.module_id', 'm.id')
            ->join('PECDB.companies as c', 'e.company_id', 'c.id')
            ->join('PECDB.departments as d', 'e.department_code', 'd.code')
            ->select('trainee_trainings.id', 'trainee_trainings.point','e.uuid as uuid', 'e.name as trainee', 'e.empl_id as trainee_nip', 'trainee_trainings.score', 'is_passed', 'finished_at', 'c.name as company', 'd.name as organization', 'm.title as module', 't.title as training', 't.id as training_id')
            ->orderBy('finished_at', 'desc');

        if ($request->company) {
            $query->where('e.company_id', $request->company);
        }

        if ($request->department) {
            $query->where('e.department_code', $request->department);
        }

        if ($request->module) {
            $query->where('m.id', $request->module);
        }

        if ($request->training) {
            $query->where('t.id', $request->training);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($model) {
                $string = '<a href="' . route('report.detail', ['id' => base64_encode($model->training_id . '|' . $model->uuid . '|' . $model->id)]) . '" type="button" class="btn btn-outline-phintraco">Detail</button';
                return $string;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function detailDataTables($id)
    {
        $id = base64_decode($id); // [id training | uuid]
        $exp = explode('|', $id);
        $trainee = $exp[1];
        $query = TrainingSub::where('training_id', $exp[0])->get();
        $trainee_answer = TraineeTraining::where('training_id', $exp[0])->where('employee_uuid', $trainee)->first();
        $answer = json_decode($trainee_answer->answer);

        $details = [];

        foreach($query as $key => $value) {
            foreach ($answer as $key2 => $value2) {
                if($value->question->id == $value2->question_id) {
                    $details[] = array(
                        'sub' => $value,
                        'training_id' => $exp[0],
                        'type_answer' => $value->type_answer,
                        'answer_id' => $value2->answer_id,
                        'score' => $value2->score
                    );
                }
            }
        }


        $question_answer = [];
        $score_answer = [];
        foreach ($answer as $key => $value) {
            $question_answer[$answer[$key]->question_id] = $answer[$key]->answer_id;
            $score_answer[$answer[$key]->question_id] = $answer[$key]->score;
        }

        return DataTables::of($details)
            ->addIndexColumn()
            ->addColumn('module', function ($model) use ($question_answer, $score_answer) {
                $data['sub'] = $model;
                $data['training_id'] = $model['training_id'];
                $data['question_answer'] = $question_answer;
                $data['score_answer'] = $score_answer;
                // return $trainee_answer->answer;
                return view('report.detail', $data);
            })

           
            ->rawColumns(['module'])
            ->make(true);
    }
}
