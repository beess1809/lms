<div id="{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}">
    <form method="POST"
        action="{{ $sub->exists ? route('sub.update', ['id' => base64_encode($sub->id)]) : route('sub.store') }}"
        id="form-{{ $sub->exists ? $sub->id : '0' }}">
        @csrf
        @if ($sub->exists)
            @method('PUT')
        @endif
        <div class="form-group">
            <input type="hidden" name="training_id" value="{{ $training_id }}">
            <input type="hidden" name="training_type_id" value="1">
        </div>

        <div class="row">
            <div class="form-group col-8">
                <label for="question">Pertanyaan</label>
                <textarea name="question" id="question" class="form-control" placeholder="Describe your training">{{ $sub->exists ? $sub->question->question : '' }}</textarea>
            </div>
            <div class="form-group col-4">
                <label for="type_file">Tipe Jawaban</label>
                <select name="type_answer" id="type_answer" class="form-control" required>
                    <option value="">Pilih Tipe Jawaban</option>
                    <option {{ $sub->exists ? ($sub->type_answer == 1 ? 'selected' : '') : '' }} value="1">
                        Pilihan Ganda</option>
                    <option {{ $sub->exists ? ($sub->type_answer == 2 ? 'selected' : '') : '' }} value="2">Esay
                    </option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6" id="jawaban">
                <label for="file">Jawaban</label>
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control"
                        id="answer-value-{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-outline-phintraco btn-flat" id=""
                            onclick="addAnswer('{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}')">Tambah
                            Jawaban</button>
                    </span>
                </div>
            </div>
        </div>

        <div id="group-answer-{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}">
            @if ($sub->exists)
                @foreach ($sub->question->answer as $key => $item)
                    <div class="col-12 row" id="{{ $item->id }}">
                        <div class="form-check col-6">
                            <input class="form-check-input answer-{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                                type="radio" name="selected" value="{{ $key }}"
                                {{ $sub->question->answer_id == $item->id ? 'checked' : '' }}>
                            <input class="form-check-input" type="hidden" name="answer[]" value="{{ $item->answer }}">
                            <label class="form-check-label">{{ $item->answer }}</label>
                        </div>
                        <div class="form-group col-6">
                            <button class="btn btn-outline-danger" onclick="removeChoice(this,{{ $item->id }})"><i
                                    class="fas fa-times"></i></button>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        <div class="form-group">
            @if ($sub->exists)
                {{-- <button type="button" class="btn btn-phintraco float-right btn-add btn-edit"
                    onclick="editQuizz({{ $sub->exists ? $sub->id : 0 }})"><i
                        class="fas fa-{{ $sub->exists ? 'edit' : 'plus' }}"></i>
                    Edit</a> --}}
            @else
                <button type="button" data-id="{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                    class="btn btn-phintraco float-right btn-add"><i
                        class="fas fa-{{ $sub->exists ? 'edit' : 'plus' }}"></i>
                    Tambahkan</button>

                <button type="button" class="btn btn-outline-phintraco float-right" style="margin-right: 1rem"
                    data-target="#modal-upload" data-toggle="modal"><i class="fas fa-file-excel"></i>
                    Upload Bulk</button>
            @endif

        </div>


    </form>
</div>

<div class="modal fade" id="modal-upload">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Upload File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload">
                    <input type="hidden" name="training_id" value="{{ $training_id }}">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file" id="InputFile"
                            accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        <label class="custom-file-label" for="InputFile">Choose file</label>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-phintraco" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-phintraco" id="btn-upload-bulk">
                    Upload
                </button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@push('scripts')
    <script>
        $('.select2').select2();

        let id = {{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}


        function removeChoice(btn, norow) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        $('#type_answer').change(() => {
            let val = $('#type_answer').val()

            if (val == 2) {
                $('#jawaban').hide()
            } else {
                $('#jawaban').show()
            }
        })

        $('#InputFile').on('change', function() {
            //get the file name
            var fileName = $(this)[0].files[0].name;
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

        $("#btn-upload-bulk").click(function(event) {
            event.preventDefault();
            Swal.fire({
                type: 'info',
                title: 'Please Wait !',
                text: 'Process Upload',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
            });

            var data = $(this).data("id");

            var form = $("#form-upload")

            formdata = new FormData(form[0]);
            event.stopImmediatePropagation();
            if ($('input[type=file]')[0]) {
                var file = $('input[type=file]')[0].files[0];
                formdata.append('file', file);
            }

            form.find(".help-block").remove();
            form.find(".form-group").removeClass("has-error");

            $.ajax({
                url: "{{ route('training.uploadBulk') }}",
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                enctype: "multipart/form-data",
                data: formdata ? formdata : form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Upload Success !",
                        confirmButtonColor: "#3085d6",
                    });
                    $("#modal-upload").modal("hide");
                    $("#datatable").DataTable().ajax.reload();

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
                        title: "Ooops!",
                        text: "Something went wrong",
                        confirmButtonColor: "#3085d6",
                    });
                },
            });
        });
    </script>
@endpush
