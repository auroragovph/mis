<div class="col-{{ $size }}">

    <div class="card card-default">
        <div class="card-body pt-15">
            <!--begin::User-->
            <div class="text-center mb-10">
                {!! QrCode::size(150)->generate($document->id); !!}
                <br>
                <br>
                {!! show_status($document->status) !!}
                <h4 class="font-weight-bold text-dark mt-2 mb-2">{{ strtoupper(doc_type_only($document->type)) }}</h4>
                <div class="text-grey mb-2">{{ $document->qr }}</div>
            </div>
            <!--end::User-->
           
            <table class="table">

                <tr>
                    <td><strong>Requesting Office:</strong></td>
                    <td>{{ office_helper($document->division) }}</td>
                </tr>
                <tr>
                    <td><strong>Liaison Officer:</strong></td>
                    <td>{{ name_helper($document->liaison->name) }}</td>
                </tr>
                <tr>
                    <td><strong>Encoded By: </strong></td>
                    <td>{{ name_helper($document->encoder->name) }}</td>
                </tr>
                <tr>
                    <td><strong>Encoded Date: </strong></td>
                    <td>{{ Carbon\Carbon::parse($document->created_at)->format('F d, Y h:i A') }}</td>
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