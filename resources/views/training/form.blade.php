<form method="POST"
    action="{{ $model->exists ? route('training.update', ['id' => base64_encode($model->id)]) : route('training.store') }}">
    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif
    <div class="form-group">
        <label for="title">Title Section</label>
        <input type="hidden" name="module_id" value="{{ $module_id }}">
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
            placeholder="Module Title" value="{{ $model->exists ? $model->title : '' }}">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="Describe your training">{{ $model->exists ? $model->description : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="type">Type</label>
        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
            <option value="">Select Type</option>
            <option value="1" {{ $model->type == 1 ? 'selected' : '' }}>Quiz</option>
            <option value="4" {{ $model->type == 4 ? 'selected' : '' }}>Course</option>
            <option value="2" {{ $model->type == 2 ? 'selected' : '' }}>Remedial</option>
            <option value="3" {{ $model->type == 3 ? 'selected' : '' }}>Feedback</option>
        </select>
    </div>

    <div class="form-group">
        <label for="parent">Parent Training</label>
        <select name="parent" id="parent" class="form-control select2 @error('parent') is-invalid @enderror">
            <option value="">Select Parent Training</option>
            @foreach ($parents as $key => $parent)
                <option value="{{ $parent->id }}" {{ $model->parent_training == $parent->id ? 'selected' : '' }}>
                    {{ $parent->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="passing_grade">Passing Grade</label>
        <input type="number" class="form-control @error('passing_grade') is-invalid @enderror" name="passing_grade"
            id="passing_grade" min="0" placeholder="Passing Grade"
            value="{{ $model->exists ? $model->passing_grade : '' }}">
    </div>

    <div class="form-group">
        <label for="duration">Duration (Second)</label>
        <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration"
            id="duration" min="0" value="{{ $model->exists ? $model->duration : '' }}"
            placeholder="Duration (Minutes)">
    </div>

    <div class="form-group">
        <label for="number_questions">Number of Questions</label>
        <input type="number" class="form-control @error('number_questions') is-invalid @enderror"
            name="number_questions" id="number_questions" min="0"
            value="{{ $model->exists ? $model->number_questions : '' }}" placeholder="Number of Questions">
    </div>

    <div class="form-group">
        <label for="expired">Expired At</label>
        <input type="date" class="form-control @error('expired_at') is-invalid @enderror" name="expired_at"
            id="expired_at" value="{{ $model->exists ? $model->expired_at : '' }}">
    </div>


</form>

<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<script>
    $('.select2').select2();
    //Datemask dd/mm/yyyy
    $('#duration').inputmask({
        "mask": "99:99",
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()
</script>
