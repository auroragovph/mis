<li class="nav-header">File Tracking</li>

@canany(['fts.create', 'fts.edit'])
<li class="nav-item">
    <a href="{{ route('fts.documents.index') }}" class="nav-link">
      <i class="nav-icon fal fa-file-alt"></i> <p>Documents</p>
    </a>
</li>
@endcanany

<li class="nav-item">
  <a href="{{ route('fts.documents.track') }}" class="nav-link">
    <i class="nav-icon fal fa-search"></i> <p>Track</p>
  </a>
</li>

<li class="nav-item has-treeview">

  <a href="#" class="nav-link">
    <i class="nav-icon fal fa-sparkles"></i>
    <p>Special Actions<i class="right fal fa-angle-left"></i></p>
  </a>
          
  <ul class="nav nav-treeview">

    @can('fts.sa.attach')
      <li class="nav-item">
        <a href="{{ route('fts.documents.attach.index') }}" class="nav-link">
          <i class="nav-icon fal fa-paperclip"></i> <p>Document Attach</p>
        </a>
      </li>
    @endcan

    @can('fts.sa.rr')
      <li class="nav-item">
        <a href="{{ route('fts.documents.rr.index') }}" class="nav-link">
          <i class="nav-icon fal fa-exchange-alt fa-rotate-90"></i> <p>Receive / Release</p>
        </a>
      </li>
    @endcan

    @can(['fts.sa.qr', 'godmode'])
      <li class="nav-item">
        <a href="{{ route('fts.qr.index') }}" class="nav-link">
          <i class="nav-icon fal fa-qrcode"></i> <p> QR Codes</p>
        </a>
      </li>
    @endcan
        
    @can('fts.sa.number')
    <li class="nav-item">
      <a href="{{ route('fts.documents.number.index') }}" class="nav-link">
        <i class="nav-icon fal fa-sort-numeric-down"></i> <p>Numbering</p>
      </a>
    </li>
    @endcan

    <li class="nav-item">

      <a href="#" class="nav-link">
        <i class="fal fa-file-invoice nav-icon"></i>
        <p>
          Transmittal
          <i class="right fal fa-angle-left"></i>
        </p>
      </a>

      <ul class="nav nav-treeview">

        <li class="nav-item">
          <a href="{{ route('fts.documents.transmittal.receive.index') }}" class="nav-link">
            <i class="fal fa-file-download nav-icon"></i>
            <p>Receive</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('fts.documents.transmittal.release.index') }}" class="nav-link">
            <i class="fal fa-file-upload nav-icon"></i>
            <p>Release</p>
          </a>
        </li>

      </ul>

    </li>

  </ul>
</li>



          