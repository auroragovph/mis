@extends('layouts.tabler.horizontal')


@section('page-title')
    CAFOA Update Form
@endsection

@section('toolbar')

@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-md-8">
            <x-ui.card title="CAFOA Form">
                <form class="form" method="POST" action="{{ route('fms.cafoa.update', $cafoa->id) }}">
                    @csrf
                    @method('put')
                    <x-ui.form.input label="Obligation Number" name="number" :value="$cafoa->number" />

                    <div class="row">
                        <div class="col-md-6">
                            <x-ui.form.input label="Payee" name="payee" value="{{ $cafoa->payee }}" required />

                        </div>
                        <!--end::Group-->
                        <!--begin::Group-->
                        <div class="col-md-6">
                            <x-ui.form.choices label="Requesting Officer" name="requester" required>
                                @foreach ($employees->where('division_id', auth()->user()->employee->division_id) as $employee)
                                    <option {{ sh($employee->id, $cafoa->signatories['requester']['id']) }}
                                        value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                                @endforeach
                            </x-ui.form.choices>
                        </div>
                        <!--end::Group-->
                    </div>

                    <div id="kt_repeater_1">
                        <div class="form-group row">
                            <div data-repeater-list="lists" class="col-lg-12">
                                @foreach ($cafoa->lists as $list)
                                    <div data-repeater-item="" class="form-group row align-items-center">
                                        <div class="col-md-2">
                                            <x-ui.form.input label="Function:" name="function"
                                                value="{{ $list['function'] ?? '' }}" />
                                        </div>

                                        <div class="col-md-3">
                                            <x-ui.form.input label="Allotment Class:" name="allotment"
                                                value="{{ $list['allotment'] ?? '' }}" />
                                        </div>

                                        <div class="col-md-3">
                                            <x-ui.form.input label="Expense Code:" name="code"
                                                value="{{ $list['code'] ?? '' }}" />
                                        </div>

                                        <div class="col-md-3">
                                            <x-ui.form.input step="0.01" type="number" label="Amount:" name="amount"
                                                value="{{ $list['amount'] ?? 0 }}" />
                                        </div>

                                        <div class="col-md-1 text-center my-auto">
                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-danger mt-3">
                                            <x-ui.icon icon="trash" class="m-0"/></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <a href="javascript:;" data-repeater-create=""
                                    class="btn btn-sm font-weight-bolder btn-primary">
                                    <i class="fas fa-plus"></i> Add New Row</a>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <x-ui.form.textarea name="particulars" label="Particulars" required>
                        {{ $cafoa->particulars }}
                    </x-ui.form.textarea>



                    <div class="row">
                        <div class="col-md-4">

                            <x-ui.form.choices label="Budget" name="budget" required>
                                @foreach($employees->where('division_id', config('constants.office.BUDGET')) as $employee)
                      <option {{ sh($employee->id, $cafoa->signatories['budget']['id']) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                  @endforeach
                            </x-ui.form.choices>

                        </div>
                        <!--end::Group-->
                        <!--begin::Group-->
                        <div class="col-md-4">
                            <x-ui.form.choices label="Treasury" name="treasury" required>
                                @foreach($employees->where('division_id', config('constants.office.TREASURY')) as $employee)
                                <option {{ sh($employee->id, $cafoa->signatories['treasurer']['id']) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                            </x-ui.form.choices>
                        </div>
                        <!--end::Group-->
                        <!--begin::Group-->
                        <div class="col-md-4">
                            <x-ui.form.choices label="Accountant" name="accountant" required>
                                @foreach($employees->where('division_id', config('constants.office.ACCOUNTING')) as $employee)
                                <option {{ sh($employee->id, $cafoa->signatories['accountant']['id']) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                            </x-ui.form.choices>
                        </div>
                        <!--end::Group-->
                    </div>

                    <x-ui.form.choices label="Liaison Officer" name="liaison" required >
                        @foreach($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                            <option {{ sh($employee->id, $cafoa->document->liaison_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices> 

                  

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
