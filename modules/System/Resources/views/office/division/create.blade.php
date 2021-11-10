<x-ui.card title="Create new Division">
    <form action="{{ route('sys.admin.division.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Name" name="name" required />
            </div>
            <div class="col-md-6">
                <x-ui.form.input label="Alias" name="alias" />
            </div>
        </div>

        <x-ui.form.select2 label="Office" name="office" required>
            @foreach($offices as $office)
                <option value="{{ $office->id }}">{{ office_name($office) }}</option>
            @endforeach
        </x-ui.form.select2>

        <x-ui.form.select2 label="Division Head" name="division_head" required>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
            @endforeach
        </x-ui.form.select2>

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</x-ui.card>