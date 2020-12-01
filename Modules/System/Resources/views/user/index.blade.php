@extends('system::layouts.app')

@section('page-title')
Users
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('sys.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Office</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-1">Lists</h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#modal-default"><i class="fas fa-plus"></i> Create New User</a>
                   </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Office</th>
                      <th>Role</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                <td>{{ $user->id }}</td>
                                <td>{{ name_helper($user->employee->name) ?? '' }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ office_helper($user->employee->division) ?? '' }}</td>
                                <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                <td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
   
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div id="whirl" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create New User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <form id="user-create-form" action="{{ route('sys.user.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Employee</label>
                    <select class="form-control select2" name="employee" required style="width: 100%">
                        <option value="" selected hidden></option>
                      @foreach ($employees as $employee)
                          <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                      @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>


                <div class="form-group">
                  <label for="">Password</label>
                  <div class="row">
                    <div class="col-6">
                      <input type="password" name="pass" class="form-control" placeholder="Password">
                    </div>
                    <div class="col-6">
                      <input type="password" name="cpass" class="form-control" placeholder="Confirm Password">
                    </div>
                  </div>
              </div>


              <div class="form-group">
                <label for="">Role</label>
                <select class="form-control select2" name="role" required style="width: 100%">
                  <option value="" selected hidden></option>
                @foreach ($roles as $role)
                    <option>{{ $role->name }}</option>
                @endforeach
              </select>
            </div>



                <hr>

                <button type="submit" class="btn bg-gradient-primary">Submit</button>
            </form>
         
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection




@section('css-vendor')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/whirl/whirl.css') }}">

@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>  
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js")}}"></script>

@endsection

@section('js-custom')
<script src="{{ asset('js/system/user-create.js') }}"></script>
@endsection