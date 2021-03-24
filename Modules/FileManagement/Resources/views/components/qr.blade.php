<x-ui.card>

    <div class="text-center mb-10">
        <img class="w-25 h-25" src="data:image/svg+xml;base64, {{ qr_to_base64($document->qr) }} ">
        <p class="">{{ $document->qr }}</p>

        <h3 class="font-weight-bolder my-2 mt-3">{!! strtoupper(doc_type_only($document->type)) !!}</h3>

        <span class="badge badge-{{ document_status($document->status, 'label') }} text-uppercase">
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

        <p class="font-weight-bold mr-2">
            Liaison Office: <br>
            <span class="text-muted font-weight-normal">{{ name_helper($document->liaison->name) }}</span>
        </p>

        <p class="font-weight-bold mr-2">
            Encoded By: <br>
            <span class="text-muted font-weight-normal">{{ name_helper($document->encoder->name) }}</span>
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