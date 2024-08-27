@extends('layouts.app')

@section('content-header')
    <div class="content-header-background">
        <div class="center-content">
            <h2>Modul</h2>
            <!-- <span>Lorem Ipsum Dolor Sit Amet</span> -->
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-6">
                    <ul class="nav nav-tabs" id="tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $active = $tab_id == 'mandatory' ? 'active' : '' }}" id="tab-mandatory"
                                href="{{ route('module.home', ['tab_id' => 'mandatory']) }}" role="tab"
                                aria-controls="tab-mandatory"
                                aria-selected="{{ $aria = $tab_id == 'mandatory' ? 'true' : 'false' }}">Mandatori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $active = $tab_id == 'optional' ? 'active' : '' }}" id="tab-optional"
                                href="{{ route('module.home', ['tab_id' => 'optional']) }}" role="tab"
                                aria-controls="tab-optional"
                                aria-selected="{{ $aria = $tab_id == 'optional' ? 'true' : 'false' }}">Optional</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right center-content">
                        <a href="{{ route('module.create') }}" class="btn btn-sm btn-phintraco modal-show"
                            title="Add Module"><i class="fas fa-plus"></i> Tambah Modul</a>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="tabContent" style="padding-top: 1rem;">
                <div class="tab-pane fade show active" id="{{ $tab_id }}" role="tabpanel"
                    aria-labelledby="{{ $tab_id }}">
                    @if ($tab_id == 'mandatory')
                        @include('module.tab')
                    @elseif ($tab_id == 'optional')
                        @include('module.tab')
                    @else
                        {{ 'Modul Tidak Ditemukan' }}
                    @endif
                </div>
            </div>
        </div>
    </div>
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
                        ajax: "{!! route('module.dataTables', ['category' => $tab_id]) !!}",
                        columns: [{
                            data: 'module',
                            name: 'module'
                        }, ]
                    });
                });
            });

            function toogle(params) {
                $.ajax({
                    url: "{!! route('module.isActive') !!}",
                    type: "POST",
                    data: {
                        _method: "POST",
                        _token: "{!! csrf_token() !!}",
                        id: params,
                    },
                    success: function(response) {
                        $("#datatable").DataTable().ajax.reload();
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Data has been changed!",
                            timer: 2000,
                            confirmButtonColor: "#3085d6",
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            confirmButtonColor: "#3085d6",
                        });
                    },
                });
            }

            function clicked(params) {
                window.location.replace(params);
            }
        </script>
    @endpush
@endsection
