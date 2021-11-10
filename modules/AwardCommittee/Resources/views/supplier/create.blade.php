<x-ui.card title="Supplier Form">
  <form id="ajax_form" action="{{ route('bac.supplier.store') }}" method="POST">
      @csrf
      <div class="row">
          <div class="col-md-6">
              <x-ui.form.input label="Business Name" name="name" required />
          </div>
          <div class="col-md-6">
              <x-ui.form.input label="Owner Name" name="owner" required />
          </div>
      </div>
      <x-ui.form.input label="Address" name="address" />
      <x-ui.form.input label="TIN" name="tin" />

      <button class="btn btn-primary">Save</button>
  </form>
</x-ui.card>