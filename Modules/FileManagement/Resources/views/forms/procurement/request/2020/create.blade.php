@extends('filemanagement::layouts.master')


@section('page-pretitle', 'Procurement')
@section('page-title', 'Purchase Request')




@section('content')
<div class="row row-cards">
<div class="col-md-8">
    <x-ui.card title="Request Form">
        <form action="{{ route('fms.procurement.request.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-ui.form.input label="Fund" type="text" name="fund" value="{{ old('fund') }}" required />
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <x-ui.form.input label="FPP" type="text" name="fpp" value="{{ old('fpp') }}" required />
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <!--begin::Group-->
                <div class="col-md-6">
                    <x-ui.form.text-area label="Purpose" name="purpose" value="{{ old('purpose') }}" required />
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <x-ui.form.text-area label="Particulars" name="particulars" value="{{ old('particulars') }}"
                        required />
                </div>
                <!--end::Group-->
            </div>

            <div id="kt_repeater_1">
                <div class="form-group row">
                    <div data-repeater-list="lists" class="col-lg-12">
                        <div data-repeater-item="" class="form-group row">
                            <hr>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-ui.form.input label="Stock Number:" type="text" name="stock" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-ui.form.input label="Unit:" type="text" name="unit" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-ui.form.input label="Quantity:" type="number" name="quantity" min="0" />

                                    </div>
                                    <div class="col-md-6">
                                        <x-ui.form.input label="Item Cost:" type="number" name="amount" min="0" step="0.01" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12">
                                        <x-ui.form.text-area label="Item Description" name="description" required />

                                    </div>
                                    <div class="col-12 text-center">
                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-block btn-danger">
                                            <x-ui.widget.svg>
                                                <line x1="4" y1="7" x2="20" y2="7" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </x-ui.widget.svg>
                                            Delete this row
                                        </a>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
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

            <div class="row">
                <div class="col-md-6">


                    <x-ui.form.choices label="Requesting Officer" name="requesting" required>

                        @foreach ($employees->where('division_id', auth_division()) as $employee)
                            <option {{ sh($employee->id, old('requesting')) }} value="{{ $employee->id }}">
                                {{ name_helper($employee->name) }}</option>
                        @endforeach

                    </x-ui.form.choices>



                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-6">
                    <x-ui.form.choices label="Treasury" name="treasury" required>
                        @php($treasury_head_id = $heads->where('id', config('constants.office.TREASURY'))->pluck('head_id')->first())
                        @foreach ($employees->where('division_id', config('constants.office.TREASURY')) as $employee)
                            <option {{ sh($employee->id, old('treasury')) }}
                                {{ sh($treasury_head_id, $employee->id) }} value="{{ $employee->id }}">
                                {{ name_helper($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices>
                </div>
                <!--end::Group-->


            </div>


            @if (!request()->has('attachment') and request()->get('attachment') !== true)

                <x-ui.form.choices label="Liaison Officer" name="liaison" required>
                    @foreach ($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                        <option {{ sh($employee->id, old('liaison')) }} value="{{ $employee->id }}">
                            {{ name_helper($employee->name) }}</option>
                    @endforeach
                </x-ui.form.choices>
            @endif

            <button type="submit" class="btn btn-primary" name="submitButton">Submit</button>
        </form>
    </x-ui.card>
</div>
<div class="col-md-4">
    <x-ui.card title="Instructions" />
</div>
</div>
@endsection

@push('js-lib')
<script src="/tabler/libs/jquery/jquery.js"></script>
<script src="/tabler/libs/jquery-repeater/repeater.js"></script>
@endpush


@push('js-custom')
<script>
    $('#kt_repeater_1').repeater({
        initEmpty: false,
        isFirstItemUndeletable: true,
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });
</script>
@endpush
