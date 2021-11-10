<x-ui.card title="Credentials" class="tab-pane fade" id="credentialsTab" role="tabpanel" aria-labelledby="credentialsTab-tab">
   
   <form id="form_credentials" class="form" method="POST" action="{{ route('sys.profile.credentials') }}">

      @csrf
      @method('PATCH')

      <!--begin::Group-->
      <div class="form-group" >

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
          required  
      />
  
      <div class="row">
          <div class="col-md-6">
              <x-ui.form.input
                  name="password" 
                  label="New Password" 
                  type="password"
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
                  required  
              />
          </div>
          <!--end::Group-->
      </div>
      <hr>
  
      <button type="submit" class="btn btn-success">Save Changes</button>
  </form>
</x-ui.card>