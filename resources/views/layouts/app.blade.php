<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}{{ isset($title) ? ' | ' . $title : '' }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bs-stepper/css/bs-stepper.min.css') }}">

    @stack('css')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lms.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <style>
        /* .text-sm .select2-search__field {
            line-height: 27px !important;
        }

        .text-sm .select2-selection__rendered {
            line-height: 25px !important;
        } */

        /* .select2-container .select2-selection--single {
            height: 35px !important;
        }
        .select2-selection__arrow {
            height: 34px !important;
        } */

        table.dataTable.dtr-inline.collapsed.table-sm>tbody>tr>td:first-child:before,
        table.dataTable.dtr-inline.collapsed.table-sm>tbody>tr>th:first-child:before {
            top: 2px;
            margin-top: .3rem;
        }

        .table {
            background-color: #fff;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: none;
        }

        .table th,
        .table td {
            border-top: none;
        }

        .table tbody tr.active {
            background-color: rgba(0, 0, 0, .05);
        }

        div.dt-buttons {
            float: right;
        }

        .text-sm .btn-xs {
            font-size: .75rem !important;
        }

        .text-sm .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            font-size: 1rem !important;
        }

        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
    </style>
    @stack('style')
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand-md navbar-light bg-phintraco">
            <div class="container-fluid mx-5">
                <a href="../../index3.html" class="navbar-brand">
                    <img src="{{ asset('img/phintraco-logo.png') }}" alt="AdminLTE Logo" class="brand-image"
                        style="opacity: .8">
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    @php
                        $segments = Request::segments();
                        $url = '/' . implode('/', $segments);
                    @endphp
                    <ul class="navbar-nav nav-center">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link @if ($segments[0] == 'dashboard') active @endif">Dashboard</a>
                        </li>
                        @if (session('trainer') == 1)
                            <li class="nav-item">
                                <a href="{{ route('module.home', ['tab_id' => 'mandatory']) }}"
                                    class="nav-link @if ($segments[0] == 'module' || $segments[0] == 'training') active @endif">Module</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.index') }}"
                                    class="nav-link @if ($segments[0] == 'report' && !isset($segments[1])) active @endif">Scoring</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown"
                                    class="nav-link dropdown-toggle  @if ($segments[0] == 'report' && isset($segments[1])) active @endif"
                                    href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre="">Report<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('report.employee.index') }}">
                                            Employee
                                        </a>
                                        <a class="dropdown-item" href="{{ route('report.training.index') }}">
                                            Training
                                        </a>
                                        <a class="dropdown-item" href="{{ route('report.training.feedback') }}">
                                            Feedback
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>

                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">


                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                            <i class="far fa-user-circle"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('redirect') }}">
                                    <i class="fa fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>


        <div class="content-wrapper">
            @yield('content-header')
            <div class="content">
                @yield('content')
                @include('layouts.modal')
            </div>

        </div>

        <footer class="main-footer footer-lms">

            <div class="float-right d-none d-sm-inline">
                v 1.0
            </div>

            <strong>Copyright &copy; 2023 <a href="">PHINTRACO GROUP</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script>
        const loginUrl = "{{ route('login') }}";
    </script>
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- BS-Stepper -->
    <script src="{{ asset('adminlte/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    @stack('js')
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        // Fungsi formatRupiah
        function formatRupiah(angka, prefix) {

            var number_string = angka.replace(/\./g, "").toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
        }

        const uniqueId = (length = 16) => {
            return parseInt(Math.ceil(Math.random() * Date.now()).toPrecision(length).toString().replace(".", ""));
        }

        $(function() {
            $(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
                if (event.key == "Enter") {
                    event.preventDefault();
                }
            });

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $(document).on('keyup', '.number', function(e) {
                $(e.target).val(formatRupiah($(e.target).val()));
                if ($(e.target).data('target')) {
                    $("#" + $(e.target).data('target')).val($(e.target).val().replaceAll('.', ''));
                }
            });
        });
    </script>
    @if (session('alert.success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('alert.success') }}',
                    timer: 2000,
                    confirmButtonColor: '#3085d6',
                });
            });
        </script>
    @endif
    @if (session('alert.failed'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('alert.failed') }}',
                    confirmButtonColor: '#3085d6',
                });
            });
        </script>
    @endif
    @stack('scripts')
</body>

</html>
