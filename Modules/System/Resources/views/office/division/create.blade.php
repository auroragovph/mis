<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content card card-custom" id="form_spinner" data-card="true">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Division</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="form_create" action="{{ route('sys.office.division.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Division Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Enter name" />
                    </div>
                    <div class="form-group">
                        <label>Division Alias</label>
                        <input name="alias" type="text" class="form-control" placeholder="Enter alias" />
                    </div>
                    <div class="form-group">
                        <label>Office Name</label>
                        <select class="form-control select2" id="kt_select2" name="office" data-api="{{ route('sys.office.index') }}">
                            <option label="Label"></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>