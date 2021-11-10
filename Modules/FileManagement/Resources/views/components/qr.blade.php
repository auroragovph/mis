<x-ui.card>

    <div class="text-center mb-10">
        <img width="30%"  height="30%" src="{{ qr_to_base64($document->qr) }} ">
        <p class="mt-2 mb-2">{{ $document->qr }}</p>

        <h4 class="font-weight-bold">{!! strtoupper(doc_type_only($document->type)) !!}</h4>

        <span class="badge bg-{{ document_status($document->status, 'label') }} text-uppercase">
            {{ document_status($document->status) }}
        </span>
    </div>

    <hr>

    <!--begin::Contact-->
    <div class="py-9">
        <p class="font-weight-bold mr-2">
            Requesting Office: <br>
            <span class="text-muted font-weight-normal">{{ office_helper($document->division) }}</span>
        </p>

        @php($qr_card_details = $document->card_info)

        <p class="font-weight-bold mr-2">
            Liaison Office: <br>
            <span class="text-muted font-weight-normal">{{ name($qr_card_details['encoder']['name']) }}</span>
        </p>

        <p class="font-weight-bold mr-2">
            Encoded By: <br>
            <span class="text-muted font-weight-normal">{{ name($qr_card_details['liaison']['name']) }}</span>
        </p>

        <p class="font-weight-bold mr-2">
            Encoded Date: <br>
            <span class="text-muted font-weight-normal">{{ $document->encoded }}</span>
        </p>

        @if(!empty($datas))
        
            <hr>

            @foreach($datas as $key => $data)

            @continue($key == '...hidden')

            <p class="font-weight-bold mr-2">
                {{ $key }}: <br>
                <span class="text-muted font-weight-normal">{{ $data }}</span>
            </p>
            @endforeach
        @endif


       
    </div>
    <!--end::Contact-->

</x-ui.card>