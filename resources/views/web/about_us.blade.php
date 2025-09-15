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
                <h1 class="display-5 fw-bold text-white">About Us</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="grids">
            <div class="grid_item grid_item_1">
                <h2>About Us
                </h2><p>
                    At Steady Formation, we help people from all over start their businesses in the US easily. Our experienced team is here to guide you through every step, from getting your company set up to making sure everything’s done right. We’re committed to helping your business dreams come true, making the process straightforward and stress-free.
                </p>
            </div>
            <div class="grid_item grid_item_2">
                <div class="image w3-animate-right	">
                    <img src="{{asset('assets/images/successful.webp')}}" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="our_mossion">
            <nav id="nav">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Our Story</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Our Vision</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Our Mission</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="grids">
                        <div class="grid_item">
                            <div class="image w3-animate-bottom	">
                                <img src="{{asset('assets/images/Our-Story.webp')}}" alt="">
                            </div>
                        </div>

                        <div class="grid_item w3-animate-bottom	" style="text-align: left;">
                            <h2>Bridging Dreams and Realities

                            </h2><p>
                                Driven by this deep understanding and empathy, we embarked on our mission 7+ years ago. Our founders, armed with a blend of expertise in business strategy, taxation, and international law, set out to dismantle the barriers that kept global entrepreneurs from accessing the US market. What started as a small team of like-minded professionals has now grown into a family, united by a common goal—to empower.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    <div class="grids">
                        <div class="grid_item w3-animate-bottom	" style="text-align: left">
                            <h2>To Make Easy & Seamless US Company Formation for Non-Resident

                            </h2><p>
                                Our vision is to empower entrepreneurs globally, making US company formation seamless, regardless of location. We aim to foster growth, innovation, and access to opportunities, turning the entrepreneurial dream into reality. Through expert guidance and support, we’re building a future where every business can thrive on a global stage.
                            </p>
                        </div>
                        <div class="grid_item">
                            <div class="image w3-animate-bottom	">
                                <img src="{{asset('assets/images/Our-Vision.webp')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="grids">
                        <div class="grid_item">
                            <div class="image w3-animate-bottom	">
                                <img src="{{asset('assets/images/Our-Mission.webp')}}" alt="">
                            </div>
                        </div>

                        <div class="grid_item w3-animate-bottom	 " style="text-align: left;">
                            <h2>Empowering Your Business Expansion


                            </h2><p>
                                With 7+ years of dedication in the industry, we’ve mastered the art of blending strategic planning and ultimate action to significantly enhance the annual profits of our 1,000+ clients. At the heart of our mission is a constant commitment to your success. Our team invests unwavering effort into helping your business not only meet but surpass new milestones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('web.layouts.footer')
@endsection
@push('js')
@endpush
