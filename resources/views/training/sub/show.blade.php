@if ($sub->training_type_id == 1)
    @if ($sub->type_answer == 1)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label>{{ $sub->question->question }}</label>
                    </div>
                </div>
                @foreach ($sub->question->answer as $item)
                    <div class="form-check col-6">
                        <input class="form-check-input answer-{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                            type="radio" name="selected-{{ $sub->id }}" value="{{ $item->id }}"
                            {{ $sub->question->answer_id == $item->id ? 'checked' : '' }} disabled>
                        <input class="form-check-input" type="hidden" name="answer[]" value="{{ $item->answer }}">
                        <label class="form-check-label">{{ $item->answer }}</label>
                    </div>
                @endforeach
                <a href="{{ route('sub.destroy', ['id' => base64_encode($sub->id)]) }}" type="button"
                    data-id="{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                    class="btn btn-danger float-right btn-delete" title="Question"><i class="fas fa-trash"></i>
                    Hapus</a>
                <a href="{{ route('sub.edit', ['id' => base64_encode($sub->id)]) }}" type="button"
                    data-id="{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                    class="btn btn-phintraco float-right modal-show edit" title="Edit Question"><i
                        class="fas fa-{{ $sub->exists ? 'edit' : 'plus' }}"></i>
                    Ubah</a>
            </div>
        </div>
    @elseif ($sub->type_answer == 2)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label>{{ $sub->question->question }}</label>
                    </div>
                </div>
                <textarea name="answer[]" rows="3" class="form-control mb-3" readonly></textarea>
                <a href="{{ route('sub.destroy', ['id' => base64_encode($sub->id)]) }}" type="button"
                    data-id="{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                    class="btn btn-danger float-right btn-delete" title="Question"><i class="fas fa-trash"></i>
                    Hapus</a>
                <a href="{{ route('sub.edit', ['id' => base64_encode($sub->id)]) }}" type="button"
                    data-id="{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                    class="btn btn-phintraco float-right modal-show edit" title="Edit Question"><i
                        class="fas fa-{{ $sub->exists ? 'edit' : 'plus' }}"></i>
                    Ubah</a>
            </div>
        </div>
    @endif
@else
    <div class="row justify-content-center" oncontextmenu="return false;">
        <div class="col-md-12">
            <div class="mb-2" style="display: flex;justify-content: center;">
                @if ($sub->type_file == 3)
                    <video height="500" controls controlsList="nodownload">
                        <source src="{{ route('sub.view', ['file' => base64_encode($sub->file)]) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif ($sub->type_file == 1)
                    <embed src="{{ route('sub.view', ['file' => base64_encode($sub->file)]) }}#toolbar=0"
                        type="application/pdf" frameBorder="0" scrolling="auto" height="500px" width="100%">
                @elseif ($sub->type_file == 2)
                    <picture>
                        <img src="{{ route('sub.view', ['file' => base64_encode($sub->file)]) }}" alt=""
                            style="width:100%;">
                    </picture>
                @endif
            </div>
            <a href="{{ route('sub.destroy', ['id' => base64_encode($sub->id)]) }}" type="button"
                data-id="{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                class="btn btn-danger float-right btn-delete" title="Question"><i class="fas fa-trash"></i>
                Hapus</a>
            <a href="{{ route('sub.edit', ['id' => base64_encode($sub->id)]) }}" type="button"
                data-id="{{ $sub->exists ? 'course-' . $sub->id : 'course-0' }}"
                class="btn btn-phintraco float-right modal-show edit" title="Edit Question"><i
                    class="fas fa-{{ $sub->exists ? 'edit' : 'plus' }}"></i>
                Ubah</a>

        </div>

    </div>
@endif
