@extends('layouts.app')

@section('content-header')
    <div class="content-header-background">
        <div class="center-content">
            <h2>{{ $model->title }}</h2>
            <span>Total Training : {{ $model->count }}</span>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .table thead th {
            vertical-align: bottom;
            border-bottom: none;
        }

        .table th,
        .table td {
            border-top: none;
        }
    </style>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4" style="margin-top:12px">
            <div class="card">
                <div class="card-header">
                    <h5>Tentang Modul</h5>
                </div>
                <div class="card-body">
                    {{ $model->description }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>Reguler</h5>
                    <table id="datatable" class="table table-sm datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    @if ($model->finishTraining == $model->count)
                        <h5 class="mt-4">Feedback</h5>
                        <table id="datatable3" class="table table-sm datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    @endif

                    @if (
                        $model->finishTraining == $model->count &&
                            (isset($model->moduleTraining) && $model->moduleTraining->is_passed == 0))
                        <h5 class="mt-4">Remedial</h5>
                        <table id="datatable2" class="table table-sm datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>

        </div>

    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $(function() {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,
                    info: false,
                    pageLength: 20,
                    ordering: false,
                    bPaginate: false,
                    ajax: {
                        url: "{!! route('training.datatableTrainee') !!}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            return $.extend({}, d, {
                                module_id: {{ $model->id }}
                            })
                        },
                    },
                    columns: [{
                        data: 'module',
                        name: 'module'
                    }, ]
                });

                $('#datatable2').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,
                    info: false,
                    pageLength: 20,
                    ordering: false,
                    bPaginate: false,
                    ajax: {
                        url: "{!! route('training.datatableTraineeRemedial') !!}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            return $.extend({}, d, {
                                module_id: {{ $model->id }}
                            })
                        },
                    },
                    columns: [{
                        data: 'module',
                        name: 'module'
                    }, ]
                });

                $('#datatable3').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,
                    info: false,
                    pageLength: 20,
                    ordering: false,
                    bPaginate: false,
                    ajax: {
                        url: "{!! route('training.datatableTraineeFeedback') !!}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            return $.extend({}, d, {
                                module_id: {{ $model->id }}
                            })
                        },
                    },
                    columns: [{
                        data: 'module',
                        name: 'module'
                    }, ]
                });
            });
        });

        function clicked(params) {
            window.location.href = params;
        }
    </script>
@endpush
