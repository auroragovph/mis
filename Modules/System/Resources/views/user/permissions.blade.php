@extends('system::layouts.app')

@section('page-title')
    Permissions
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('sys.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permissions for {{ name_helper($user->employee, 'FMIL') }}</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->getAllPermissions() as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
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
                <h3 class="card-title">Add Permission</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sys.user.acl.store', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Permission</label>
                        <select name="permissions[]" class="form-control select2" multiple required>
                            <option value="" hidden></option>
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
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });
});
</script>    
@endsection