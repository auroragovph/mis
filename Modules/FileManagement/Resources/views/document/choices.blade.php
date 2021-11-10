<x-ui.card>
    <div class="mb-3">
        <x-ui.form.choices onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="{{ route('fms.afl.index') }}">Application For Leave (AFL)</option>
            <option value="{{ route('fms.cafoa.index') }}">Certification On Appropriations, Funds And Obligation Of Allotment (CAFOA)</option>

            <option value="{{ route('fms.procurement.request.index') }}">Procurement - Purchase Request (PR) </option>
            <option value="{{ route('fms.procurement.order.index') }}">Procurement - Purchase Order (PO)</option>

            {{-- TRAVEL --}}
            <option value="{{ route('fms.travel.itinerary.index') }}">Travel - Itinerary of Travel </option>
            <option value="{{ route('fms.travel.order.index') }}">Travel - Travel Order (TO)</option>
        </x-ui.form.choices>
    </div>
</x-ui.card>
