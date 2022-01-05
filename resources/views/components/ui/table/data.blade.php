<div class="card">
    @empty(!$title)
        <div class="card-header">
            <h3 class="card-title">
                {{ $title }}
            </h3>
        </div>
    @endempty

    <div class="table-responsive">
        <table id="datatable-{{ $rand }}" class="table card-table table-vcenter text-nowrap datatable">
            {{ $slot }}
        </table>
    </div>
</div>


@once
    @push('styles')
        <link rel="stylesheet" href="/libs/datatable/style.css">
    @endpush

    @push('js-lib')
        <script src="/libs/datatable/simple-datatables.js"></script>
    @endpush
@endonce




@push('js-custom')
<script>
    const table = new simpleDatatables.DataTable("#datatable-{{ $rand }}")
</script>
@endpush
