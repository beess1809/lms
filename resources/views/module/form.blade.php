<form method="POST"
    action="{{ $model->exists ? route('module.update', ['id' => base64_encode($model->id)]) : route('module.store') }}">
    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif
    <div class="form-group">
        <label for="title">Judul Modul</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
            placeholder="Module Title" value="{{ $model->exists ? $model->title : '' }}">
    </div>

    <div class="form-group">
        <label for="descriptiom">Deskripsi</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
            placeholder="Module Description">{{ $model->exists ? $model->description : '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="category">Kategori</label>
        <select name="category" id="category" class="form-control select2 @error('category') is-invalid @enderror">
            @foreach ($categories as $key => $category)
                <option value="{{ $category->id }}" {{ $model->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="category">Tipe</label>
        <select name="type" id="type" class="form-control select2 @error('type') is-invalid @enderror">
            @foreach ($types as $key => $type)
                <option value="{{ $type->id }}" {{ $model->module_type_id == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="expired">Kadaluarsa</label>
        <input type="date" class="form-control @error('expired_at') is-invalid @enderror" name="expired_at"
            id="expired_at" value="{{ $model->exists ? $model->expired_at : '' }}">
    </div>

    <div class="form-group">
        <label for="passing_grade">Passing Grade</label>
        <input type="number" min="0" class="form-control @error('passing_grade') is-invalid @enderror"
            name="passing_grade" id="passing_grade" placeholder="Passing Grade"
            value="{{ $model->exists ? $model->passing_grade : '' }}">
    </div>

</form>
<script>
    $('.select2').select2();
</script>
