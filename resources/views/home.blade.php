@extends('layouts.app')

@section('content-header')
    <div class="content-header-background-home">
        <div class="center-content">
            <h2>Learning Management System</h2>
            <span>Hello, {{ Auth::user()->name }}</span>
        </div>

    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table id="datatable" class="table table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Module</th>
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
                    ajax: {
                        url: "{{ route('datatables') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            return $.extend({}, d, {
                                date: $("#date").val()
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
