@extends('system::layouts.app')

@section('page-title')
    Roles
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('root.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">User</li>
    <li class="breadcrumb-item active">ACL</li>
    <li class="breadcrumb-item active">Role</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Role List</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach($role->permissions->pluck('name') as $permission)
                                    <span class="badge bg-olive">{{ $permission }}</span>
                                    @endforeach
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Create New Role</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sys.acl.role.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" required>

                    </div>
                    <div class="form-group">
                        <label for="">Permissions</label>
                        <select multiple name="permissions[]" class="form-control select2" required>
                            <option></option>
                            @foreach($permissions as $permission)
                                <option>{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <button type="submit" class="btn bg-gradient-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection




@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    
@endsection

@section('js-custom')
<script>
$(function () {
    $(".select2").select2({
      placeholder: "Select from list"
  });
});
</script>
@endsection