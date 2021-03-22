@switch($type)

    @case(config('constants.document.type.procurement.request')) <!-- PURCHASE REQUEST -->
        @include('filemanagement::forms.procurement.request.action_button', ['pr' => $rel])
        @break
    @case(config('constants.document.type.procurement.order')) <!-- PURCHASE ORDER -->
        @include('filemanagement::forms.procurement.order.action_button', ['po' => $rel])
        @break
    @default
        
@endswitch