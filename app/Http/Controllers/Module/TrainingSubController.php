<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Models\Module\Answer;
use App\Models\Module\Question;
use App\Models\Module\Training;
use App\Models\Module\TrainingSub;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response as res;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Response;

class TrainingSubController extends Controller
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

    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function course($training_id)
    {
        $data['model'] = new TrainingSub();
        $data['training_id'] = $training_id;

        return view('training.sub.course', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if ($request->training_type_id == 1) {

            $this->validate($request, [
                'question' => 'required',
                'type_answer' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $model = new TrainingSub();
                $model->training_id = $request->training_id;
                $model->type_file = $request->file_type;
                $model->type_answer = $request->type_answer;
                $model->point = $request->point;
                $model->training_type_id = $request->training_type_id;
                $model->created_by = Auth::user()->uuid;
                $model->save();

                if ($model->save()) {
                    $question = new Question();
                    $question->training_sub_id = $model->id;
                    $question->question = $request->question;
                    $question->save();
                    if ($request->answer) {
                        foreach ($request->answer as $key => $value) {
                            $answer = new Answer();
                            $answer->question_id = $question->id;
                            $answer->answer = $value;
                            $answer->save();

                            if ($key == $request->selected) {
                                $question->answer_id = $answer->id;
                                $question->save();
                            }
                        }
                    }
                }
                DB::commit();

                $content = returnJson(true, '');
                $status = 200;
            } catch (Exception $e) {
                DB::rollBack();
                Log::error($e);
                $content = returnJson(false, '');
                $status = 200;
            }
        } else {
            DB::beginTransaction();
            try {
                $model = new TrainingSub();
                $model->title = $request->title;
                $model->description = $request->description;
                $model->training_id = $request->training_id;
                $model->type_file = $request->file_type;
                $model->point = $request->point;
                $model->training_type_id = $request->training_type_id;
                $model->created_by = Auth::user()->uuid;

                $files = $request->file('file');
                if ($files) {
                    $hashName = $files->hashName();
                    $folderName = 'files/' . $request->type_file;
                    $fileName = $hashName;
                    $file = storage_path() . $folderName . '/' . $fileName;
                    if (file_exists($file)) {
                        Storage::delete($folderName . '/' . $fileName);
                    }
                    $files->store($folderName);
                }
                $model->file = $folderName . '/' . $fileName;
                $model->type_file = $request->type_file;
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
        }
        return (new res($content, $status))
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
        $data['sub'] = TrainingSub::find($id);
        $data['model'] = Training::find($data['sub']->training_id);
        $data['training_id'] = $data['sub']->training_id;

        return view('training.sub.show', $data);
    }

    public function view($file)
    {
        $path = base64_decode($file);


        if (!Storage::exists($path)) {
            abort(404);
        }

        return Storage::response($path);
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
        $data['sub'] = TrainingSub::find($id);
        $data['model'] = Training::find($data['sub']->training_id);
        $data['training_id'] = $data['sub']->training_id;
        $data['data'] = $data;
        $data['data']['edit'] = true;

        return view('training.sub.form', $data);
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

        $id = base64_decode($id);
        if ($request->training_type_id == 1) {
            DB::beginTransaction();
            try {
                $model = TrainingSub::find($id);

                $model->training_id = $request->training_id;
                $model->type_answer = $request->type_answer;
                $model->point = $request->point;
                $model->training_type_id = $request->training_type_id;
                $model->updated_by = Auth::user()->uuid;
                $model->save();

                if ($model->save()) {
                    $question = Question::where('training_sub_id', $id)->first();
                    $question->training_sub_id = $model->id;
                    $question->question = $request->question;
                    $question->save();

                    $oldAnswer = Answer::where('question_id', $question->id);
                    $oldAnswer->delete();

                    foreach ($request->answer as $key => $value) {
                        $answer = new Answer();
                        $answer->question_id = $question->id;
                        $answer->answer = $value;
                        $answer->save();

                        if ($key == $request->selected) {
                            $question->answer_id = $answer->id;
                            $question->save();
                        }
                    }
                }
                DB::commit();

                $content = returnJson(true, '');
                $status = 200;
            } catch (Exception $e) {
                DB::rollBack();
                Log::error($e);
                $content = returnJson(false, '');
                $status = 200;
            }
        }
        return (new res($content, $status))
            ->header('Content-Type', 'json');
    }

    function updateCourse(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = TrainingSub::find($request->id);
            $model->title = $request->title;
            $model->description = $request->description;
            $model->training_id = $request->training_id;
            $model->type_file = $request->file_type;
            $model->point = $request->point;
            $model->training_type_id = $request->training_type_id;
            $model->created_by = Auth::user()->uuid;

            $files = $request->file('file');

            if ($files) {
                $hashName = $files->hashName();
                $folderName = 'files/' . $request->type_file;
                $fileName = $hashName;
                $file = storage_path() . $folderName . '/' . $fileName;
                if (file_exists($file)) {
                    Storage::delete($folderName . '/' . $fileName);
                }
                $files->store($folderName);
                $model->file = $folderName . '/' . $fileName;
            }
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

        return (new res($content, $status))
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
        $model = TrainingSub::find($id);
        $model->delete();
    }

    public function dataTables($id)
    {
        $query = TrainingSub::where('training_id', $id);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', function ($model) {
                $data['sub'] = $model;
                $data['training_id'] = $model->training_id;
                // return $model->training_type_id;
                return view('training.sub.show', $data);
            })
            ->rawColumns(['module'])
            ->make(true);
    }

    public function video()
    {
        $fileContents = Storage::disk('local')->get("/videos/cocomelon.mp4");
        $response = FacadesResponse::make($fileContents, 200);
        $response->header('Content-Type', "video/mp4");
        return $response;
    }
}
