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
            @endif

        </div>


    </form>
</div>
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
    </script>
@endpush
