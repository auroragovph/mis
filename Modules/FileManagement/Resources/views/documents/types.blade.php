<div class="col-md-4">
    <div class="card card-custom card-stretch gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 mt-5">
            <h3 class="card-title align-items-start flex-column text-dark">
                <span class="font-weight-bolder text-dark">Document Types</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Select document type</span>
            </h3>
           
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-2">
            <div class="form-group">
                <select class="form-control select2" data-live-search="true" data-size="5" name="param" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="" selected hidden></option>
                    <option value="{{ route('fms.afl.index') }}">Application For Leave (AFL)</option>
                    <option value="{{ route('fms.cafoa.index') }}">Certification On Appropriations, Funds And Obligation Of Allotment (CAFOA)</option>
                    {{-- <option value="{{ route('fms.obr.index') }}">Obligation Request (OBR)</option> --}}
                    <option value="{{ route('fms.travel.itinerary.index') }}">Itinerary of Travel </option>
                    <option value="{{ route('fms.procurement.request.index') }}">Purchase Request (PR) </option>
                    <option value="{{ route('fms.procurement.order.index') }}">Purchase Order (PO)</option>
                    <option value="{{ route('fms.travel.order.index') }}">Travel Order (TO)</option>
                </select>
            </div>
        </div>
        <!--end::Body-->
    </div>
</div>