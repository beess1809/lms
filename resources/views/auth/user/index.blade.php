@extends('layouts.app')

@section('content-header')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="nav-icon far fa-user"></i> Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><i class="nav-icon fas fa-key"></i> Auth</li>
                    <li class="breadcrumb-item active"><i class="nav-icon far fa-user"></i> User</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Filter :</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Name:</label>
                            <input id="_name" type="text" class="form-control" placeholder="name">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Email:</label>
                            <input id="_email" type="text" class="form-control" placeholder="name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Roles:</label>
                            <select id="_role_ids" class="select2" multiple="multiple" data-placeholder="Any Roles"
                                style="width: 100%;">
                                @foreach (App\Models\Auth\Role::all() as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <button type="button" class="btn btn-sm btn-info float-right" id="_search"><i class="fas fa-search"></i>
                    Search</button>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="no-sort" style="width: 30px">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Wilayah</th>
                            <th>Cabang</th>
                            <th style="max-width: 500px">Roles</th>
                            <th class="no-sort" style="width: 30px"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#datatable').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            autoWidth: false,
            responsive: true,
            processing: true,
            serverSide: true,
            cache: false,
            ajax: {
                url: "{{ route('auth.user.datatable') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function ( d ) {
                    return $.extend( {}, d, {
                        name: $("#_name").val(),
                        email: $("#_email").val(),
                        role_id: $("#_role_ids").val()
                    });
                }
            },
            dom: '<"toolbar">lfrtip',
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'wilayah', name: 'wilayah'},
                {data: 'branch', name: 'branch'},
                {data: 'roles', name: 'roles'},
                {data: 'action', name: 'action'}
            ],
            columnDefs: [ {
                "targets"  : 'no-sort',
                "orderable": false,
            }],
            order: [[ 1, "asc" ]]
        });

        const toolbar = '<div class="dt-buttons btn-group flex-wrap">'
            + '<a href="{{ route("auth.user.create") }}" class="btn btn-sm btn-success modal-show" title="Create New User"><i class="fas fa-plus"></i> Create</a>'
            + '</div>';
        $("div.toolbar").html(toolbar);

        $("#_search").click(() => {
            $('#datatable').DataTable().ajax.reload();
        });
    });
</script>
@endpush
