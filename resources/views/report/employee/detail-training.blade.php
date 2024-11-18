@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>Detail Training Employee</b></h5>
                    <span class="float-right"><a
                            href="{{ route('report.employee.trainingPdf', ['id' => base64_encode($model->id)]) }}"
                            class="btn btn-danger"><i class="fas fa-file-pdf"></i> Download
                            Pdf</a></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Employee Name</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $model->trainee->name }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Employee ID</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $model->trainee->empl_id }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Company</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $model->trainee->company->name }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Organization</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $model->trainee->organization->name }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Module</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $model->training->module->title }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Section</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $model->training->title }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Section Point</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $model->point }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="datatable-report">
                                <thead>
                                    <tr>
                                        <th style="vertical-align:middle">No</th>
                                        <th style="vertical-align:middle;">Question</th>
                                        <th style="vertical-align:middle;">Answer</th>
                                        <th style="vertical-align:middle;">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($answers as $item)
                                        <tr>
                                            <td>{{ $item['no'] }}</td>
                                            <td>{{ $item['question'] }}</td>
                                            <td>{{ $item['answer'] }}</td>
                                            <td>{{ $item['score'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
        {{-- </div><!-- /.container-fluid --> --}}
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
