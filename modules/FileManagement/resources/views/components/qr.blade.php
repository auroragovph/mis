<x-ui.card>

    <div class="text-center mb-10">
        <img width="30%"  height="30%" src="{{ $series->qrcode_base64 }} ">
        <p class="mt-2 mb-2">{{ $series->qr }}</p>

        <h4 class="font-weight-bold">
            {{ \DocumentTypeEnum::from($series->type)->formal_label() }}
        </h4>

        <span class="badge bg-{{ \DocumentStatusEnum::from($series->status)->color() }} text-uppercase">
            {{ \DocumentStatusEnum::from($series->status)->formal_label() }}
        </span>
    </div>

    <hr>

    <!--begin::Contact-->
    <div class="py-9">
        <p class="font-weight-bold mr-2">
            Requesting Office: <br>
            <span class="text-muted font-weight-normal">{{ office($series->office) }}</span>
        </p>

        @php($qr_card_details = $series->card_info)

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
            <span class="text-muted font-weight-normal">{{ $series->encoded }}</span>
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
