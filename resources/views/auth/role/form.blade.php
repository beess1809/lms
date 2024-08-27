<form class="form-horizontal"
    action="{{ $model->exists ? route('auth.role.update', base64_encode($model->id)) : route('auth.role.store') }}" method="POST">
    {{ csrf_field() }}
    @if ($model->exists)
    <input type="hidden" name="_method" value="PUT">
    @endif

    <div class="form-group row">
        <label for="role_id" class="col-sm-2 col-form-label">Parent Role</label>
        <div class="col-sm-10">
            <select name="role_id" id="role_id" class="select2" style="width: 100%;">
                <option value="">Select Role</option>
                @foreach (App\Models\Auth\Role::all() as $role)
                <option  {{ ($model->role_id == $role->id) ? 'selected' : '' }}  value="{{ $role->id }}">{{ $role->display_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

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
        <label for="display_name" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="description" placeholder="Description">@if ($model->exists) {{ $model->description }} @endif</textarea>
        </div>
    </div>
    <hr>
    @if ($model->exists)
    <input id="id" type="hidden" class="form-control" name="id" value="{{ base64_encode($model->id) }}" required autofocus>

    <div class="col-md-6">
        <div class="form-group">
            <label for="role">Permissions</label>
            <div class="row">
             @foreach ($permissions as $permission)
                @php
                    $check = '';                                            
                @endphp
                @if ($model->hasPermission($permission->name))
                    @php
                        $check = 'checked';                                            
                    @endphp
                @endif
                    <div class="col-md-6">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="permission[]" id="permission{!! $permission->id !!}" value="{!! $permission->id !!}" {!! $check !!}>
                            <label for="permission{!! $permission->id !!}" class="custom-control-label">{!! $permission->display_name !!}</label>
                        </div>     
                    </div>
                @endforeach
            </div>


        </div>            
    </div> 
    @else
    <div class="form-group">
        <label for="role">Permissions</label>
        <div class="row">
         @foreach ($permissions as $permission)
                <div class="col-md-6">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="permission[]" id="permission{!! $permission->id !!}" value="{!! $permission->id !!}">
                        <label for="permission{!! $permission->id !!}" class="custom-control-label">{!! $permission->display_name !!}</label>
                    </div>     
                </div>
            @endforeach
        </div>
    </div>      
    @endif
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
