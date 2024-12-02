<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Module\ModuleController;
use App\Http\Controllers\Module\ReportController;
use App\Http\Controllers\Module\TrainingController;
use App\Http\Controllers\Module\TrainingSubController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::post('/login/employee', [App\Http\Controllers\Auth\LoginController::class, 'employeeLoginSubmit'])->name('loginSubmit');
Route::get('/auth/{id}', [App\Http\Controllers\Auth\LoginController::class, 'auth'])->name('auth');
Route::get('/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirect'])->name('redirect');

Route::middleware('auth:employee')->group(function () {
    Route::post('/dashboard/table', [HomeController::class, 'datatables'])->name('datatables');
    Route::post('/getDepartment', [HomeController::class, 'getDepartment'])->name('getDepartment');

    Route::name('module.')->prefix('module')->group(function () {
        Route::get('/list/{tab_id}', [ModuleController::class, 'index'])->name('home');
        Route::post('/is-active', [ModuleController::class, 'isActive'])->name('isActive');
        Route::get('/dataTables/{category}', [ModuleController::class, 'datatables'])->name('dataTables');
        Route::resource('', ModuleController::class, ['parameters' => ['' => 'id']])->except([
            'index',
        ]);
    });

    Route::name('training.')->prefix('training')->group(function () {
        Route::post('/submit-nilai', [TrainingController::class, 'submitNilai'])->name('submitNilai');
        Route::post('/getTrainings', [TrainingController::class, 'getTrainings'])->name('getTrainings');
        Route::post('/is-active', [TrainingController::class, 'isActive'])->name('isActive');
        Route::get('/dataTables/{module_id}', [TrainingController::class, 'datatables'])->name('dataTables');
        Route::post('trainee/dataTables', [TrainingController::class, 'datatableTrainee'])->name('datatableTrainee');
        Route::post('trainee/dataTables2', [TrainingController::class, 'datatableTraineeRemedial'])->name('datatableTraineeRemedial');
        Route::post('trainee/dataTables3', [TrainingController::class, 'datatableTraineeFeedback'])->name('datatableTraineeFeedback');
        Route::post('upload-bulk', [TrainingController::class, 'uploadBulk'])->name('uploadBulk');
        Route::get('download-format', [TrainingController::class, 'downloadFormat'])->name('downloadFormat');
        Route::resource('', TrainingController::class, ['parameters' => ['' => 'id']])->except([
            'index',
            'create',
        ]);
        Route::get('/create/{module_id}', [TrainingController::class, 'create'])->name('create');
    });

    Route::name('sub.')->prefix('sub')->group(function () {
        Route::get('/dataTables/{training_id}', [TrainingSubController::class, 'datatables'])->name('dataTables');
        Route::get('/video', [TrainingSubController::class, 'video'])->name('video');
        Route::resource('', TrainingSubController::class, ['parameters' => ['' => 'id']]);

        Route::get('/course/{training_id}', [TrainingSubController::class, 'course'])->name('course');
        Route::get('/view/{file}', [TrainingSubController::class, 'view'])->name('view');
        Route::post('/update/course', [TrainingSubController::class, 'updateCourse'])->name('updateCourse');
    });
    Route::name('trainee.')->prefix('trainee')->group(function () {
        Route::get('/module/{id}', [ModuleController::class, 'module'])->name('module');
        Route::get('/training/{id}', [TrainingController::class, 'training'])->name('training');
        Route::post('/training', [TrainingController::class, 'submit'])->name('submit');
    });
    Route::name('report.')->prefix('report')->group(function () {
        Route::post('/datatables', [ReportController::class, 'datatables'])->name('datatables');
        Route::get('/detailDatatables/{id}', [ReportController::class, 'detailDatatables'])->name('detailDatatables');
        Route::get('/detail/{id}', [ReportController::class, 'detail'])->name('detail');
        Route::name('employee.')->prefix('employee')->group(function () {
            Route::get('/', [ReportController::class, 'employee'])->name('index');
            Route::post('/datatables', [ReportController::class, 'datatablesEmployees'])->name('datatablesEmployees');
            Route::post('/datatablesEmployeeModules', [ReportController::class, 'datatablesEmployeeModules'])->name('datatablesEmployeeModules');
            Route::get('/modul/{id}', [ReportController::class, 'employeeModul'])->name('modul');
            Route::get('/employeeModulPdf/{id}', [ReportController::class, 'employeeModulPdf'])->name('employeeModulPdf');
            Route::post('/datatablesEmployeeTrainings', [ReportController::class, 'datatablesEmployeeTrainings'])->name('datatablesEmployeeTrainings');
            Route::get('/training-detail/{id}', [ReportController::class, 'trainingDetail'])->name('trainingDetail');
            Route::get('/employeeTrainingPdf/{id}', [ReportController::class, 'employeeTrainingPdf'])->name('employeeTrainingPdf');
            Route::get('/trainingPdf/{id}', [ReportController::class, 'trainingPdf'])->name('trainingPdf');
            Route::get('/training/{id}', [ReportController::class, 'employeeTraining'])->name('training');
        });

        Route::name('training.')->prefix('training')->group(function () {
            Route::get('/', [ReportController::class, 'training'])->name('index');
            Route::post('/datatableTrainings', [ReportController::class, 'datatableTrainings'])->name('datatableTrainings');
            Route::get('/feedback', [ReportController::class, 'feedback'])->name('feedback');
            Route::get('/feedback/{id}', [ReportController::class, 'feedbackDetails'])->name('feedbackDetails');
            Route::post('/datatableFeedbacks', [ReportController::class, 'datatableFeedbacks'])->name('datatableFeedbacks');
        });

        Route::resource('', ReportController::class, ['parameters' => ['' => 'id']]);
    });
});
