@extends('fms::layouts.master')

@section('page-pretitle', 'Procurement')
@section('page-title', 'Purchase Request')

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <x-ui.card title="Request Form">
                <x-ui.form.ajax method="POST" action="{{ route('fms.procurement.request.store') }}">


                    @if(request()->has('attachment'))
                        <input type="hidden" name="__attachment" value="{{ encrypt(request()->get('attachment')) }}">
                    @endif

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
                                            <input name="stock" type="text" class="form-control ">
                                        </td>
                                        <td>
                                            <input name="unit" readonly type="text" class="form-control input-unit">
                                        </td>
                                        <td>
                                            <select type="text" class="form-control tom-select-pr">
                                                <option value="">{{ 'Select from the list' }}</option>
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
                                            <textarea name="description" class="form-control "
                                                rows="1"></textarea>
                                        </td>
                                        <td>
                                            <input name="quantity" type="number" class="form-control ">
                                        </td>
                                        <td>
                                            <input name="cost" readonly type="text" class="form-control input-cost">
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


                            <x-ui.form.select-tom label="Requesting Officer" name="requesting" required>

                                @foreach ($employees->where('office_id', authenticated('office_id')) as $employee)
                                    <option value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                                @endforeach

                            </x-ui.form.select-tom>



                        </div>
                        <!--end::Group-->

                        <!--begin::Group-->
                        <div class="col-md-6">
                            <x-ui.form.select-tom label="Treasury" name="treasury" required>

                                @foreach ($employees->where('office_id', \OfficeEnum::TREASURY->value) as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ name($employee->name) }}
                                    </option>
                                @endforeach

                            </x-ui.form.select-tom>
                        </div>
                        <!--end::Group-->


                    </div>

                    {{-- @if (!$is_attachment) --}}
                    <x-ui.form.select-tom label="Liaison Officer" name="liaison" required>
                        @foreach ($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                            <option value="{{ $employee->id }}">
                                {{ name($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.select-tom>
                    {{-- @endif --}}

                    <button type="submit" class="btn btn-primary" name="submitButton">Submit</button>
                </x-ui.form.ajax>
            </x-ui.card>
        </div>
    </div>
@endsection


@once


    @push('js-lib')

        <script src="{{ mix('libraries/jquery/jquery.min.js') }}"></script>
        <script src="{{ mix('libraries/repeater/repeater.min.js') }}"></script>
    @endpush
@endonce


@push('js-custom')
   <script src="{{ mix('js/modules/FileManagement/procurement/request/create.js') }}"></script>
@endpush
