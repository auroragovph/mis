@extends('fms::layouts.master')


@section('page-title', 'Purchase Order')
@section('page-pretitle', 'Procurement')

@section('content')
    <div class="row row-cards">
        <div class="col-md-8">
            <x-ui.card title="Purchase Order Form">
                <form id="ajax_form" class="form" method="POST" action="{{ route('fms.procurement.order.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-ui.form.input label="Number" name="number" />
                        </div>
                        <div class="col-md-6">
                            <x-ui.form.input label="Mode of Procurement" name="mode_of_procurement" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-ui.form.tag name="pr_number" label="PR Number/s" :value="$pr_numbers->implode(',')" />
                        </div>
                    </div>

                    <x-ui.form.choices label="Supplier" name="supplier" required>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->name }}</option>
                        @endforeach
                    </x-ui.form.choices>

                    <div class="row">
                        <div class="col-md-6">
                            <x-ui.form.input label="Place of Delivery" name="delivery_place" required />
                        </div>
                        <!--end::Group-->
                        <!--begin::Group-->
                        <div class="col-md-6">
                            <x-ui.form.input label="Date of Delivery" type="date" name="delivery_date" required />
                        </div>
                        <!--end::Group-->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <x-ui.form.input label="Delivery Term" name="delivery_term" required />
                        </div>
                        <!--end::Group-->
                        <!--begin::Group-->
                        <div class="col-md-6">
                            <x-ui.form.input label="Payment Term" name="delivery_payment" />
                        </div>
                        <!--end::Group-->
                    </div>

                    <div id="kt_repeater_1">
                        <div class="form-group row">
                            <div data-repeater-list="lists" class="col-lg-12">
                                @if($prs->isEmpty())
                                <div data-repeater-item="" class="form-group row">
                                    <hr>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Stock Number:"
                                                    type="text" name="stock" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Unit:" type="text"
                                                    name="unit" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Quantity:"
                                                    type="number" name="quantity" min="0" />

                                            </div>
                                            <div class="col-md-6">
                                                <x-ui.form.input label="Item Cost:"
                                                    type="number" name="amount" min="0" step="0.01" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <x-ui.form.text-area label="Item Description" name="description"
                                                    required />

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
                                @else
                                @foreach ($prs as $pr)
                                    @foreach ($pr->formable->lists as $list)
                                        <div data-repeater-item="" class="form-group row">
                                            <hr>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <x-ui.form.input :value="$list['stock']" label="Stock Number:"
                                                            type="text" name="stock" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <x-ui.form.input :value="$list['unit']" label="Unit:" type="text"
                                                            name="unit" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <x-ui.form.input :value="$list['quantity']" label="Quantity:"
                                                            type="number" name="quantity" min="0" />

                                                    </div>
                                                    <div class="col-md-6">
                                                        <x-ui.form.input :value="$list['amount']" label="Item Cost:"
                                                            type="number" name="amount" min="0" step="0.01" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <x-ui.form.text-area label="Item Description" name="description"
                                                            required>{{ $list['description'] }}</x-ui.form.text-area>

                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <a href="javascript:;" data-repeater-delete=""
                                                            class="btn btn-sm btn-block btn-danger">
                                                            <x-ui.icon icon="trash" />
                                                            Delete this row
                                                        </a>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <a href="javascript:;" data-repeater-create="" class="btn btn-sm btn-primary">
                                    <x-ui.icon icon="plus" /> Add New Row
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <x-ui.form.choices label="Approving Officer" name="approver">
                        @foreach ($employees as $employee)
                            <option
                                value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices>

                    <x-ui.form.text-area name="particulars" label="Particulars" required />

                    <hr>

                    <button class="btn btn-primary" type="submit">Save Changes</button>

                </form>

            </x-ui.card>
        </div>
        <div class="col-md-4">
            <x-ui.card title="Instructions" />
        </div>
    </div>

<x-include.form.ajax />
@endsection



@push('js-lib')
    <script src="/libs/jquery/jquery.js"></script>
    <script src="/libs/jquery-repeater/repeater.js"></script>
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
