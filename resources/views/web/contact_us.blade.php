@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>
        nav#navbar_sticky {
            margin-bottom: 0px !important;
        }
        #about_hero{
            background-image: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url({{asset('assets/images')}}/image-13.jpg.webp);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .about_hero{
            position: relative;
        }

        footer.footer {
            padding: 0px !important;
        }
        #about_hero:before {
            content: "";
            display: block;
            position: absolute;
            mix-blend-mode: initial;
            opacity: .65;
            transition: .03s;
            border-radius: 0;
            border-style: initial;
            border-color: initial;
            border-block-start-width: 0px;
            border-inline-end-width: 0px;
            border-block-end-width: 0px;
            border-inline-start-width: 0px;
            top: calc(0px - 0px);
            left: calc(0px - 0px);
            width: max(100% +0px+0px, 100%);
            height: max(100% +0px+0px, 100%);
            background-color: #000;
        }


        .grids {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 30px;
        }
        .image img {
            width: 100%;
            border-radius: 20px;
        }

        .env {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #FF5700;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .env i{
            font-size: 24px;
        }
        .env:hover{
            background: black;
            color: #fff;
        }


        .control_ {
            background-color: #F6F6F6;
            padding: 6px 10px;
            border-radius: 0px 10px;
            border: 1px solid #ff5700;
            width: 100%;
            height: 50px;
        }
        textarea.control_ {
            height: 150px;
        } #sBtn.control_ {
            background: #ff5700;
            color: #fff;
        }
        .control_:focus, .control_:active{
            outline: none !important;
            background: #F6F6F6;
            border: 1px solid #ff5700;
            box-shadow: none;
        }

    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endpush
@section('content')
    <div class="about_hero">
        <div class="bg-dark text-secondary px-4 py-5 text-center" id="about_hero">
            <div class="py-5">
                <h1 class="display-5 fw-bold text-white">Contact Us</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="grids">
            <div class="grid_item">
                <h1>Get in Touch

                </h1><p>
                    Contact our expert support team. Ask query to our team and get solutions 24/7 from anywhere.

                </p>

                <div class="email d-flex gap-2 align-items-center">
                        <a href="mailto:info@steadyformation.com" class="env"><i class="fas fa-envelope"></i></a>


                    <div>
                        <h3>info@steadyformation.com</h3>

                    </div>
                </div>
            </div>
            <div class="grid_item">
                <form action="{{route('web.getInTouch')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2">
                            <label for="">Name</label>
                            <input type="text" name="name" placeholder="Name" class="control_">
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" required placeholder="Email" class="control_">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" required placeholder="Phone" class="control_">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="subject">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" id="subject" required placeholder="Subject" class="control_">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="message">Message <span class="text-danger">*</span></label>
                            <textarea name="message" id="message" required cols="30" rows="10" class="control_"></textarea>
                        </div>
                        <div class="col-12 mb-2">
                            <input type="submit" id="sBtn" class="control_">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @include('web.layouts.footer')
@endsection
@push('js')
@endpush
