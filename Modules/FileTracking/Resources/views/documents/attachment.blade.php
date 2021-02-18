@extends('layouts.master')


@section('page-title')
Document Attachment
@endsection

@section('toolbar')
@endsection

@section('content')

@isset($document)

<div class="row">

    <div class="col-xl-4">
        <x-fts-qr :document="$document" :datas="$datas" />
    </div>

    <div class="col-xl-8">

        <!--begin::Advance Table Widget 5-->
        <div class="card card-custom gutter-b" id="card-box" data-card="true">
          <!--begin::Header-->
          <div class="card-header border-0 py-5">
              <h3 class="card-title align-items-start flex-column">
                  <span class="card-label font-weight-bolder text-dark">Attachment Form</span>
                  {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
              </h3>
          </div>
          <!--end::Header-->
          <!--begin::Body-->
          <div class="card-body">
              <form id="kt_form" action="{{ route('fts.documents.attach.attach', $document->id) }}">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="">File</label>
                        <input type="file" class="form-control" name="file" >
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Number / Control Number</label>
                                <input type="text" class="form-control" name="number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="text" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Number of Page</label>
                                <input type="text" class="form-control" name="page">
                            </div>
                        </div>
                    </div>

                    <div class="separator separator-dashed mb-5"></div>

                    <button href="#" class="btn btn-primary btn-shadow font-weight-bold mr-2">Attach</button>
              </form>
          </div>
          <!--end::Body-->
        </div>
        <!--end::Advance Table Widget 5-->


        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Attachments</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Details</th>

                            <th scope="col">By</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($document->attachments as $attachment)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $attachment->name }}</td>
                            <td>
                                @foreach($attachment->properties as $key => $value)
                                    <span><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</span> <br>
                                @endforeach
                            </td>
                            <td>{{ name_helper($attachment->encoder->name) }}</td>

                            <td>

                                @if($attachment->file !== null)
                                <a target="_blank" href="{{ route('fts.documents.attach.file', $attachment->file) }}" class="btn btn-icon btn-light-primary btn-sm mr-2" data-toggle="tooltip" title="View Attachment">
                                    <i class="flaticon-attachment"></i>
                                </a>
                                @endif

                                <a href="#" class="btn btn-icon btn-light-warning btn-sm mr-2" data-toggle="tooltip" title="Edit Attachment">
                                    <i class="flaticon2-edit"></i>
                                </a>

                                <a href="#" class="btn btn-icon btn-light-danger btn-sm mr-2" data-toggle="tooltip" title="Unlink attachment">
                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                </a>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


      
    </div>
</div>

@else
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
           
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fts.documents.attach.check') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Series Number</label>
                        <input type="text" name="series" class="form-control" autofocus autocomplete="off" required>
                    </div>
                    <hr>
                    <button class="btn btn-primary"><i class="flaticon2-magnifier-tool"></i> Search</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
@endif
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileTracking/pages/documents/attachment.js') }}"></script>

@endsection

