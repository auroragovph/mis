@extends('layouts.master')


@section('page-title')
Application for Leave
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div class="d-flex align-items-center">

{{-- <!--begin::Button-->
<button type="button"data-toggle="modal" data-target="#exampleModal" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
    <i class="fal fa-plus"></i> New AFL
</button>
<!--end::Button--> --}}

<!--begin::Button-->
<a href="{{ route('fms.afl.create') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
    <i class="fal fa-plus"></i> New AFL
</a>
<!--end::Button-->


</div>
<!--end::Toolbar-->
@endsection

@section('content')
<!--begin::Card-->
<div class="card card-custom">
    <div class="card-body">
        <!--begin: Search Form-->
        <!--begin::Search Form-->
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="row align-items-center">
                        <div class="col-md-4 my-2 my-md-0">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!--end::Search Form-->
        <!--end: Search Form-->
        <!--begin: Datatable-->
        <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
        <!--end: Datatable-->
    </div>
</div>
<!--end::Card-->
{{-- 
<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="{{ route('fms.afl.create') }}" method="POST">
                @csrf
            <div class="modal-body">
               <div class="form-group">
                   <label for="">Employee</label>
                   <select name="employee" class="form-control select2" style="width: 100%;" required>
                       <option value=""></option>
                       @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                       @endforeach
                   </select>
               </div>
               <div class="form-group">
                <label for="">Type</label>
                <select name="type" class="form-control" required>
                    <option>Vacation</option>
                    <option>Sick</option>
                    <option>Maternity</option>
                    <option>Others</option>
                </select>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-warning font-weight-bold" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary font-weight-bold">Continue</button>
            </div>
            </form>
        </div>
    </div>
</div>
 --}}

@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/forms/afl/index.js') }}"></script>

@endsection


