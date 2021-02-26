<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Create New Source Of Funds</h3>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" method="POST" action="{{ route('budget.source-of-funds.store') }}">
            @csrf

            <div class="form-group">
                <label for="">Name</label>
                <input name="name" type="text" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="">Alias</label>
                <input name="alias" type="text" class="form-control" value="{{ old('alias') }}" required>
            </div>

            <div class="form-group">
                <label for="">Description</label>
                <textarea class="form-control" name="description" cols="30" rows="2">{{ old('description') }}</textarea>
            </div>
            

            <div class="separator separator-dashed mb-5"></div>
            <button type="submit" class="btn btn-primary mt-5" name="submitButton">Submit</button>
        </form>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->
