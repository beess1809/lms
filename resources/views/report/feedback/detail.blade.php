<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>{{ config('app.name', 'Laravel') }}{{ isset($title) ? ' | ' . $title : '' }}</title>
    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="/adminlte/dist/css/adminlte.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/lms.css') }}"> --}}

    <style>
        @page {
            size: 7in 9.25in;
        }

        td {
            padding: 2px;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .py-3 {
            padding-bottom: 1rem;
            padding-top: 1rem;
        }

        .answer {
            display: inline-flex;
            width: 100px;
            margin-left: 2rem;
        }

        .group {
            margin-bottom: 4px;
            font-weight: bold;
        }

        body {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div>
        <table style="width:100%">
            <tr>
                <td><img src="img/phintraco.png" style="width: 200px"></td>
                <td style="text-align: right">
                    <p style="font-weight: bold">No . F-PTC-HRD-17-010219-03</p>
                </td>
            </tr>
        </table>
        <div style="text-align: center;margin-top:1rem;margin-bottom:1rem;">
            <h4>FEEDBACK</h4>
        </div>
        <table>
            <tr>
                <td><strong>Nama Pelatihan</strong></td>
                <td>:</td>
                <td> {{ $model->training->module->title }} </td>
            </tr>
            <tr>
                <td><strong>Penyelenggara</strong></td>
                <td>:</td>
                <td>HR Phintraco </td>
            </tr>
            <tr>
                <td><strong>Nama Peserta</strong></td>
                <td>:</td>
                <td> {{ $model->trainee->name }} </td>
            </tr>
            <tr>
                <td><strong>Departemen</strong></td>
                <td>:</td>
                <td> {{ $model->trainee->organization->name }} </td>
            </tr>
            <tr>
                <td><strong>Tanggal Pelatihan</strong></td>
                <td>:</td>
                <td> {{ $model->finished_at }} </td>
            </tr>
            <tr>
                <td><strong>Tujuan Pelatihan</strong></td>
                <td>:</td>
                <td> {{ $model->training->description }} </td>
            </tr>
        </table>

        <div style="border-top: 2px solid black" class="mt-3">
            <p style="font-weight: bold">Pertanyaan dijawab oleh peserta training ( paling lambat 1 hari setelah
                pelatihan )</p>
        </div>
        {{-- @foreach ($details as $key => $value)
            <div class="mb-3">
                <div class="question" style="margin-bottom: 4px">
                    <span>{{ $key + 1 }}.</span> {{ $value['question'] }}
                </div>

                @foreach ($value['answers'] as $item)
                    <span class="answer">
                        {{ $item->answer }}
                    </span>
                @endforeach
            </div>
        @endforeach --}}


        @foreach ($group as $item)
            <div class="mb-3">
                <div class="group">
                    {{ $item['group_name'] }}
                </div>

                @foreach ($item['details'] as $key => $value)
                    <div class="mt-2">
                        <div class="question" style="margin-bottom: 4px">
                            <span>{{ $key + 1 }}.</span> {{ $value['question'] }}
                        </div>

                        @foreach ($value['answers'] as $item)
                            <span class="answer">
                                {{ $item->answer }}
                            </span>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach


        <!-- /.row -->
        {{-- </div><!-- /.container-fluid --> --}}
    </div>
</body>

</html>
