<x-ui.modal title="New Supplier">
    <form id="ajax_form" method="POST" action="{{ route('fms.procurement.supplier.store') }}">
        @csrf
        <div class="row">
            <div class="col-6">
                <x-ui.form.input label="Business Name" name="name" />
            </div>
            <div class="col-6">
                <x-ui.form.input label="Owner" name="owner" />
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <x-ui.form.input label="Address" name="address" />
            </div>
            <div class="col-4">
                <x-ui.form.input label="TIN" name="tin" />
            </div>
        </div>

        <button class="btn btn-primary">Submit</button>
    </form>

    <x-include.form.ajax />

</x-ui.modal>
