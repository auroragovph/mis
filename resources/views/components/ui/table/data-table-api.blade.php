@php
$rand = Str::random();
$api = $api ?? url()->current();
@endphp

<div class="card">
    @empty(!$title)
        <div class="card-header">
            <h3 class="card-title">
                {{ $title }}
            </h3>
        </div>
    @endempty

    <div class="table-responsive">

        <table id="datatable-{{ $rand }}" class="table card-table table-vcenter datatable"></table>

        <div id="skeleton-{{ $rand }}" class="text-center">
            <div class="skeleton-line"></div>
            <div class="skeleton-line"></div>
            <div class="skeleton-line"></div>
            <div class="skeleton-line"></div>
        </div>
        
    </div>
</div>


@once
    @push('styles')
        <link rel="stylesheet" href="/tabler/libs/datatable/style.css">
    @endpush

    @push('js-lib')
        <script src="/tabler/libs/datatable/simple-datatables.js"></script>
        <script src="/tabler/libs/axios/axios.min.js"></script>
    @endpush
@endonce


@push('js-custom')
    <script>
        axios({
            method: 'GET',
            url: '{{ $api."?_axios=".$rand }}',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
        }).then(response => {
            let data = response.data


            let table = new simpleDatatables.DataTable("#datatable-{{ $rand }}", {
                data: {
                    headings: (data['heading'] == undefined) ? Object.keys(data[0]) : data['heading'],
                    data: (data['heading'] == undefined) ? data.map(item => Object.values(item)) : data.data,
                },
            })

            // removing skeleton
            let skeleton = document.querySelector('#skeleton-{{ $rand }}');
            skeleton.classList.add('d-none');
        });
    </script>
@endpush
