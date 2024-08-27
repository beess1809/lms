<form class="form-horizontal"
    action="{{ $model->exists ? route('auth.permission.update', base64_encode($model->id)) : route('auth.permission.store') }}" method="POST">
    {{ csrf_field() }}
    @if ($model->exists)
    <input type="hidden" name="_method" value="PUT">
    @endif

    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input type="text" name="name" id="name" class="form-control" readonly placeholder="Name" @if ($model->exists) value="{{ $model->name }}" @endif>
        </div>
    </div>

    <div class="form-group row">
        <label for="display_name" class="col-sm-2 col-form-label">Display Name</label>
        <div class="col-sm-10">
            <input type="text" name="display_name" id="display_name" class="form-control" placeholder="Display Name" @if ($model->exists) value="{{ $model->display_name }}" @endif>
        </div>
    </div>

    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="description" placeholder="Description">@if ($model->exists) {{ $model->description }} @endif</textarea>
        </div>
    </div>
    <hr>
</form>
<script>
    function kebabCase(str) {
        name = str.toLowerCase()
        name = name.replace(" ", "-")
        $('#name').val(name)
    }

    $('#display_name').keyup(function() {
        kebabCase($('#display_name').val())
    })
    $('.select2').select2()

</script>
