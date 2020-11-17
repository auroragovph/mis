<div class="col-md-6">
    <div class="card card-primary card-outline direct-chat direct-chat-primary" style="min-height: 80vh; max-height: 80vh;">
        <div class="card-header">
          <h3 class="card-title">
            @isset($receiver)
                Conversations with {{ name_helper($receiver->name) }}
            @endisset
            
          </h3>

         
        </div>
        <!-- /.card-header -->
        <div id="message-box" class="card-body p-3">

            @foreach($convos as $convo)

            @if($convo->sender == auth()->user()->employee_id)

            <!-- Message to the right -->
            <div class="direct-chat-msg right">
              <div class="direct-chat-infos clearfix">
                
                <span class="direct-chat-timestamp float-left">{{ Carbon\Carbon::parse($convo->created_at)->format('Y-m-d h:i A') }}</span>
              </div>
              <!-- /.direct-chat-infos -->
              <img class="direct-chat-img" src="{{ asset('images/user-default.png') }}" alt="Message User Image">
              <!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                {{ $convo->message }}
              </div>
              <!-- /.direct-chat-text -->
            </div>

            @else

            <!-- Message. Default to the left -->
            <div class="direct-chat-msg">
              <div class="direct-chat-infos clearfix">
                
                <span class="direct-chat-timestamp float-right">{{ Carbon\Carbon::parse($convo->created_at)->format('Y-m-d h:i A') }}</span>
              </div>
              <!-- /.direct-chat-infos -->
              <img class="direct-chat-img" src="{{ asset('images/user-default.png') }}" alt="Message User Image">
              <!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                {{ $convo->message }}
              </div>
              <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->

            @endif

            @endforeach


         
        </div>

        <!-- /.card-body -->
        <div class="card-footer">
          <form id="form-send" action="{{ route('messenger.send', $receiver->id) }}" method="post">
            @csrf
            <div class="input-group">
              <input type="text" name="message" placeholder="Type Message ..." class="form-control">
              <span class="input-group-append">
                <button type="submit" class="btn btn-primary">Send</button>
              </span>
            </div>
          </form>
        </div>
        <!-- /.card-footer-->

    </div>
</div>