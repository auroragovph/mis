
@switch(auth()->user()->employee->division_id)

    @case(config('constants.office.HRMO'))
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('hrm.dashboard') }}">
                    <div class="card bg-gradient-maroon p-2 text-center">
                        <img class="mx-auto d-block" src="{{ asset('images/human-resources.png') }}" alt="" width="100px" height="100px">
                        <h6 class="mt-3">Human Resource Management</h6>
                    </div>
                </a>
            </div>
        </div>
    @break

    
    
    @default
        @break
@endswitch


