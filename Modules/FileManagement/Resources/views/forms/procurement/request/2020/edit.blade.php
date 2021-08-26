@extends('filemanagement::layouts.master')



@section('page-title')
    Purchase Request
@endsection

@section('toolbar')

@endsection

@section('content')
<div class="row row-cards">
    <div class="col-md-8">
        <x-ui.card title="Purchase Request Edit Form">
            <form class="form" method="POST" action="{{ route('fms.procurement.request.update', $pr->id) }}">
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
                        <x-ui.form.text-area label="Purpose" name="purpose" required>
                            {{ $pr->purpose }}
                        </x-ui.form.text-area>
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="col-md-6">
                        <x-ui.form.text-area label="Particulars" name="particulars" required>
                            {{ $pr->particulars }}
                        </x-ui.form.text-area>
                    </div>
                    <!--end::Group-->
                </div>
    
                <div id="kt_repeater_1">
                    <div class="form-group row">
                        <div data-repeater-list="lists" class="col-lg-12">
                            @foreach ($pr->lists as $list)
                                <div data-repeater-item="" class="form-group row">
                                    <hr>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Stock Number:" :value="$list['stock']" type="text"
                                                    name="stock" />
    
                                            </div>
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Unit:" :value="$list['unit']" type="text" name="unit" />
    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Quantity:" type="number" :value="$list['quantity']" name="quantity"
                                                min="0" />
    
                                            </div>
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Item Cost:" type="number" :value="$list['amount']" name="amount" min="0"
                                                step="0.01" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <x-ui.form.text-area label="Item Description" name="description" required>
                                                    {{ $list['description'] }}
                                                </x-ui.form.text-area>
    
                                            </div>
                                            <div class="col-12 text-center">
                                                <a href="javascript:;" data-repeater-delete=""
                                                    class="btn btn-sm btn-block btn-danger">
                                                    <x-ui.widget.icon icon="trash" />
                                                    Delete this row
                                                </a>
                                            </div>
                                        </div>
    
    
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
    
    
                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.choices label="Requesting Officer" name="requesting" required>
                            @foreach ($employees->where('division_id', auth_division()) as $employee)
                                <option {{ sh($employee->id, $pr->signatories['requesting']['id'] ?? null) }}
                                    value="{{ $employee->id }}">
                                    {{ name_helper($employee->name) }}</option>
                            @endforeach
                        </x-ui.form.choices>
    
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="col-md-6">
                        <x-ui.form.choices label="Treasury" name="treasury" required>
                            @foreach ($employees->where('division_id', config('constants.office.TREASURY')) as $employee)
                                <option {{ sh($employee->id, $pr->signatories['treasury']['id'] ?? null) }}
                                    value="{{ $employee->id }}">
                                    {{ name_helper($employee->name) }}
                                </option>
                            @endforeach
                        </x-ui.form.choices>
                    </div>
                    <!--end::Group-->
    
                </div>
    
    
                <x-ui.form.choices label="Liaison Officer" name="liaison" required>
                    @foreach ($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                        <option {{ sh($employee->id, $pr->document->liaison_id) }} value="{{ $employee->id }}">
                            {{ name_helper($employee->name) }}</option>
                    @endforeach
                </x-ui.form.choices>
    
                <hr>
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
