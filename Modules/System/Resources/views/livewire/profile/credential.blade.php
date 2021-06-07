<form class="form" method="POST" wire:submit.prevent="update">
    @csrf
    @method('PATCH')

    <!--begin::Group-->
    <div class="form-group">

        <x-ui.form.input
            name="username" 
            label="Username" 
            value="{{ authenticated()->employee->account->username ?? '' }}" 
            disabled  
        />

    </div>
    <!--end::Group-->
    
    <x-ui.form.input
        name="password_old" 
        label="Old Password" 
        type="password"
        wire:model.lazy='password_old'
        required  
    />

    <div class="row">
        <div class="col-md-6">
            <x-ui.form.input
                name="password" 
                label="New Password" 
                type="password"
                wire:model.lazy='password'

                required  
            />
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <x-ui.form.input
                name="password_confirmation" 
                label="Confirm Password" 
                type="password"
                wire:model.lazy='password_confirmation'
                required  
            />
        </div>
        <!--end::Group-->
    </div>

    <hr>

    <button type="submit" class="btn btn-success" name="submitButton">Save Changes</button>
</form>