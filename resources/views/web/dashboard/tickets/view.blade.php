@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>
        body {
            overflow-x: hidden;
        }

        .panel {
            position: relative;
        }

        .left-sidebar {
            height: 100vh;
            background: #fff;
            border-right: 1px solid gray;
            padding: 15px;
            position: fixed;
            top: 18%;
            left: 0;
            width: 250px;
            z-index: 998;
            transform: translateX(-250px);
            transition: transform 0.3s ease;
        }

        .left-sidebar .nav-link {
            font-size: 16px;
            margin: 10px 0;
        }

        .left-sidebar .nav-link.active {
            background: #e9ecef;
            border-radius: 4px;
        }

        .left-sidebar.active {
            transform: translateX(0px);
            /*width: 0px;*/
        }

        .content {
            padding: 15px;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .toggle-btn {
            display: block;
            position: fixed;
            top: 19%;
            left: 0px;
            z-index: 999;
        }

        @media (max-width: 768px) {
            .left-sidebar {
                height: 100%;
            }

            .left-sidebar.active {
                transform: translateX(0);
            }

            .toggle-btn {
                display: block;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .o_item_indicator {
                gap: 10px;
                overflow-x: scroll;
                text-wrap: nowrap;
            }

            .orderLine {
                overflow-x: scroll;
                text-wrap: nowrap;
            }

            .o_item:not(:last-child)::after {
                top: 16%;
                right: -59px;
                width: 100%;

            }

            .o_item:first-child::after {
                width: 78%;
            }
        }

        select#company {
            width: 100%;
            border: navajowhite;
            margin-top: 18px;
        }

        p.s_circle {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #FF5700;
            color: #FFFFFF;
            position: absolute;
            left: 43%;
            right: 50%;
            transform: translate(0px, -50%);
        }

        p.s_circle i {
            display: none;
        }

        p.s_circle.active {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #FF5700;
            color: #FFFFFF;
        }

        p.s_circle.active i {
            display: block;
        }

        /* Timeline line */
        .line {
            height: 2px;
            background-color: #FF5700;
            margin: 0 10px;
        }

        .o_item {
            position: relative;
            padding: 27px;
            flex: 1;
            text-align: center;
        }

        .o_item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 16%;
            right: -126px;
            width: 100%;
            height: 2px;
            background-color: #ff570054;
            transform: translateY(-50%);
            z-index: -1;
        }

        .o_item.active:not(:last-child)::after {
            background-color: #FF5700;
        }

        .s_tag {
            height: 50px;
            color: #000000;
            font-size: 16px;
            margin-top: 30px;
        }

        p.datetime {
            line-height: 0;
            margin-bottom: 39px;
        }

        .s_status {
            margin-top: 20px;
            color: #008220;
            background: #E7FFED;
            text-align: center;
        }

        .item_title {
            font-size: 18px;
            font-weight: 600;
        }

        /*DOCKS*/
        .doc_items {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            align-items: center;
        }

        .doc_item {
            background: #ff57000a;
            border-radius: 20px;
            padding: 0px 7px;
        }


        .company-details {
            background-color: #e0f7fa;
            padding: 20px;
            border-radius: 8px;

        }

        .company-details h2 {
            margin-top: 0;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 20px;
        }

        .detail-item {
            display: flex;
            justify-content: left;
            gap: 10px;
        }

        .detail-item strong {
            margin-right: 15px;
        }


        .member-details {
            background-color: #F0FFF0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;
        }


        .member-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 20px;
        }

        .member-item {
            display: flex;
            justify-content: left;
            gap: 10px;
        }

        .member-item strong {
            margin-right: 15px;
        }

        /*.d-flex::before {*/
        /*    content: '';*/
        /*    position: absolute;*/
        /*    top: 50%;*/
        /*    left: 0;*/
        /*    width: 100%;*/
        /*    height: 2px;*/
        /*    background-color: #000;*/
        /*    z-index: -1;*/
        /*    transform: translateY(-50%);*/
        /*}*/


        @media (max-width: 1200px) {
            .doc_items {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .doc_items {
                grid-template-columns: repeat(2, 1fr);
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .detail-item {
                justify-content: space-between;
            }

            .member-grid {
                grid-template-columns: 1fr;
            }

            .member-item {
                justify-content: space-between;
            }

        }

        @media (max-width: 600px) {
            .doc_items {
                grid-template-columns: 1fr;
            }
        }
        .comment_show img {
            width: 100px !important;
            height: 100px !important;
            margin: 10px 0px !important;
        }
         .author_image{
             width: 50px;
             height: 50px;
             border-radius: 50%;
             overflow: hidden;
             margin-right: 10px;
             border: 5px solid gray;
         }
        .scroll-button {
            position: fixed;
            right: 20px;
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 25px;
            background-color: #f54329;
            color: white;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        #scrollUp {
            bottom: 150px;
        }

        #scrollDown {
            bottom: 90px;
        }


    </style>





@endpush
@section('content')
    <div class="panel" id="panel">
        <button class="toggle-btn btn btn-light" id="toggleSidebar">☰</button>
        @include('web.dashboard.part.sidebar')

        <div id="content" class=" content">
            <div class="card" style="padding: 10px">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Ticket # {{$ticket->id}}</h3>
                        <a href="{{route('web.tickets',session('active_company_id'))}}" class="btn btn-warning"> <i
                                class="fas fa-arrow-left"></i> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    Title
                                </th>
                                <td>
                                    {{ $ticket->title }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Message
                                </th>
                                <td>
                                    {!! $ticket->content !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    File
                                </th>
                                <td>
                                    <a download href="{{ asset("storage/".$ticket->file_name) }}">{{ $ticket->file_name }}</a>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Customer Name
                                </th>
                                <td>
                                    {{ $ticket->first_name ." ". $ticket->last_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Customer Email
                                </th>
                                <td>
                                    {{ $ticket->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Customer Phone
                                </th>
                                <td>
                                    {{  $ticket->phone  }}
                                </td>
                            </tr>
                            </tbody>
                        </table>


                       <div class="row">
                           <h2 style="font-weight: bold; margin: 20px; 0px; text-align: center">Comments</h2>
                           <div class="col-12 col-md-8 m-auto">
                               <!-- Show comments -->
                               @forelse ($comments as $comment)
                                   <div class="row">
                                       <div class="col" style="text-align: {{$comment->role == 2 ? 'right !important' : 'left'}}">
                                           <p class="font-weight-bold">
                                               @if($comment->role == 1)
                                                   <img class="author_image" src="{{asset('assets/images/Fav-Icon-150x150.png')}}" alt="Admin">
                                               @else
                                                   <img class="author_image" src="{{asset('assets/images/dummy.jpeg')}}" alt="Customer">
                                               @endif
                                               <a
                                                   href="mailto:{{ $comment->email }}">{{ $comment->first_name ." ". $comment->last_name }}</a>
                                               ({{ $comment->created_at }})</p>
                                           <div class="comment_show">
                                               {!! $comment->comment_text !!}
                                               @if($comment->attachment)
                                                   <div class="attachement">
                                                       <a download title="{{$comment->file_name}}" href="{{ asset("storage/".$comment->attachment) }}"><i class="fas fa-link fa-2x"></i></a>
                                                   </div>
                                               @endif
                                           </div>
                                       </div>
                                   </div>
                                   @if(!$loop->last)
                                       <hr/>
                                   @endif
                               @empty
                                   <div class="row">
                                       <div class="col">
                                           <p>There are no comments.</p>
                                       </div>
                                   </div>
                               @endforelse
                               <form action="{{ route('web.makeComment', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                                   @csrf
                                   <div class="form-group mt-5">
                                       <label for="comment_text" style="font-weight: bold;">Leave a comment</label>
                                       <textarea class="form-control @error('comment_text') is-invalid @enderror"
                                                 id="comment_text" name="comment_text" rows="3" required></textarea>
                                       @error('comment_text')
                                       <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                       @enderror
                                   </div>
                                   <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                   <label for="attachment">
                                       <input type="file" name="attachment" id="attachment">
                                   </label>
                               </form>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button id="scrollUp" class="scroll-button"><i class="fas fa-arrow-up"></i></button>
    <button id="scrollDown" class="scroll-button"><i class="fas fa-arrow-down"></i></button>
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
        $(document).ready(function() {
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
        });
    </script>
    <script>

        const content = document.getElementById('content');
        document.addEventListener("DOMContentLoaded", function () {
            let leftSidebar = document.querySelector("#left-sidebar")
            if (leftSidebar.classList.contains('active')) {
                content.style.marginLeft = "250px";
                // localStorage.setItem("isActive", true)
            } else {
                // localStorage.setItem("isActive", false)
                content.style.marginLeft = "0px";
            }
        })
        document.getElementById('toggleSidebar').addEventListener('click', function (e) {
            let leftSidebar = document.querySelector("#left-sidebar")
            e.stopPropagation(); // Prevents the sidebar from closing when clicking the toggle button
            document.getElementById('left-sidebar').classList.toggle('active');
            if (leftSidebar.classList.contains('active')) {
                content.style.marginLeft = "250px";
                // localStorage.setItem("isActive", true)
                console.log("yes")
            } else {
                content.style.marginLeft = "0px";

                localStorage.setItem("isActive", false)
                console.log("No")
            }
        });

        // document.addEventListener('click', function (e) {
        //     var sidebar = document.getElementById('left-sidebar');
        //     var toggleBtn = document.getElementById('toggleSidebar');
        //     if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        //         sidebar.classList.remove('active');
        //     }
        //
        //     if (sidebar.classList.contains('active')) {
        //         content.style.marginLeft = "250px";
        //     } else {
        //         content.style.marginLeft = "0px";
        //     }
        // });

        window.addEventListener('scroll', function () {
            var sticky = 50;
            const leftSidebar = document.querySelector("#left-sidebar")
            const toggleButton = document.querySelector(".toggle-btn")
            if (window.pageYOffset >= sticky) {
                if (leftSidebar) {
                    leftSidebar.style.top = "14%";
                } else {
                    leftSidebar.style.top = "18%";
                }

                if (toggleButton) {
                    toggleButton.style.top = "15%";
                } else {
                    toggleButton.style.top = "19%";
                }
            } else {
                leftSidebar.style.top = "18%";
                toggleButton.style.top = "19%";
            }
        });
        const company = document.querySelector('#company')
        company.addEventListener('change', function () {
            window.location.href = this.options[this.selectedIndex].dataset.route;
        });

    </script>
@endpush
