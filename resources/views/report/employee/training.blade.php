@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>Detail Training Employee</b></h5>
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
                                {{ $model->name }}
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
                                {{ $model->empl_id }}
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
                                {{ $model->company->name }}
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
                                {{ $model->organization->name }}
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
                                {{ $module->module->title }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Module Point</label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {{ $module->point }}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="datatable-report">
                                <thead>
                                    <tr>
                                        <th style="vertical-align:middle">Training Name</th>
                                        <th style="vertical-align:middle;">Point</th>
                                        <th style="vertical-align:middle;">Status</th>
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
                let id = '{{ base64_encode($module->module_id) }}'
                let uid = '{{ base64_encode($model->uuid) }}'

                $('#datatable-report').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,
                    info: false,
                    ordering: false,
                    ajax: {
                        url: "{{ route('report.employee.datatablesEmployeeTrainings') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            return $.extend({}, d, {
                                module: id,
                                employee_uuid: uid

                            })
                        },
                    },
                    columns: [{
                            data: 'title',
                            name: 'title'
                        }, {
                            data: 'point',
                            name: 'point'
                        }, {
                            data: 'status',
                            name: 'is_passed'
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
        $("#btnSearch").click(() => {
            $('#datatable-report').DataTable().ajax.reload();
        });
    </script>
@endpush
