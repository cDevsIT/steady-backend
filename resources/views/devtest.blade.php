@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>
        nav#navbar_sticky {
            margin-bottom: 0px !important;
        }
        #about_hero{
            background-image: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)),url({{asset('assets/images')}}/image-13.jpg.webp);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .about_hero{
            position: relative;
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

        .our_mossion {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction:column;
            padding: 30px;
        }
        nav#nav {
            margin-bottom: 25px;
        }
        .our_mossion .nav-tabs {
            border-bottom: 0px;
        }
        .our_mossion .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
            border-color: transparent;
            isolation: isolate;
        }
        .our_mossion .nav-tabs .nav-link {
            border: 1px solid transparent;
            /*border-radius: 10px;*/
            color: black;
            background-color: #bdbdbd;
            margin-right: 36px;
            font-size: 20px;
        }

        .our_mossion .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #ff5700;
            border-color: transparent;
        }
        .nav-tabs .nav-link{
            border-radius: 0px;
        }
        @media (max-width: 900px) {
            .our_mossion .nav-tabs .nav-link{
                margin-right: 10px !important;
            }
            .grids{
                grid-template-columns: 1fr;
                gap: 10px;
            }

        }


    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endpush
@section('content')
    <div class="about_hero">
        <div class="bg-dark text-secondary px-4 py-5 text-center" id="about_hero">
            <div class="py-5">
                <h1 class="display-5 fw-bold text-white"> Table Of Content</h1>
            </div>
        </div>
    </div>
    <div class="container">
{{--        <h1>{{ $post->title }}</h1>--}}

        <div class="toc">
            <h2>Table of Contents</h2>
            @toc($table)



            <div class="post-content">
                @contentWithIds($table)
            </div>
        </div>


    </div>

    @include('web.layouts.footer')
@endsection
@push('js')
@endpush
