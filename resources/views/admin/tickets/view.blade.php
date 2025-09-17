@extends('admin.layouts.master')
@push('title')
    Ticket Details
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Ticket #{{$ticket->id}}</h1>
                    <p class="page-subtitle-modern">Customer support ticket details and conversation</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary-modern btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-arrow-left me-2"></i>Back to Tickets
                    </a>
                    @if($ticket->status == 'Open')
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-3 d-inline-flex align-items-center">
                            <i class="fas fa-door-open me-1"></i>Open
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-3 d-inline-flex align-items-center">
                            <i class="fas fa-door-closed me-1"></i>Closed
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modern Ticket Details Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Ticket Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-heading me-2 text-primary"></i>Title
                                </label>
                                <p class="form-control-plaintext fw-semibold small">{{ $ticket->title }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-calendar me-2 text-info"></i>Created Date
                                </label>
                                <p class="form-control-plaintext small">
                                    {{ \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-comment me-2 text-success"></i>Message
                            </label>
                            <div class="border rounded p-3 bg-light">
                                {!! $ticket->content !!}
                            </div>
                        </div>
                        @if($ticket->file_name)
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-paperclip me-2 text-warning"></i>Attachment
                                </label>
                                <div>
                                    <a download href="{{ asset("storage/".$ticket->file_name) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-2"></i>{{ $ticket->file_name }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="fas fa-user me-2 text-primary"></i>Customer Information
                                </h6>

                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="text-muted small d-inline-flex align-items-center">Name</span>
                                    <span class="fw-semibold small d-inline-flex align-items-center">{{ $ticket->first_name ." ". $ticket->last_name }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="text-muted small d-inline-flex align-items-center">Company</span>
                                    <span class="small fw-semibold d-inline-flex align-items-center">{{ $ticket->company_name ?? 'N/A' }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="text-muted small d-inline-flex align-items-center">Email</span>
                                    <span class="small d-inline-flex align-items-center"><a href="mailto:{{ $ticket->email }}" class="text-primary"><i class="fas fa-envelope me-1"></i>{{ $ticket->email }}</a></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small d-inline-flex align-items-center">Phone</span>
                                    <span class="small d-inline-flex align-items-center"><a href="tel:{{ $ticket->phone }}" class="text-primary"><i class="fas fa-phone me-1"></i>{{ $ticket->phone }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Comments Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-comments me-2 text-primary"></i>Conversation History
                </h5>
            </div>
            <div class="card-body">
                <div class="comments-container">
                    @forelse ($comments as $comment)
                        <div class="comment-item mb-4">
                            <div class="d-flex {{$comment->role == 2 ? 'justify-content-start' : 'justify-content-end'}}">
                                <div class="comment-bubble {{$comment->role == 2 ? 'customer-comment' : 'admin-comment'}}">
                                    <div class="comment-header d-flex align-items-center mb-2">
                                        @if($comment->role == 1)
                                            <div class="comment-avatar me-2">
                                                <img src="{{asset('assets/images/Fav-Icon-150x150.png')}}" 
                                                     alt="Admin" class="rounded-circle" width="40" height="40">
                                            </div>
                                        @else
                                            <div class="comment-avatar me-2">
                                                <img src="{{asset('assets/images/dummy.jpeg')}}" 
                                                     alt="Customer" class="rounded-circle" width="40" height="40">
                                            </div>
                                        @endif
                                        <div>
                                            <span class="fw-semibold small">{{ $comment->first_name ." ". $comment->last_name }}</span>
                                            <br>
                                            <small class="text-muted small">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        {!! $comment->comment_text !!}
                                        @if($comment->attachment)
                                            <div class="attachment mt-2">
                                                <a download title="{{$comment->file_name}}" 
                                                   href="{{ asset("storage/".$comment->attachment) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-paperclip me-1"></i>{{$comment->file_name}}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-comments text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2 small">No comments yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Modern Reply Form -->
                @if($ticket->status == 'Open')
                    <div class="reply-form mt-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="fas fa-reply me-2 text-primary"></i>Add Response
                                </h6>
                                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" id="ticketReplyForm">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                    
                                    <div id="ticketError" class="alert alert-danger d-none py-2 px-3 small" role="alert">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Please enter a response before updating the ticket status.
                                    </div>

                                    <div class="mb-3">
                                        <label for="comment_text" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-comment me-2 text-primary"></i>Your Response
                                        </label>
                                        <textarea class="form-control form-control-sm @error('comment_text') is-invalid @enderror"
                                                  id="comment_text" 
                                                  name="comment_text" 
                                                  rows="4" 
                                                  placeholder="Type your response here..."></textarea>
                                        @error('comment_text')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label fw-semibold text-muted small">
                                                    <i class="fas fa-toggle-on me-2 text-warning"></i>Update Status
                                                </label>
                                                <select name="status" id="status" class="form-control form-control-sm">
                                                    <option {{$ticket->status == 'Open' ? 'selected' : ''}} value="Open">Keep Open</option>
                                                    <option {{$ticket->status == 'Close' ? 'selected' : ''}} value="Closed">Close Ticket</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="attachment" class="form-label fw-semibold text-muted small">
                                                    <i class="fas fa-paperclip me-2 text-info"></i>Add Attachment
                                                </label>
                                                <input type="file" 
                                                       name="attachment" 
                                                       id="attachment" 
                                                       class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="submit" class="btn btn-primary-modern btn-sm" id="ticketSubmitBtn">
                                            <i class="fas fa-paper-plane me-2"></i>Send Response
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <i class="fas fa-door-closed text-danger" style="font-size: 3rem;"></i>
                                <h5 class="text-danger mt-2">Ticket Closed</h5>
                                <p class="text-muted small">This ticket has been resolved and closed.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scroll Buttons -->
    <button id="scrollUp" class="scroll-button">
        <i class="fas fa-arrow-up"></i>
    </button>
    <button id="scrollDown" class="scroll-button">
        <i class="fas fa-arrow-down"></i>
    </button>
@endsection


@push('js')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        document.getElementById('scrollUp').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.getElementById('scrollDown').addEventListener('click', function() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        });
        $(document).ready(function () {
            $('#comment_text').summernote({
                placeholder: 'Content',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol']]
                ]
            });
            // Prevent submit without text
            $('#ticketReplyForm').on('submit', function(e){
                var content = $('#comment_text').summernote('code');
                var sanitized = content.replace(/<[^>]*>/g, '').trim();
                if(!sanitized){
                    e.preventDefault();
                    $('#ticketError').removeClass('d-none');
                    $('html, body').animate({ scrollTop: $('#ticketError').offset().top - 120 }, 300);
                } else {
                    $('#ticketError').addClass('d-none');
                }
            });
        });
        {{--function showComments() {--}}
        {{--    $.ajax({--}}
        {{--        url: "{{route('tickets.showComments')}}",--}}
        {{--        type: "GET",--}}
        {{--        data: {--}}
        {{--            id: '{{ $ticket->id }}'--}}
        {{--        },--}}
        {{--        success: function (response) {--}}
        {{--            $(".showAllComments").html(response);--}}
        {{--        }--}}
        {{--    })--}}
        {{--}--}}
    </script>
@endpush
