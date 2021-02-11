<!--begin::Card-->
<div class="card card-custom gutter-b">
    <!--begin::Body-->
    <div class="card-body pt-15">

        <!--begin::User-->
        <div class="text-center mb-10">
            <img class="w-50 h-50" src="data:image/svg+xml;base64, {{ qr_to_base64($document->seriesFull) }} ">
            <p class="my-2 mt-3">{{ $document->seriesFull }}</p>

            <h2 class="font-weight-bolder my-2 mt-3">{{ strtoupper(doc_type_only($document->type)) }}</h2>

            <span class="label label-light-{{ document_status($document->status, 'label') }} label-inline font-weight-bold label-lg">{{ document_status($document->status) }}</span>


            
        </div>
        <!--end::User-->

        
        <!--begin::Contact-->
        <div class="py-9">

            <p class="font-weight-bolder mr-2">
                Requesting Office: <br>
                <span class="font-weight-normal">{{ office_helper($document->division) }}</span>
            </p>

            <p class="font-weight-bolder mr-2">
                Liaison Office: <br>
                <span class="font-weight-normal">{{ name_helper($document->liaison->name) }}</span>
            </p>

            <p class="font-weight-bolder mr-2">
                Encoded By: <br>
                <span class="font-weight-normal">{{ name_helper($document->encoder->name) }}</span>
            </p>

            <p class="font-weight-bolder mr-2">
                Encoded Date: <br>
                <span class="font-weight-normal">{{ $document->encoded }}</span>
            </p>

            @if(!empty($datas))
                <hr>

                @foreach($datas as $key => $data)
                    @if($key == '...hidden') @continue @endif
                <p class="font-weight-bolder mr-2">
                    {{ $key }}: <br>
                    <span class="font-weight-normal">{{ $data }}</span>
                </p>
                @endforeach
            @endif


           
        </div>
        <!--end::Contact-->
       
    </div>
    <!--end::Body-->
</div>
<!--end::Card-->