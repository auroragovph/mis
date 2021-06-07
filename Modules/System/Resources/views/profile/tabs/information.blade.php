<x-ui.card title="Personal Information" class="tab-pane fade show active" id="informationTab" role="tabpanel" aria-labelledby="informationTab-tab">
    <form class="form" method="POST" action="{{ route('sys.profile.information') }}">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input
                    name="fname" 
                    label="First Name" 
                    value="{{ authenticated()->employee->name['fname'] }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input
                    name="lname" 
                    label="Last Name" 
                    value="{{ authenticated()->employee->name['lname'] }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input
                    name="mname" 
                    label="Middle Name" 
                    value="{{ authenticated()->employee->name['mname'] }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-3">
                <x-ui.form.input
                    name="sname" 
                    label="Suffix" 
                    value="{{ authenticated()->employee->name['sname'] }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->

            <!--begin::Group-->
            <div class="col-md-3">
                <x-ui.form.input
                    name="tname" 
                    label="Title" 
                    value="{{ authenticated()->employee->name['title'] }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
        </div>

        <div class="row">
            <div class="col-md-4">
                <x-ui.form.input
                    name="birthday" 
                    label="Birthday" 
                    value="{{ authenticated()->employee->info['birthday'] }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-8">
                <x-ui.form.input
                    name="address" 
                    label="Address" 
                    value="{{ authenticated()->employee->info['address'] }}"   
                />
            </div>
            <!--end::Group-->
        </div>

        <div class="row">
            <div class="col-md-4">

                <x-ui.form.select label="Civil Status" name="civil" required disabled>
                    <option value="">---SELECT---</option>
                    @foreach(config('static-lists.civilStatus') as $cs)
                        <option {{ sh($cs, authenticated()->employee->info['civilStatus']) }}>{{ $cs }}</option>
                    @endforeach
                </x-ui.form.select> 

            </div>
            <!--end::Group-->

            <!--begin::Group-->
            <div class="col-md-4">

                <x-ui.form.input
                    name="sex" 
                    label="Sex" 
                    value="{{ authenticated()->employee->info['gender'] }}"
                    disabled
                />
                
            </div>
            <!--end::Group-->

            <!--begin::Group-->
            <div class="col-md-4">
                <x-ui.form.input
                    name="phone" 
                    label="Phone" 
                    value="{{ authenticated()->employee->info['phoneNumber'] }}"
                    placeholder="Enter your phone"
                    
                />
            </div>
            <!--end::Group-->

        </div>
        
        <hr>

        <button type="submit" class="btn btn-success" name="submitButton">Save Changes</button>

    </form>
</x-ui.card>