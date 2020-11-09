


<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">CAFOA Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
  
          <form id="form-create" action="{{ route('fts.cafoa.store') }}" method="POST">
            @csrf
            <div class="row">
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">Select Series #:</label> <br>
                  <select name="series" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($qrs as $qr)
                        <option value="{{ $qr->id }}">{{ $qr->series }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">Requesting Office:</label> <br>
                  <select name="division" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                      @endforeach
                  </select>
                </div>
  
              </div>
  
            </div>
          
  
            <div class="row">
  
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Number:</label>
                    <input type="text" name="number" class="form-control">
                  </div>
              </div>
  
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Payee:</label>
                    <input name="payee" type="text" class="form-control" required>
                  </div>
    
                </div>
              
            </div>
  
            <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label for="">Particulars</label>
                      <textarea name="particulars" cols="30" rows="2" class="form-control" required></textarea>
                  </div>
              </div>
            </div>
  
            <div class="row">
  
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Amount:</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                  </div>
              </div>
  
             
            </div>

            <div class="row">
  
              <div class="col-md-12">
                  <div class="form-group">
                      <label for="">Attached Documents:</label>
                      <select name="attachments[]" class="form-control select2-tags" multiple style="width: 100%">
                          @foreach($attachments as $attachment)
                              <option>{{ $attachment->description }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

          </div>
  
           
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Liaison Officer:</label> <br>
                  <select name="liaison" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($liaisons as $liaison)
                        <option value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
            
            <hr>
  
            <button class="btn bg-gradient-primary">Save</button>
          </form>
  
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  