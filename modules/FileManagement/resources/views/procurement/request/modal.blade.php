<div class="modal modal-blur fade" id="modal-ppmp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('fms.procurement.request.create') }}">
                <div class="modal-header">
                    <h5 class="modal-title">New Purchase Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-ui.form.choices label="PPMP Items" multiple name="items[]">
                        @foreach($ppmps->children as $ppmp)

                            @if($ppmp->schedule === null)
                                @continue
                            @endif

                            <option value="{{ $ppmp->id }}">{{ $ppmp->description }}</option>
                        @endforeach
                    </x-ui.form.choices>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto" >
                        <x-ui.icon icon="arrow-right" />
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
