<form class="form-horizontal"
    action="{{ $model->exists ? route('auth.menu.update', base64_encode($model->id)) : route('auth.menu.store') }}" method="POST">
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
        <label for="menu_id" class="col-sm-2 col-form-label">Parent Menu</label>
        <div class="col-sm-10">
            <select name="menu_id" id="menu_id" class="select2" style="width: 100%;">
                <option value="">Select Menu</option>
                @foreach (App\Models\Auth\Menu::all() as $menu)
                <option  {{ ($model->menu_id == $menu->id) ? 'selected' : '' }}  value="{{ $menu->id }}">{{ $menu->display_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="url" class="col-sm-2 col-form-label">Url</label>
        <div class="col-sm-10">
            <input type="text" name="url" id="url" class="form-control" placeholder="url" @if ($model->exists) value="{{ $model->url }}" @endif>
        </div>
    </div>

    <div class="form-group row">
        <label for="icon" class="col-sm-2 col-form-label">Icon</label>
        <div class="col-sm-10">
            <input type="text" name="icon" id="icon" class="form-control" placeholder="Icon" @if ($model->exists) value="{{ $model->icon }}" @endif>
        </div>
    </div>

    <hr>
    @if ($model->exists)
    <div class="col-md-6">
        <div class="form-group">
            <label for="role">Roles</label>
            <div class="row">
                <div class="col-md-12">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input all" type="checkbox" id="all" onclick="cek()">
                        <label for="all" class="custom-control-label">Check All</label>
                    </div>     
                </div>
                <hr>
             @foreach ($roles as $role)
             @php
                    $check = '';
             @endphp
             @foreach ($menuR as $item)
                @php
                    if ($role->id == $item->role_id) {
                        $check = 'checked';
                        // @dd();
                    }
                @endphp
                @endforeach
                    <div class="col-md-6">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input check" type="checkbox" name="role[]" id="role{!! $role->id !!}" value="{!! $role->id !!}" {!! $check !!}>
                            <label for="role{!! $role->id !!}" class="custom-control-label">{!! $role->display_name !!}</label>
                        </div>     
                    </div>
                @endforeach
            </div>

        </div>            
    </div>
    @else
    <div class="form-group">
        <label for="role">Roles</label>
        <div class="row">
                <div class="col-md-12">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input all" type="checkbox" id="all" onclick="cek()">
                        <label for="all" class="custom-control-label">Check All</label>
                    </div>     
                </div>
                <hr>
         @foreach ($roles as $role)
                <div class="col-md-6">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input check" type="checkbox" name="role[]" id="role{!! $role->id !!}" value="{!! $role->id !!}">
                        <label for="role{!! $role->id !!}" class="custom-control-label">{!! $role->display_name !!}</label>
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

    function cek() {
        if ($('#all').is(':checked')) {
            $('.check').prop('checked',true);
        } else {
            $('.check').prop('checked',false);
        }
    }
</script>
