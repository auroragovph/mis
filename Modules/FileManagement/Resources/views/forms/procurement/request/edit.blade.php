@extends('layouts.master')


@section('page-title')
    Purchase Request
@endsection

@section('toolbar')

@endsection

@section('content')
    <x-ui.card title="Purchase Request Edit Form">
        <form class="form" id="kt_form" method="POST" action="{{ route('fms.procurement.request.update', $pr->id) }}">
            @method('PATCH')
            @csrf

            <x-ui.form.input label="Number" type="text" name="number" :value="$pr->number" />


            <div class="row">
                <div class="col-md-6">
                    <x-ui.form.input label="Fund" type="text" name="fund" :value="$pr->fund" required />
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <x-ui.form.input label="FPP" type="text" name="fpp" :value="$pr->fpp" required />
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <!--begin::Group-->
                <div class="col-md-6">
                    <x-ui.form.text-area label="Purpose" name="purpose" :value="$pr->purpose" required />
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <x-ui.form.text-area label="Particulars" name="particulars" :value="$pr->particulars" required />
                </div>
                <!--end::Group-->
            </div>

            <hr>

            <div id="kt_repeater_1">
                <div class="form-group row">
                    <div data-repeater-list="lists" class="col-lg-12">
                        @foreach ($pr->lists as $list)
                            <div data-repeater-item="" class="form-group row align-items-center">
                                <div class="col-md-3">
                                    <x-ui.form.input label="Stock Number:" :value="$list['stock']" type="text"
                                        name="stock" />
                                </div>
                                <div class="col-md-3">
                                    <x-ui.form.input label="Unit:" :value="$list['unit']" type="text" name="unit" />
                                </div>

                                <div class="col-md-3">
                                    <x-ui.form.input label="Quantity:" type="number" :value="$list['quantity']"
                                        name="quantity" min="0" />
                                </div>

                                <div class="col-md-3">
                                    <x-ui.form.input label="Item Cost:" type="number" :value="$list['amount']" name="amount"
                                        min="0" step="0.01" />
                                </div>

                                <div class="col-md-12">
                                    <x-ui.form.text-area label="Item Description" :value="$list['description']"
                                        name="description" required />
                                </div>

                                <div class="col-md-1">
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm font-weight-bolder btn-danger mt-5">
                                        <i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i>Add New Row</a>
                    </div>
                </div>
            </div>

            <hr>

            <h4>Signatories</h4>


            <div class="row">
                <div class="col-md-4">
                    <x-ui.form.select2 label="Requesting Officer" name="requesting" required>
                        @foreach ($employees->where('division_id', auth_division()) as $employee)
                            <option {{ sh($employee->id, $pr->requesting_id) }} value="{{ $employee->id }}">
                                {{ name_helper($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.select2>

                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-4">
                    <x-ui.form.select2 label="Treasury" name="treasury" required>
                        @foreach ($employees->where('division_id', config('constants.office.PTO')) as $employee)
                            <option {{ sh($employee->id, $pr->treasury_id) }} value="{{ $employee->id }}">
                                {{ name_helper($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.select2>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-4">
                    <x-ui.form.select2 label="Approving Officer" name="approving" required>
                        @foreach ($employees->where('division_id', auth_division()) as $employee)
                            <option {{ sh($employee->id, $pr->approving_id) }} value="{{ $employee->id }}">
                                {{ name_helper($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.select2>
                </div>
                <!--end::Group-->
            </div>



            <hr>

            <x-ui.form.select2 label="Liaison Officer" name="liaison" required>
                @foreach ($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                    <option {{ sh($employee->id, $pr->document->liaison_id) }} value="{{ $employee->id }}">
                        {{ name_helper($employee->name) }}</option>
                @endforeach
            </x-ui.form.select2>

            <hr>
            <button type="submit" class="btn btn-primary" name="submitButton">Submit</button>
        </form>
    </x-ui.card>
@endsection


@section('css-vendor')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Repeater -->
    <script src="{{ asset('adminlte/plugins/repeater/repeater.js') }}"></script>
@endsection

@section('js-custom')
    <script src="{{ asset('js/Modules/FileManagement/pages/forms/procurement/request/create.js') }}"></script>
@endsection
