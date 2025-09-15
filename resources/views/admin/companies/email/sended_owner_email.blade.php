@extends('admin.layouts.master')
@push('title')
    Companies
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .grid .gird_item {
            border: 1px solid gray;
            padding: 10px;
        }

        .input-file {
            display: none; /* Hide the default file input */
            /* Add your custom styling here */
            /* Example styles */
            border: 1px solid #ccc;
            padding: 8px 12px;
            cursor: pointer;
            /* Customize further as needed */
        }

        .input-file-label {
            /* Style the visible label to look like a button */
            display: inline-block;
            padding: 8px 12px;
            background-color: #af4a43;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #af4a43;
        }
    </style>
@endpush
@section('content')
    <div class="card  shadow">
        <div class="card-header"><h4 class="font-weight-bold"> Email History Of {{$owner->name}}</h4></div>
        <div class="card-body  mb-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    <p><strong>Name:</strong> {{ $owner->name }}</p>
                    <p><strong>Email:</strong> {{ $owner->email }}</p>
                    <p><strong>Phone:</strong> {{ $owner->phone}}</p>
                    <p><strong>Ownership Percentage:</strong> {{ $owner->ownership_percentage}}</p>
                </div>
                <div class="col-12 col-md-6">
                    <p><strong>Street Address:</strong> {{ $owner->street_address }}</p>
                    <p><strong>City:</strong> {{ $owner->city}}</p>
                    <p><strong>State:</strong> {{ $owner->State}}</p>
                    <p><strong>Zip Code:</strong> {{ $owner->zip_code}}</p>
                    <p><strong>Country:</strong> {{ $owner->Country}}</p>
                </div>
            </div>

            <form action="{{route('admin.ownerEmailSend',$owner)}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="subject">Subject <span class="text-danger">*</span></label>
                    <input type="text" name="subject" placeholder="Subject" value="{{old('subject')}}" id="subject"
                           required class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Email Body <span class="text-danger">*</span></label>
                    <textarea id="content" placeholder="Email Body" name="body" required
                              class="form-control">{{old('body')?: "<p style='font-weight:700;'>Dear ". $owner->name .",</p> <br>"}}</textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-success"><i class="fas fa-envelope"></i> Send Email</button>
                </div>
            </form>
        </div>

    </div>


    @if(count($owner_email_logs))
        <div class="card shadow">
            <div class="card-header">
                <h3 class="text-center">History</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped">
                        <tr>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Time</th>
                        </tr>
                        @foreach($owner_email_logs as $log)
                            <tr>
                                <td><a href="" class="text-info" data-toggle="modal" data-target="#view{{$log->id}}" data-whatever="@fat">View</a></td>
                                <td>
                                    @if($log->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($log->status == 'success')
                                        <span class="badge badge-success">Success</span>
                                    @elseif($log->status == 'rejected')
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    {{$log->subject}}
                                </td>
                                <td>{{\Carbon\Carbon::parse($log->status_at)->format("M d, Y  h:i:s A")}}</td>

                            </tr>

                            <div class="modal fade" id="view{{$log->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{$log->subject}}</h5>
                                            <strong>
                                                <strong>Status:
                                                    @if($log->status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($log->status == 'success')
                                                        <span class="badge badge-success">Success</span>
                                                    @elseif($log->status == 'rejected')
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @endif
                                                </strong>
                                            </strong>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {!! $log->body !!}
                                        </div>
                                        <div class="modal-footer">

                                            @if($log->error)
                                                <strong class="text-danger">
                                                    {{$log->error}}
                                                </strong>
                                            @endif
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

{{--Registered Agent & Business Address--}}
{{--EIN--}}
{{--Operating Agreement / Corporate Bylaws--}}
{{--Expedited Filing--}}

@push('js')

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#content').summernote({
                placeholder: 'Email Body',
                tabsize: 2,
                height: 200
            });
        });
    </script>
@endpush
