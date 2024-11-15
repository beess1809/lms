@extends('layouts.app')

@section('content-header')
    {{-- <div class="content-header-background">
        <div class="center-content">
            <h2>{{ $model->title }}</h2>
            <span>{{ $model->description }}</span>
        </div>
    </div> --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: white">
            <li class="breadcrumb-item "><a href="{{ route('module.home', ['tab_id' => 'mandatory']) }}">Modul</a></li>
            <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Section</a></li>
            <li class="breadcrumb-item active">{{ $data['model']->title }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card container">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="tab" role="tablist">
                        @if ($data['model']->type == 1)
                            <li class="nav-item">
                                <a class="nav-link active" id="quizz-tab" data-toggle="pill" href="#quizz" role="tab"
                                    aria-controls="quizz" aria-selected="false">Quiz</a>
                            </li>
                        @endif
                        @if ($data['model']->type == 4)
                            <li class="nav-item">
                                <a class="nav-link active" id="course-tab" data-toggle="pill" href="#course" role="tab"
                                    aria-controls="course" aria-selected="false">Course</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="tabContent" style="padding-top: 1rem;">
                        @if ($data['model']->type == 1)
                            <div class="tab-pane fade show active" id="quizz" role="tabpanel" aria-labelledby="quizz">
                                @include('training.sub.quizz', $data)
                            </div>
                        @endif
                        @if ($data['model']->type == 4)
                            <div class="tab-pane fade show active" id="course" role="tabpanel" aria-labelledby="course">
                                @include('training.sub.course', $data)
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <table id="datatable" class="table table-sm" style="width:100%">
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
            $('.file').on('contextmenu', function(e) {
                return false;
            });
            $(function() {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,
                    info: false,
                    paging: false,
                    language: {
                        "emptyTable": "Tidak Ada Data"
                    },
                    ajax: "{!! route('sub.dataTables', ['training_id' => $model->id]) !!}",
                    columns: [{
                        data: 'module',
                        name: 'module'
                    }, ]
                });
            });
        });

        $(".tipe").change(function() {
            var tipe = $('.tipe').val()

            if (tipe === "1") {
                $('#file').attr('accept', 'application/pdf')
            } else if (tipe === "2") {
                $('#file').attr('accept', 'image/*')
            } else if (tipe === "3") {
                $('#file').attr('accept', 'video/*')
            }
        });

        $(".btn-add").click(function(event) {
            event.preventDefault();

            var data = $(this).data("id");
            console.log(data)

            var form = $("#" + data + " form"),
                url = form.attr("action"),
                method = (data == 'quizz-0' || data == 'course') ? "POST" : "PUT";

            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
                event.stopImmediatePropagation();
                if ($('input[type=file]')[0]) {
                    var file = $('input[type=file]')[0].files[0];
                    formdata.append('file', file);
                }

                $('.progress').show();
            }

            form.find(".help-block").remove();
            form.find(".form-group").removeClass("has-error");

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.progress-bar').css('width', percentComplete + "%");
                            $('.progress-bar').html(percentComplete + "%");
                            if (percentComplete === 100) {

                            }
                        }
                    }, false);
                    return xhr;
                },
                url: url,
                method: method,
                contentType: false,
                cache: false,
                processData: false,
                enctype: "multipart/form-data",
                data: formdata ? formdata : form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('.progress').hide();

                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Data Berhasil Ditambahkan!",
                            timer: 2000,
                            confirmButtonColor: "#3085d6",
                        });
                        form.trigger("reset");
                        $("#modal").modal("hide");
                        $('#group-answer-' + data).html('')
                        $('#question').val('')
                        $("#datatable").DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi Kesahalan!",
                            text: "Periksa kembali isian anda",
                            confirmButtonColor: "#3085d6",
                        });
                    }

                    if (response.redirect) {
                        window.location.replace(response.redirect);
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if (res.message != "") {}
                    console.log(res.errors);
                    if ($.isEmptyObject(res.errors) == false) {
                        $.each(res.errors, function(key, value) {
                            $("#" + key)
                                .closest(".form-control")
                                .addClass("is-invalid");
                            $(
                                '<span class="invalid-feedback" role="alert"><strong>' +
                                value +
                                "</strong></span>"
                            ).insertAfter($("#" + key));
                        });
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Terjadi Kesahalan!",
                        text: "Periksa kembali isian anda",
                        confirmButtonColor: "#3085d6",
                    });
                },
            });
        });

        function addAnswer(id) {
            let no = $('.answer-' + id).length
            const d = new Date();
            let norow = d.getTime();
            var answer = $('#answer-value-' + id).val()
            var radio = '<div class="col-12 row" id="' + norow + '">' +
                '<div class="form-check col-6">' +
                ' <input class="form-check-input answer-' +
                id + '" type="radio" name="selected" value="' + no + '">' +
                ' <input class="form-check-input" type="hidden" name="answer[]" value="' + answer + '">' +
                '  <label class="form-check-label">' + answer + '</label>' +
                '</div>' +
                ' <div class="form-group col-6">' +
                '    <button class="btn btn-outline-danger" onclick="removeChoice(this, ' + norow +
                ')"><i class="fas fa-times"></i></button>' +
                '   </div>' +
                ' </div>'
            $('#group-answer-' + id).append(radio)
            $('#answer-value-' + id).val('')
        }

        function editQuizz(data) {

            var form = $("#form-" + data),
                url = form.attr("action"),
                method = "PUT";

            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            form.find(".help-block").remove();
            form.find(".form-group").removeClass("has-error");

            $.ajax({
                url: url,
                method: method,
                contentType: false,
                cache: false,
                processData: false,
                enctype: "multipart/form-data",
                data: formdata ? formdata : form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Data has been saved!",
                            timer: 2000,
                            confirmButtonColor: "#3085d6",
                        });
                        form.trigger("reset");
                        $("#modal").modal("hide");
                        $('#group-answer-' + data).html('')
                        $('#question').val('')
                        $("#datatable").DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Something went wrong!",
                            text: "Check your values",
                            confirmButtonColor: "#3085d6",
                        });
                    }

                    if (response.redirect) {
                        window.location.replace(response.redirect);
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if (res.message != "") {}
                    console.log(res.errors);
                    if ($.isEmptyObject(res.errors) == false) {
                        $.each(res.errors, function(key, value) {
                            $("#" + key)
                                .closest(".form-control")
                                .addClass("is-invalid");
                            $(
                                '<span class="invalid-feedback" role="alert"><strong>' +
                                value +
                                "</strong></span>"
                            ).insertAfter($("#" + key));
                        });
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Something went wrong!",
                        text: "Check your values",
                        confirmButtonColor: "#3085d6",
                    });
                },
            });
        };
    </script>
@endpush
