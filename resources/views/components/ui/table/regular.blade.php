<div class="card">
    @empty(!$title)
        <div class="card-header">
            <h3 class="card-title">
                {{ $title }}
            </h3>
        </div>
    @endempty

    <div class="table-responsive">
        <table class="table card-table table-vcenter {{ $className ?? '' }}">
            {{ $slot }}
        </table>
    </div>
</div>
