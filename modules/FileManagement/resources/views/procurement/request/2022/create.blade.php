@extends('fms::layouts.master')


@section('page-pretitle', 'Procurement')
@section('page-title', 'Purchase Request')




@section('content')
    <div class="row row-cards">
        <div class="col-md-8">
            <x-ui.card title="Request Form">
                <form id="ajax_form" action="{{ route('fms.procurement.request.store') }}" method="POST">
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


                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm" id="kt_repeater_1">
                                <thead>
                                    <tr>
                                        <th width="10%">SN</th>
                                        <th width="7%">UNIT</th>
                                        <th width="30%">ITEM</th>
                                        <th width="30%">Description</th>
                                        <th width="8%">Quantity</th>
                                        <th width="10%">Cost</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody data-repeater-list="lists">
                                    <tr data-repeater-item="">
                                        <td>
                                            <input name="stock" type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input name="unit" disabled type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <select class="select2 form-control form-control-sm" name="item"
                                                style="width: 100%">
                                                <option></option>
                                                @foreach ($ppmps->children as $ppmp)

                                                    @if ($ppmp->schedule === null)
                                                        @continue
                                                    @endif

                                                    <option
                                                        data-json="{{ collect($ppmp)->only(['id', 'unit', 'unit_cost']) }}"
                                                        value="{{ $ppmp->id }}">{{ $ppmp->description }}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td>
                                            <textarea name="description" class="form-control form-control-sm"
                                                rows="1"></textarea>
                                        </td>
                                        <td>
                                            <input name="quantity" type="number" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input name="cost" disabled type="text" class="form-control form-control-sm">
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:;" data-repeater-delete="" class="text-danger"
                                                title="Delete this row">
                                                <x-ui.icon icon="trash" />
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <a href="javascript:;" data-repeater-create class="btn btn-primary btn-sm">Add
                                                New Row</a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">


                            <x-ui.form.choices label="Requesting Officer" name="requesting" required>

                                @foreach ($employees->where('office_id', authenticated('office_id')) as $employee)
                                    <option value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                                @endforeach

                            </x-ui.form.choices>



                        </div>
                        <!--end::Group-->

                        <!--begin::Group-->
                        <div class="col-md-6">
                            <x-ui.form.choices label="Treasury" name="treasury" required>

                                @foreach ($employees->where('office_id', \OfficeEnum::TREASURY->value) as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ name($employee->name) }}
                                    </option>
                                @endforeach

                            </x-ui.form.choices>
                        </div>
                        <!--end::Group-->


                    </div>

                    {{-- @if (!$is_attachment) --}}
                    <x-ui.form.choices label="Liaison Officer" name="liaison" required>
                        @foreach ($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                            <option value="{{ $employee->id }}">
                                {{ name($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices>
                    {{-- @endif --}}

                    <button type="submit" class="btn btn-primary" name="submitButton">Submit</button>
                </form>
            </x-ui.card>
        </div>
        <div class="col-md-4">
            <x-ui.card title="Instructions" />
        </div>
    </div>


    <x-include.form.ajax />
@endsection


@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('js-lib')
        <script src="/libs/jquery/jquery.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="/libs/jquery-repeater/repeater.js"></script>
    @endpush
@endonce


@push('js-custom')
    <script>
        $(document).ready(function() {
            let firstRow = $('.select2').select2({
                placeholder: "Select an item",
            })
            firstRow.on('select2:select', function(e) {
                var tr = $(this.parentElement.parentElement)
                var data = e.params.data;
                var list = JSON.parse(data.element.dataset.json)
                tr.children().eq(5).children().first().val(list.unit_cost)
                tr.children().eq(1).children().first().val(list.unit)
            });

        });



        $('#kt_repeater_1').repeater({
            initEmpty: false,
            isFirstItemUndeletable: true,
            show: function() {
                let select2 = $(this).find("select")
                let s2I = select2.select2({
                    placeholder: "Select an item",
                });
                s2I.on('select2:select', function(e) {
                    var tr = $(this.parentElement.parentElement)
                    var data = e.params.data;
                    var list = JSON.parse(data.element.dataset.json)
                    tr.children().eq(5).children().first().val(list.unit_cost)
                    tr.children().eq(1).children().first().val(list.unit)
                });
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endpush
