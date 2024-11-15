@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.13.1/themes/black-tie/jquery-ui.css">
@endpush
@section('content-header')
    <div class="content-header-background">
        <div class="center-content">
            <h2>{{ $model->title }}</h2>
            <span>{{ $model->description }}</span>
        </div>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: white">
            <li class="breadcrumb-item "><a href="{{ url()->previous() }}">Module</a></li>
            <li class="breadcrumb-item active">Section</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('training.create', ['module_id' => $model->id]) }}" class="btn btn-sm bg-phintraco modal-show"
                title="Add Section"><i class="fas fa-plus"></i> Section</a>

            <table id="datatable" class="table table-sm table-nonborder" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
                    ajax: "{!! route('training.dataTables', ['module_id' => $model->id]) !!}",
                    columns: [{
                        data: 'module',
                        name: 'module'
                    }, ]
                });
            });
        });
    </script>
@endpush
