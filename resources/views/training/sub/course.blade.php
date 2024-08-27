<div id="{{ $sub->exists ? 'course-' . $sub->id : 'course-0' }}">
    <form method="POST" action="{{ $sub->exists ? route('sub.updateCourse') : route('sub.store') }}"
        id="form-{{ $sub->exists ? $sub->id : '0' }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Judul</label>
            <input type="hidden" name="training_id" value="{{ $model->id }}">
            <input type="hidden" name="id" value="{{ $sub->id }}">
            <input type="hidden" name="training_type_id" value="2">
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                id="title" placeholder="Module Title" value="{{ $sub->exists ? $sub->title : '' }}">
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" placeholder="Describe your training">{{ $sub->exists ? $sub->description : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="type_file">Tipe File</label>
            <select name="type_file" id="tipe" class="form-control tipe">
                <option value="0">Pilih Tipe File</option>
                <option value="1">PDF</option>
                <option value="2">Image</option>
                <option value="3">Video</option>
            </select>
        </div>


        <div class="form-group">
            <label for="file">File</label>
            <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
        </div>
        @if (!$sub->exists)
            <div class="form-group">
                <button type="button" data-id="course" class="btn btn-phintraco float-right btn-add"><i
                        class="fas fa-plus"></i>
                    Tambahkan</button>
            </div>
        @endif


    </form>
    <br />
    <div class="progress" style="display:none;">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
            style="width:0%;">

        </div>
    </div>
    <div id = "result"></div>
</div>
