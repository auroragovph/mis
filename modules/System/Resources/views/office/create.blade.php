<x-ui.card title="Create new Office">
    <form action="{{ route('sys.admin.office.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Name" name="name" required />
            </div>
            <div class="col-md-6">
                <x-ui.form.input label="Alias" name="alias" />
            </div>
        </div>

        <x-ui.form.select2 label="Department Head" name="department_head" required>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
            @endforeach
        </x-ui.form.select2>

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</x-ui.card>