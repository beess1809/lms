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
            <table style="width:100%">
                <tr>
                    <td><img src="img/logo/{{ $img }}" style="width: 200px"></td>
                </tr>
            </table>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>Detail Training Employee</b></h5>
                </div>
                <div class="card-body">
                    <table class="table1">
                        <tr>
                            <td>Employee Name</td>
                            <td>:</td>
                            <td>{{ $model->name }}</td>
                        </tr>
                        <tr>
                            <td>Employee NIP</td>
                            <td>:</td>
                            <td>{{ $model->empl_id }}</td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>:</td>
                            <td>{{ $model->company->name }}</td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>:</td>
                            <td>{{ $model->organization->name }}</td>
                        </tr>
                        <tr>
                            <td>Module</td>
                            <td>:</td>
                            <td>{{ $module->module->title }}</td>
                        </tr>
                        <tr>
                            <td>Point</td>
                            <td>:</td>
                            <td>{{ $module->point }}</td>
                        </tr>
                    </table>
                    <div style="margin-top: 3rem" class="detail">
                        <table class="bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align:left">Training Name</th>
                                    <th style="text-align:left;">Point</th>
                                    <th style="text-align:left;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainings as $item)
                                    <tr>
                                        <td style="text-align: left;">{{ $item['title'] }}</td>
                                        <td style="text-align: left">{{ $item['point'] }}</td>
                                        <td style="text-align: left">
                                            {{ $item['is_passed'] == 1 ? 'Passed' : 'Not Pass' }}</td>
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
