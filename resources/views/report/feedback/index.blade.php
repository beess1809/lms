@extends('layouts.app')

{{-- @section('content-header')
    <div class="content-header-background-home">
        <div class="center-content">
            <h2>Learning Management System</h2>
            <span>Hello John</span>
        </div>

    </div>
@endsection --}}

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>Report Feedback</b></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="module" id="module" style="width: 100%;">
                                    <option class="form-control" value="">Pilih Modul</option>
                                    @foreach (App\Models\Module\Module::all() as $key => $item)
                                        <option class="form-control" value="{{ $item->id }}">
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-1">
                            <div class="form-group">
                                <button type="button" class="btn btn-phintraco form-control" id="btnSearch"><i
                                        class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="datatable-report">
                                <thead>
                                    <tr>
                                        <th style="vertical-align:middle">Employee Name</th>
                                        <th style="vertical-align:middle;">NIP</th>
                                        <th style="vertical-align:middle;">Company</th>
                                        <th style="vertical-align:middle;">Department</th>
                                        <th style="vertical-align:middle;">Module</th>
                                        <th style="vertical-align:middle;">Finish At</th>
                                        <th style="vertical-align:middle;"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
    <script>
        $(document).ready(function() {
            $(function() {
                $('#datatable-report').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 20,
                    ordering: false,
                    ajax: {
                        url: "{{ route('report.training.datatableFeedbacks') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            return $.extend({}, d, {
                                module: $("#module").val()
                            })
                        },
                    },
                    columns: [{
                            data: 'trainee',
                            name: 'e.name'
                        }, {
                            data: 'trainee_nip',
                            name: 'e.empl_id'
                        },
                        {
                            data: 'company',
                            name: 'c.name'
                        },
                        {
                            data: 'organization',
                            name: 'd.name'
                        },
                        {
                            data: 'module',
                            name: 'm.title'
                        },
                        {
                            data: 'finished_at',
                            name: 'finished_at'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                });
            });
        });

        $("#btnSearch").click(() => {
            $('#datatable-report').DataTable().ajax.reload();
        });
    </script>
@endpush
