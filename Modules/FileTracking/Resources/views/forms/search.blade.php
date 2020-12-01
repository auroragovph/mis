
<div class="modal fade" id="modal-search">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Search Generator</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-search" method="POST">
                <div class="row">
      
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Encoded Date:</label>
                            <input type="datetime-local" name="search-encoded" class="form-control">
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Series:</label>
                            <input name="search-series" type="text" class="form-control">
                        </div>
                    </div>
                  
                </div>

                <div class="row">
      

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Office:</label>
                            <select name="search-division" class="form-control select2" style="width: 100%">
                                <option value=""></option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Status:</label>
                            <select name="search-status" class="form-control select2" style="width: 100%;">
                                    <option value=""></option>
                                @foreach(config('static-lists.documentStatusFTS') as $key => $status)
                                    <option value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  
                </div>

                <hr>

                @isset($forms)
                    @include($forms)
                @endisset

              
                <hr>
      
                <button type="submit" class="btn bg-gradient-primary"> <i class="fal fa-search"></i> Search</button>
                <button type="button" id="form-reset" class="btn bg-gradient-warning"> <i class="fal fa-sync"></i> Reset</button>

              </form>
      
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->
  