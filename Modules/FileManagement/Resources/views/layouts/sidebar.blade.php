<li class="nav-header">File Management</li>

@canany(['fms.create', 'fms.edit', 'fms.edit.power', 'fms.view'])
  <li class="nav-item">
    <a href="{{ route('fms.documents.index') }}" class="nav-link">
      <i class="nav-icon fal fa-file-alt"></i> <p>Documents</p>
    </a>
  </li>
@endcanany

<li class="nav-item has-treeview">

  <a href="#" class="nav-link">
    <i class="nav-icon fal fa-sparkles"></i>
    <p>Special Actions<i class="right fal fa-angle-left"></i></p>
  </a>
          
  <ul class="nav nav-treeview">

    @can('fms.sa.attach')
      <li class="nav-item">
        <a href="{{ route('fms.documents.attach.index') }}" class="nav-link">
          <i class="nav-icon fal fa-paperclip"></i> <p>Document Attach</p>
        </a>
      </li>
    @endcan

    @can('fms.sa.rr')
      <li class="nav-item">
        <a href="{{ route('fms.documents.rr.index') }}" class="nav-link">
          <i class="nav-icon fal fa-exchange-alt fa-rotate-90"></i> <p>Receive / Release</p>
        </a>
      </li>
    @endcan

    @can('fms.sa.activate')
      <li class="nav-item">
        <a href="{{ route('fms.documents.activate') }}" class="nav-link">
          <i class="nav-icon fal fa-clipboard-check"></i> <p>Activation</p>
        </a>
      </li>
    @endcan
          
    @can('fms.sa.number')
      <li class="nav-item">
        <a href="{{ route('fms.documents.number.index') }}" class="nav-link">
          <i class="nav-icon fal fa-sort-numeric-down"></i> <p>Numbering</p>
        </a>
      </li>
    @endcan

  </ul>
</li>



          