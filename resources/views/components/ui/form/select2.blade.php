<select class="select2 form-control form-control-sm" name="state">
    <option value="AL">Alabama</option>

</select>

@once
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('js-lib')
        <script src="/libs/jquery/jquery.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce


@push('js-custom')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
