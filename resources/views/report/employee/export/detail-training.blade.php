<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>{{ config('app.name', 'Laravel') }}{{ isset($title) ? ' | ' . $title : '' }}</title>
    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/lms.css') }}"> --}}

    <style>
        td {
            padding: 8px;
        }

        th {
            padding: 8px;
        }

        table.bordered {
            border-collapse: collapse;
        }

        table.bordered td,
        table.bordered th {
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>Detail Training Employee</b></h5>
                </div>
                <div class="card-body">
                    <table class="table1">
                        <tr>
                            <td>Employee Name</td>
                            <td>:</td>
                            <td>{{ $model->trainee->name }}</td>
                        </tr>
                        <tr>
                            <td>Employee NIP</td>
                            <td>:</td>
                            <td>{{ $model->trainee->empl_id }}</td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>:</td>
                            <td>{{ $model->trainee->company->name }}</td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>:</td>
                            <td>{{ $model->trainee->organization->name }}</td>
                        </tr>
                        <tr>
                            <td>Module</td>
                            <td>:</td>
                            <td>{{ $model->training->module->title }}</td>
                        </tr>
                        <tr>
                            <td>Training</td>
                            <td>:</td>
                            <td>{{ $model->training->title }}</td>
                        </tr>
                        <tr>
                            <td>Point</td>
                            <td>:</td>
                            <td>{{ $model->point }}</td>
                        </tr>
                    </table>
                    <div style="margin-top: 3rem" class="detail">
                        <table class="bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align:left">No</th>
                                    <th style="text-align:left;">Question</th>
                                    <th style="text-align:left;">Answer</th>
                                    <th style="text-align:left;">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($answers as $item)
                                    <tr>
                                        <td style="text-align: left;">{{ $item['no'] }}</td>
                                        <td style="text-align: left;">{{ $item['question'] }}</td>
                                        <td style="text-align: left;">{{ $item['answer'] }}</td>
                                        <td style="text-align: left;">{{ $item['score'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
        {{-- </div><!-- /.container-fluid --> --}}
    </div>

</body>

</html>
