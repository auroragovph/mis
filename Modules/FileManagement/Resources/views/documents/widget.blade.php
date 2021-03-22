
    <div class="col-md-7">
        <div class="row">
            <div class="col-xl-6">

                <div class="small-box bg-success text-center pt-3">
                    <div class="inner">
                      <h3>{{ $documents->whereBetween('created_at', [Carbon\Carbon::now()->startOfDay(), Carbon\Carbon::now()->endOfDay()])->count() }}</h3>
      
                      <p>Today's Document</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    
                </div>

                <div class="small-box bg-primary text-center pt-3">
                    <div class="inner">
                      <h3>{{ $total }}</h3>
      
                      <p>Total Document</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                   
                </div>

            </div>
            <div class="col-xl-6">

                <div class="small-box bg-warning text-center pt-3">
                    <div class="inner">
                      <h3>N/A</h3>
      
                      <p>On Process</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                   
                </div>

                <div class="small-box bg-danger text-center pt-3">
                    <div class="inner">
                      <h3>N/A</h3>
                      <p>Returned</p>
                    </div>
                    
                </div>
                

              

            </div>

        </div>
        <!--begin::Mixed Widget 20-->
        <div class="card card-custom bgi-no-repeat gutter-b" style="height: 180px; background-color: #4AB58E; background-position: calc(100% + 0.5rem) bottom; background-size: 25% auto; background-image: url(/media/svg/humans/custom-1.svg)">
            <!--begin::Body-->
            <div class="card-body d-flex align-items-center">
                <div class="py-2">
                    <h3 class="text-white font-weight-bolder mb-3">File Management Announcements</h3>
                    <p class="text-white font-size-lg">
                        Please attach the documents when you released the documents.
                    </p>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Mixed Widget 20-->
    </div>