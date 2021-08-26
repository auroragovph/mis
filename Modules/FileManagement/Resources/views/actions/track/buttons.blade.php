@switch($type)

    @case(config('constants.document.type.procurement.request')) <!-- PURCHASE REQUEST -->
        @include('filemanagement::forms.procurement.request.buttons', ['pr' => $rel])
        @break
    @case(config('constants.document.type.procurement.order')) <!-- PURCHASE ORDER -->
        @include('filemanagement::forms.procurement.order.buttons', ['po' => $rel])
        @break
    @default
        
@endswitch