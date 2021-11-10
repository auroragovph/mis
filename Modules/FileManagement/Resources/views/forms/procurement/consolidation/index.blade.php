@extends('layouts.master')


@section('page-title')
Purchase Request Consolidation
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
           
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fms.procurement.consolidate.check') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Document ID</label>
                        <select name="documents[]" class="form-control select2-tags" multiple></select>
                    </div>
                    <hr>
                    <button class="btn btn-primary"><i class="flaticon2-magnifier-tool"></i> Search</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script>
// init select 2 employees
$(".select2-tags").select2({
			tags: true
        });
</script>
@endsection


