 <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-light">

    <!-- Control sidebar content goes here -->
    <div class="p-3 text-center control-sidebar-content">

      <h4 class="font-weight-bold mb-3">User Profile</h4>

      <img src="{{ asset('images/user-default.png') }}" class="img-responsive elevation-2 d-inline-block" alt="" srcset="" width="120px" height="120px">


      <h4 class="d-block mt-3">{{ name_helper(auth()->user()->employee->name) ?? '' }}</h4>
        <p class="text-muted h6 d-inline">{{ auth()->user()->employee->position->position ?? '' }}</p>
        <p class="text-muted h6">{{ '@'.Auth::user()->username ?? ''}}</p>
      

      <a href="javascript:void(0);" onclick="$('#logout-form').submit();" class="btn bg-gradient-lightblue mt-3">Sign Out</a>



      <hr class="divider mt-4">

      <h4 class="font-weight-bold mb-3">Notifications</h4>

      <div class="card bg-gradient-navy p-2">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora tempore doloremque laboriosam aliquam tenetur explicabo officia error recusandae neque. Alias enim dolore quod magni ad deleniti harum labore ex suscipit.
      </div>

      <div class="card bg-gradient-navy p-2">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora tempore doloremque laboriosam aliquam tenetur explicabo officia error recusandae neque. Alias enim dolore quod magni ad deleniti harum labore ex suscipit.
      </div>

      <div class="card bg-gradient-navy p-2">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora tempore doloremque laboriosam aliquam tenetur explicabo officia error recusandae neque. Alias enim dolore quod magni ad deleniti harum labore ex suscipit.
      </div>

      <div class="card bg-gradient-navy p-2">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora tempore doloremque laboriosam aliquam tenetur explicabo officia error recusandae neque. Alias enim dolore quod magni ad deleniti harum labore ex suscipit.
      </div>


    </div>


  </aside>
  <!-- /.control-sidebar -->