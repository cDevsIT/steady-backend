@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>
        nav#navbar_sticky {
            margin-bottom: 0px !important;
        }

        #about_hero {
            background-image: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url({{asset('assets/images')}}/Rectangle-735.png.webp);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .about_hero {
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


        .input-group-text {
            padding: 0px !important;
        }

        .custome_search_field:focus, .custome_search_field:active {
            outline: none !important;
            /*background: #F6F6F6;*/
            /*border: 1px solid #F6F6F6;*/
            box-shadow: none;
        }

        .searchBtn {
            background-color: #FF5700;
            color: white;

        }

        .searchBtn:hover {
            background-color: black;
            color: white;
        }
        .tagline {
            background: #14142bb5;
            color: white;
            width: 214px;
            margin: 30px auto;
            padding: 10px 15px;
            border-radius: 30px;
            display: inline-block;
        }


    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endpush
@section('content')
    <div class="about_hero">
        <div class="bg-dark text-secondary px-4 py-5 text-center" id="about_hero">
            <div class="py-5">
                <div class="row">
                    <div class="col-10 col-md-5 m-auto">
                        <form action="{{route('web.blogs')}}">
                            <div class="input-group">
                                <input type="text" class="form-control custome_search_field" name="q"
                                       placeholder="Search"
                                       aria-label="Search" value="{{request()->q}}" aria-describedby="Search">
                                <span class="input-group-text" id="basic-addon2">
                                    <input type="submit" value="Search" class="btn btn-success btn-lg searchBtn">
                                </span>
                            </div>
                        </form>

                        <div class="tagline">
                            Author: {{$author->first_name}} {{$author->last_name}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="blogs_items">
            @foreach($posts as $post)
                @include('web.blog.item')
            @endforeach


        </div>

        <div class="d-flex align-items-center">
            {{ $posts->links('web.pagination') }}
        </div>
    </div>
    @include('web.layouts.footer')
@endsection
@push('js')
@endpush
