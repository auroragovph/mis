@extends('filemanagement::layouts.master')



@section('page-title')
    Purchase Order Update Form
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-md-8">
            <x-ui.card title="Order Form">
                <form class="form" method="POST" action="{{ route('fms.procurement.order.update', $po->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <x-ui.form.input label="Number" name="number" :value="$po->number" />
                        </div>
                        <div class="col-md-6">
                            <x-ui.form.input label="Mode of Procurement" name="mode_of_procurement" :value="$po->mode_of_procurement" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-ui.form.tag name="pr_number" label="PR Number/s" :value="implode(',', $po->pr_number)" />
                        </div>
                    </div>

                    <x-ui.form.choices label="Supplier" name="supplier" required>
                        @foreach ($suppliers as $supplier)
                            <option {{ sh($supplier->id, $po->supplier_id) }} value="{{ $supplier->id }}">
                                {{ $supplier->name }}</option>
                        @endforeach
                    </x-ui.form.choices>

                    <div class="row">
                        <div class="col-md-6">
                            <x-ui.form.input label="Place of Delivery" name="delivery_place"
                                :value="$po->delivery['place'] ?? ''" required />
                        </div>
                        <!--end::Group-->
                        <!--begin::Group-->
                        <div class="col-md-6">
                            <x-ui.form.input label="Date of Delivery" type="date" name="delivery_date"
                                :value="$po->delivery['date'] ?? ''" required />
                        </div>
                        <!--end::Group-->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <x-ui.form.input label="Delivery Term" name="delivery_term" :value="$po->delivery['term'] ?? ''"
                                required />
                        </div>
                        <!--end::Group-->
                        <!--begin::Group-->
                        <div class="col-md-6">
                            <x-ui.form.input label="Payment Term" name="delivery_payment"
                                :value="$po->delivery['payment'] ?? ''" />
                        </div>
                        <!--end::Group-->
                    </div>

                    <div id="kt_repeater_1">
                        <div class="form-group row">
                            <div data-repeater-list="lists" class="col-lg-12">
                                @foreach($po->lists as $list)
                                    <div data-repeater-item="" class="form-group row">
                                        <hr>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-ui.form.input :value="$list['stock']" label="Stock Number:" type="text" name="stock" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-ui.form.input :value="$list['unit']" label="Unit:" type="text" name="unit" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-ui.form.input :value="$list['quantity']" label="Quantity:" type="number" name="quantity" min="0" />
            
                                                </div>
                                                <div class="col-md-6">
                                                    <x-ui.form.input :value="$list['amount']" label="Item Cost:" type="number" name="amount" min="0" step="0.01" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <x-ui.form.text-area label="Item Description" name="description" required>{{ $list['description'] }}</x-ui.form.text-area>
            
                                                </div>
                                                <div class="col-12 text-center">
                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-block btn-danger">
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
                                    <x-ui.widget.icon icon="plus" /> Add New Row</a>
                            </div>
                        </div>
                    </div>
        
                    <hr>

                    <x-ui.form.choices label="Approving Officer" name="approver">
                        @foreach($employees as $employee)
                                <option {{ sh($employee->id, $po->signatories['approver']['id'] ?? null) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices>

                    <x-ui.form.text-area name="particulars" label="Particulars" required>
                        {{$po->document->purchase_request->purpose}}
                     </x-ui.form.text-area>

                     <hr>

                     <button class="btn btn-primary" type="submit">Save Changes</button>

                </form>

            </x-ui.card>
        </div>
        <div class="col-md-4">
            @include('filemanagement::forms.procurement.order.2020.instructions')
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
