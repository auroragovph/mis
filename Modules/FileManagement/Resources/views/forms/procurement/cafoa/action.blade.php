<!--begin::Dropdown-->
<div class="dropdown dropdown-inline">
    <a href="#" class="btn btn-light-dark btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <i class="flaticon2-menu-2"></i> Actions
    </a>
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right py-3 m-0">
        <!--begin::Navigation-->
        <ul class="navi navi-hover">

            <li class="navi-header font-weight-bold py-4">
                <span class="font-size-lg">Actions:</span>
            </li>

            <li class="navi-separator mb-3 opacity-70"></li>

                @include('filemanagement::documents.general_action_button', ['button_doc_id' => $cafoa->document_id])

            <li class="navi-separator mb-3 opacity-70"></li>

            <li class="navi-item">
                <a href="{{ route('fms.cafoa.edit', $cafoa->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-contract"></i> Edit Document
                    </span>
                </a>
            </li>
          

            <li class="navi-item">
                <a href="{{ route('fms.cafoa.print', $cafoa->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-printer"></i> Print Document
                    </span>
                </a>
            </li>

        </ul>
        <!--end::Navigation-->
    </div>
</div>
<!--end::Dropdown-->