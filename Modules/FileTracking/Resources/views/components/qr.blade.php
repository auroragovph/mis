<div class="col-{{ $size }}">

    <div class="card card-default">
        <div class="card-body pt-15">
            <!--begin::User-->
            <div class="text-center mb-10">
                <img width="60%" height="60%" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->merge('/public/images/logo-sm.png', .3)->errorCorrection('H')->generate($document['series']['id'])) !!} ">                
                <span class="d-block mt-2"></span>
                {!! $document['status']['dom'] !!}
                <h4 class="font-weight-bold text-dark mt-2 mb-2">{{ strtoupper($document['type']['full']) }} </h4>
                <div class="text-grey mb-2">{{ $document['series']['full'] }}</div>
            </div>
            <!--end::User-->
           
            <table class="table">

                <tr>
                    <td><strong>Requesting Office:</strong></td>
                    <td>{{ $document['office']['full'] }}</td>
                </tr>
                <tr>
                    <td><strong>Liaison Officer:</strong></td>
                    <td>{{ $document['liaison']['full'] }}</td>
                </tr>
                <tr>
                    <td><strong>Encoded By: </strong></td>
                    <td>{{ $document['encoder']['full'] }}</td>
                </tr>
                <tr>
                    <td><strong>Encoded Date: </strong></td>
                    <td>{{ $document['encoded']['nicedate'] }}</td>
                </tr>
              

                @isset($datas)
                    @foreach($datas as $key => $data)
                        <tr>
                            <td><strong>{{ $key }}</strong>:</td>
                            <td>{{ $data }}</td>
                        </tr>
                    @endforeach
                @endisset

            </table>
        </div>

    </div>
</div>