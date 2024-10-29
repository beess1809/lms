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
                    <h5 class="card-title"><b>Daftar Karyawan</b></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-3">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="company" id="company" style="width: 100%;">
                                    <option class="form-control" value="">Pilih Perusahaan</option>
                                    @foreach ($companies as $key => $company)
                                        <option class="form-control" value="{{ $company->id }}">
                                            {{ $company->name . ' - ' . $company->as_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2bs4" style="width: 100%;" name="department_code"
                                    id="department_code">
                                    <option value="">Pilih Organisasi</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

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

                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2bs4" style="width: 100%;" name="training" id="training">
                                    <option value="">Pilih Training</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
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
                                        <th style="vertical-align:middle;">Training</th>
                                        <th style="vertical-align:middle;">Point</th>
                                        <th style="vertical-align:middle;">Passed</th>
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
                        url: "{{ route('report.training.datatableTrainings') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            return $.extend({}, d, {
                                company: $("#company").val(),
                                department: $("#department_code").val(),
                                module: $("#module").val(),
                                training: $("#training").val()
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
                            data: 'training',
                            name: 't.title'
                        },
                        {
                            data: 'point',
                            name: 'point'
                        },
                        {
                            data: 'result',
                            name: 'is_passed'
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

        $('#company').change(() => {
            Swal.showLoading();
            var company_id = $('#company').val();
            $.ajax({
                url: "{{ route('getDepartment') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    company_id
                },
                success: (data) => {
                    var str_data = '<option value="">Select Organization</option>';
                    str_data += data.map((project) => {
                        return '<option value="' + project.code + '">' + project.name +
                            '</option>';
                    });
                    $('#department_code').html(str_data);
                    Swal.close();
                },
                error: (xhr) => {
                    console.log(xhr);
                    Swal.close();
                }
            });
        });

        $('#module').change(() => {
            Swal.showLoading();
            var module_id = $('#module').val();
            $.ajax({
                url: "{{ route('training.getTrainings') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    module_id
                },
                success: (data) => {
                    var str_data = '<option value="">Select Training</option>';
                    str_data += data.map((project) => {
                        return '<option value="' + project.id + '">' + project.title +
                            '</option>';
                    });
                    $('#training').html(str_data);
                    Swal.close();
                },
                error: (xhr) => {
                    console.log(xhr);
                    Swal.close();
                }
            });
        });


        $("#btnSearch").click(() => {
            $('#datatable-report').DataTable().ajax.reload();
        });
    </script>
@endpush
