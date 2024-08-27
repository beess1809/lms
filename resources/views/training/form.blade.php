<form method="POST"
    action="{{ $model->exists ? route('training.update', ['id' => base64_encode($model->id)]) : route('training.store') }}">
    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif
    <div class="form-group">
        <label for="title">Judul Training</label>
        <input type="hidden" name="module_id" value="{{ $module_id }}">
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
            placeholder="Module Title" value="{{ $model->exists ? $model->title : '' }}">
    </div>

    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control" placeholder="Describe your training">{{ $model->exists ? $model->description : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="parent">Parent Training</label>
        <select name="parent" id="parent" class="form-control select2 @error('type') is-invalid @enderror">
            <option value="">Pilih Parent Training</option>
            @foreach ($parents as $key => $parent)
                <option value="{{ $parent->id }}" {{ $model->module_parent_id == $parent->id ? 'selected' : '' }}>
                    {{ $parent->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="passing_grade">Passing Grade</label>
        <input type="number" class="form-control @error('passing_grade') is-invalid @enderror" name="passing_grade"
            id="passing_grade" placeholder="Passing Grade" value="{{ $model->exists ? $model->passing_grade : '' }}">
    </div>

    <div class="form-group">
        <label for="expired">Expired At</label>
        <input type="date" class="form-control @error('expired_at') is-invalid @enderror" name="expired_at"
            id="expired_at" value="{{ $model->exists ? $model->expired_at : '' }}">
    </div>

</form>
<script>
    $('.select2').select2();
</script>
