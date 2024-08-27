@foreach ($roles as $role)
    <span class="badge bg-primary">{{ $role->display_name }}</span>
@endforeach
