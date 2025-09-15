@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <style>
        .showCounter {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            justify-content: center;
            align-content: center;
            text-align: center;
        }

        .article {
            background: #9494ff;
            padding: 30px;
        }

        .ar_items {
            display: grid;
            grid-template-columns: 1fr 1fr;
            text-align: center;
            gap: 20px;
            padding: 20px;
            border-radius: 20px;
        }

        .ar_item {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e4e4ff;
            gap: 23px;
            border-radius: 20px;
            padding: 20px;
        }

        .ar_img img {
            width: 80px;
        }

        .ar_content {
            text-align: left;
        }

        .article_b.wantHide {
            padding: 30px;
        }

        .br_items {
            display: grid;
            grid-template-columns: 1fr;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 50px;
        }

        .article_c.wantHide {
            padding: 30px;
        }

        .article_c.wantHide {
            background-image: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url({{asset('assets/images/Breadcome.webp')}});
            background-position: bottom center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .shadow.customize {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 1) !important;
        }

        .bc_items {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .bc_item {
            background: #FFFFFF00;
            color: #fff;
            padding: 40px;
            text-align: center;
        }


        .article_d.wantHide {
            padding: 30px;
        }

        .dc_icon svg {
            width: 5em;
            height: 5em;
            position: relative;
            display: block;
            fill: #fff;
            background: #9494ff;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .dc_items {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-content: center;
            align-items: stretch;
            align-content: center;
        }

        .dc_item {
            padding: 25px;
            border-style: solid;
            border-width: 1px;
            border-color: #5F616829;
            border-radius: 10px;
            box-shadow: 0px 0px 5px -1px rgba(141.1, 141.1, 141.1, .5);
        }

        .article_e.wantHide {
            padding: 30px;
        }

        .ec_icon svg {
            width: 5em;
            height: 5em;
            position: relative;
            display: block;
            fill: #fff;
            background: #ff8b60;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .ec_items {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-content: center;
            align-items: stretch;
            align-content: center;
        }

        .ec_item {
            padding: 25px;
            border-style: solid;
            border-width: 1px;
            border-color: #5F616829;
            border-radius: 10px;
            box-shadow: 0px 0px 5px -1px rgba(141.1, 141.1, 141.1, .5);
        }


        .article_f.wantHide {
            padding: 30px;
        }

        .fc_items {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-content: center;
            align-items: stretch;
            align-content: center;
        }

        .fc_item {
            padding: 25px;
            border-style: solid;
            border-width: 1px;
            border-color: #5F616829;
            border-radius: 10px;
            box-shadow: 0px 0px 5px -1px rgba(141.1, 141.1, 141.1, .5);
        }

        .article_g.wantHide {
            padding: 30px;
            background: #f4f4ff;
        }

        .gc_items {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-content: center;
            align-items: stretch;
            align-content: center;
        }

        .gc_item {
            padding: 25px;
            border-style: solid;
            border-width: 1px;
            border-color: #5F616829;
            border-radius: 10px;
            box-shadow: 0px 0px 5px -1px rgba(141.1, 141.1, 141.1, .5);
        }

        .gc_icon svg {
            width: 5em;
            height: 5em;
            position: relative;
            display: block;
            fill: #fff;
            background: #9494ff;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .article_h.wantHide {
            background-image: url({{asset('assets/images/map-backround.webp')}});
            background-position: bottom center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .hc_items {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            justify-content: center;
            align-items: stretch;
            align-content: center;
        }

        .hc_items .gc_item {
            margin: 10px 0px;
        }

        .hc_item img {
            width: 100%;
        }

        .article_i.wantHide {
            background: #f4f4ff;
            padding: 30px;
        }

        .ic_items {
            padding: 0px 100px;
        }

        .accordion-item {
            background-color: #f4f4ff;
            border: 0px;
            margin: 10px 0px;
            border-radius: 20px;
        }

        .accordion-button:not(.collapsed) {
            color: #fff;
            background-color: #9494ff;
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .125);

        }

        .accordion-button {
            padding: 26px;
        }


        .accordion-header {
            margin-bottom: 0;
            overflow: hidden;
            border-radius: 20px 20px 0px 0px;
            border: 1px solid #d5d8dc;
        }

        .accordion-header:hover {
            background-color: #9494ff;
            color: #fff;
        }

        .accordion-collapse {
            background: #fff;
            border-bottom: 1px solid #d5d8dc;
            border-left: 1px solid #d5d8dc;
            border-right: 1px solid #d5d8;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }


        .article_blog.wantHide {
            padding: 30px;
        }

        .register_agent_address {
            display: grid;
            grid-template-columns: 1fr 1fr;
            justify-content: center;
            gap: 20px;
        }

        .processing_card-container.register_agent_address {
            grid-template-columns: 1fr 1fr !important;
        }

        .show_iconx {
            width: 25px;
            height: 25px;
            border: 4px solid #d7cfca;
            border-radius: 50%;
            position: absolute;
            top: 24px;
            right: 15px;
            background-color: #fff;
        }

        .agent_item {
            border: 1px solid #ddd;
            border-radius: 20px;
            width: 100%;
            background-color: #fff;
            text-align: left;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s ease;
        }

        .agent_item .radio-circle {
            width: 25px;
            height: 25px;
            border: 4px solid #d7cfca;
            border-radius: 50%;
            position: absolute;
            top: 24px;
            left: 15px;
            background-color: #fff;
        }

        .agent_item input[type="radio"] {
            display: none;
        }

        .agent_item.active .radio-circle {
            border: 4px solid #FF5700;
        }

        .agent_item label {
            display: block;
            cursor: pointer;
        }

        .agent_item:hover {
            transform: translateY(-10px);
        }

        svg#guarantee_mark {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            position: absolute;
            top: 24px;
            right: 15px;
            background-color: #fff;
        }

        .agent_item.active {
            border: 1px solid #FF5700;
        }

        .agent_condition_item {
            position: relative;
            margin-left: 48px;
            margin-bottom: 30px;
        }

        svg.agent_icon {
            position: absolute;
            top: -4px;
            left: -48px;
        }

        .view_terms {
            display: none;
        }

        .view_terms.show {
            display: block;
        }


        /*.register_agent{*/
        /*    display: none;*/
        /*}*/

        .agent_info_2_title {
            position: absolute;
            top: 24px;
            font-weight: bolder;
            left: 50px;
        }

#business_type {
        display: block !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right .75rem center !important;
        background-size: 16px 12px !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
    }
    </style>
@endpush
@section('content')

    {{--    {{dd(\Illuminate\Support\Facades\Auth::check() && !auth()->user()->role == \App\Enums\RoleEnum::ADMIN)}}--}}
    @if(auth()->check() && auth()->user()->role == \App\Enums\RoleEnum::ADMIN)
    @else
        <div class="container">
            {{--{{dd(\Carbon\Carbon::now()->addYear()->format("y-m-d"))}}--}}
            @include('web.home.part.step_one')
            @include('web.home.part.step_two')
            @include('web.home.part.step_three')
            @include('web.home.part.step_four')
            @include('web.home.part.step_four_1_register_agent_address')
            @include('web.home.part.step_five')
            @include('web.home.part.step_six')
            @include('web.home.part.step_seven')
            @include('web.home.part.step_eight')
            @include('web.home.part.step_final')
        </div>
    @endif

    <div class="article_x wantHide">
        <div class="container">
            <div class="showCounter my-5">
                <div class="counter_item ">
                    <h2 class="counter" data-target="50">0</h2>
                    <div class="counter_text">
                        Nations We've Proudly Served
                    </div>
                </div>
                <div class="counter_item ">
                    <h2 class="counter" data-target="500">0</h2>
                    <div class="counter_text">
                        Total Satisfied Customers Worldwide

                    </div>
                </div>
                <div class="counter_item ">
                    <h2 class="counter" data-target="500">0</h2>
                    <div class="counter_text">
                        Companies We Successfully Formed

                    </div>
                </div>
                <div class="counter_item ">
                    <h2 class="counter" data-target="100" data-percent="true">0 %</h2>
                    <div class="counter_text">Success Rate
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="article wantHide">
        <div class="container">
            <div class="ar_items">
                <div class="ar_item">
                    <div class="ar_img">
                        <img src="{{ asset('assets/images/No-Hidden-Fees-150x150.webp') }}" alt="No-Hidden-Fees">
                    </div>
                    <div class="ar_content">
                        <h3>No Hidden Fees.</h3>
                        <span style="font-weight: bold">Pay Only What You Ask For!</span>
                        <p>Enjoy total pricing transparency with Steady Formation. Only pay for what you choose—no
                            surprises, no hidden charges. Focus on your business, not the fine print.
                        </p>
                    </div>

                </div>
                <div class="ar_item">
                    <div class="ar_img">
                        <img src="{{ asset('assets/images/No-Documents-Required-150x150.webp') }}"
                             alt="No-Documents-Required">
                    </div>
                    <div class="ar_content">
                        <h3>No Documents Required.</h3>
                        <span style="font-weight: bold">Get Started Instantly!</span>
                        <p>Skip the paperwork—launch your business seamlessly with zero documentation. Just enter the
                            required information and take the first step towards entrepreneurship without any delays.

                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>






    <div class="article_b wantHide">
        <div class="container">
            <div class="br_items">
                <div class="br_item">
                    <span style="font-weight: bold">Launch Your US Company Today</span>
                    <h3 style="color: #FF5700">Quick, Free, & Easy Global Reach!</h3>
                    <div class="br_img">
                        <p>
                            <i class="fas fa-square-check"></i>
                            Get Fast & Easy US Company Formation with Expert Hand.
                        </p>
                        <p>
                            <i class="fas fa-square-check"></i>
                            Register a US Company with Only Your Company Name & Local Address.
                        </p>

                        <p>
                            <i class="fas fa-square-check"></i>
                            Save Money, Register Your US Company with Only State Fee.
                        </p>

                        <p>
                            <i class="fas fa-square-check"></i>
                            Expand Your Business to the Global Market.

                        </p>


                    </div>

                </div>
                {{--                <div class="br_item">--}}

                {{--                </div>--}}
            </div>
            
            <div class="text-center mt-4">
                <a href="#step1" style="padding: 10px 12px;" class="btn btn-next">Form Your Company</a>
            </div>
        </div>
    </div>
    <div class="article_c wantHide">
        <div class="container">
            <div class="bc_items">
                <div class="card card-body shadow customize bc_item">
                    <h2>The Philosophy We Follow</h2>
                    <p>At Steady Formation, our philosophy is rooted in a deep commitment to breaking down barriers for
                        global entrepreneurs. With 7+ years of expertise in business strategy, taxation, and
                        international law, our mission is to make US company formation seamless and empower businesses
                        to thrive globally. We’re dedicated to your success, helping you surpass milestones and boost
                        profits. Join us in building a future where every entrepreneur can achieve their dreams on a
                        global stage.
                    </p>
                </div>
            </div>
        </div>
        {{--        <div class="overlay"></div>--}}
    </div>


    <div class="article_d wantHide">
        <div class="container">
            <div class="dc_head" style="text-align: center;padding-bottom: 10px;">
                <h4>Why Choose</h4>
                <h2 style="color: #ff5700">Steady Formation?</h2>
            </div>
            <div class="dc_items">
                <div class="dc_item">
                    <div class="dc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 429.62 478.93">
                            <path
                                d="M238.39.05c-92.27-2.33-165,72.19-166,159.63-1.06,90.58,71.38,161.83,157,164.21,92.72,2.57,167-73,166.41-161.66C396.23,74,325.33,2.24,238.39.05ZM140,259.15a128,128,0,0,1-27.25-37.22l9-4.51,25.58,34.88C145.35,254.16,142.84,256.5,140,259.15Zm75.28,36.79a126,126,0,0,1-44.54-14.31l4.58-8.84,41.28,13.37C216.26,288.76,215.81,292.14,215.29,295.94Zm15.07-77.29a72.61,72.61,0,0,1-12.66,4.47c-2.74.75-3.8,1.94-3.69,4.79.2,5.14.05,10.28.05,16H190c0-4.68-.38-9.28.1-13.79.5-4.69-1.41-6.25-5.74-7.13-19-3.87-31.27-17.11-33.11-35.65,7.52-.75,15.05-1.57,22.59-2.17a3.38,3.38,0,0,1,2.43,1.84c6.92,15.32,16.1,20.05,33.37,17.22,7.41-1.22,13.44-4,15.24-12.14,1.67-7.57-1.24-14-8.61-16.42-9.29-3.06-19-4.89-28.3-7.91-6.74-2.19-13.81-4.47-19.52-8.45-19.18-13.36-16.53-41.36,4.69-52.24,5-2.55,10.58-3.85,16.69-6V80.23h23.56v21.11c11.25,2.68,22.42,5.23,28.49,15.88,2.46,4.34,3.64,9.41,5.41,14.15l-1.06,1.84c-7.73,0-15.47.06-23.2-.09a3.24,3.24,0,0,1-2.29-2,11.61,11.61,0,0,0-10.46-8.78,92.38,92.38,0,0,0-20.29,0c-6.09.74-9.14,4.57-9.48,9.34-.4,5.61,1.93,9.74,8,11.74,7.88,2.57,16,4.43,24.07,6.4,11.11,2.71,22,6,29.63,15.23C256.79,182.65,251.08,208.6,230.36,218.65ZM261.12,128a56.7,56.7,0,0,1-9-13.46c-1.79-4-4.9-7.41-7.34-11,28.62,1.51,62.49,19,70.21,64.71h21.54l-39.81,53.52-40.43-53.05h19.55A60.44,60.44,0,0,0,261.12,128Zm-8.09,168c-.55-3.94-1-7.19-1.38-9.95l41.21-13.25,4.73,8.67C283.74,289.33,269,293.47,253,296.05Zm75.22-36.73-7.14-7.12c8.47-11.56,16.86-23,25.48-34.79l8.89,4.5C348.65,236.17,339.39,248.3,328.25,259.32Zm28.38-75.24c.11-1.63.09-3.07.32-4.47C365.32,127.36,336.84,73,289.1,50.11,228.31,21,158.3,42.93,125.29,101.8c-12.91,23-17.44,48-14.5,74.27.91,8.14,1.07,8.13-6.93,9.6-.81.14-1.65.13-2.45.19-9.48-38,3.49-94.44,47.06-129.31,47.61-38.1,110.55-41.31,161-7.76,48.6,32.31,67.66,89.28,57.63,137.29Z"></path>
                            <path
                                d="M66.15,478.93C44.08,456.68,22.27,434.71,0,412.28c4.58-4.23,9.38-8.49,14-12.94,10.08-9.7,19.92-19.64,30.11-29.22,22.92-21.54,50.53-31.4,81.66-32.2,24.88-.64,49,4,72.91,10.34A51.86,51.86,0,0,0,211.42,350c17.5.18,35,0,52.49.06,15.15,0,27,9.29,30.17,23.47,2.27,10.15-1.16,14.47-11.57,14.48q-47,0-94,0c-2.48,0-5.27-.16-7.32.9-1.83.94-3.85,3.45-3.88,5.3,0,1.52,2.64,3.22,4.35,4.55.65.51,1.93.29,2.92.28,33.83-.1,67.65-.1,101.47-.4,13.1-.12,21.52-11.44,19-24.82-1.88-10.08-1.87-10.05,6.88-15.34,8.27-5,16.7-9.75,24.68-15.17,4.34-2.95,8.09-6.87,11.74-10.71q19.82-20.82,39.36-41.89c6.63-7.11,14.44-11.77,24.39-12a24.72,24.72,0,0,1,7.36.95c8.62,2.51,11.66,7.64,9.41,16.24a42.9,42.9,0,0,1-4.42,11.6c-10.62,17.29-21.37,34.52-32.54,51.46-3,4.5-7.23,8.32-11.47,11.74-25.56,20.59-51.33,40.92-76.92,61.46a47.51,47.51,0,0,1-30.93,10.69c-48.82-.12-97.64.11-146.47-.15-15.25-.08-27.89,5.13-38.65,15.66C80.51,465.32,73.36,472,66.15,478.93Z"></path>
                        </svg>
                    </div>

                    <div class="dc_content">
                        <h4>Affordable Pricing</h4>
                        <p>Competitively priced services tailored for every budget, ensuring quality without
                            compromise.</p>
                    </div>
                </div>


                <div class="dc_item">
                    <div class="dc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 596.75 544.11">
                            <path
                                d="M527.28,353.55c-4.27,35.59-21.14,65.75-42,93.7C377.59,591.61,152.18,571,72.12,409.61a57.84,57.84,0,0,1-2.47-7.14l18.95.28c38.37,70.8,97.06,112.14,177.33,122.19,43.16,3,84.67-3.28,124.39-21.05,6.47-2.89,11.47-6,13.95-12.63,6.08,1,10.82-1.85,15.45-5.18,22.12-15.93,41.68-34.55,57-57.13C485.45,416,495.6,403.47,497.6,387c8.49-9.48,8.22-22.56,13.74-33.26Z"></path>
                            <path
                                d="M527.28,353.55l-15.94.23c-14.28-1.48-28-5.26-40.12-12.87-28.28-17.76-42-43.82-40-77.05,2.19-36.47,23.26-59.41,55.8-73.21l19.33-3.91c8.11.56,16.39.24,24.29,1.83,37.22,7.45,63.07,38.31,65.89,77.9,2.41,33.8-20.74,68.43-53.94,80.92C537.49,349.33,531.53,349.33,527.28,353.55Zm55.2-83.38c-.09-38.58-30.21-69.5-68.06-69.86-37.66-.35-70.51,31-69.86,68.31.65,37.56,23.79,70.88,81,71.56C551.62,340.49,582.56,301.58,582.48,270.17Z"></path>
                            <path
                                d="M83.76,236.72l-10.71-.18c-6.11,1.16-12.22,2.33-18.36,3.47-4.76,2.82-9.55,5.61-14.28,8.47-49.34,29.78-54.4,98-10.19,134.94,11.63,9.7,25.7,13.9,39.42,19.06l18.94.28c33.74-5.13,59.23-21.52,71.72-54.28C180.6,295.18,140.87,237.46,83.76,236.72ZM82.26,388.6c-38.29-.49-67.95-30.94-68.1-69.87C14,281,45.78,249.55,83.58,250c37.49.43,68.68,32.27,68.68,70.13C152.29,357.41,119.93,389.1,82.26,388.6Z"></path>
                            <path
                                d="M155.14,98.59c2.29-11.93.11-24.18,3.5-36.16,9-31.59,28.62-53.2,60.61-59.94,45.82-9.67,78.23,9,98.82,53.62Q320,65.43,322,74.73c-.16,2.55-.41,5.09-.46,7.63-1.09,54.12-48,91.63-100.73,81-18.14-3.67-31.26-16.16-46.72-24.54-4.12-9.33-7.22-19.24-15.13-26.4C158.64,107.52,160.83,102,155.14,98.59ZM238.7,151.1c38.48-.06,70.12-31.14,69.69-68.43C308,44.69,276.46,13,239.22,13a69.24,69.24,0,0,0-69.1,69.12C170,120.73,200.26,151.16,238.7,151.1Z"></path>
                            <path
                                d="M322,74.73q-2-9.3-3.91-18.62c51.25,7.46,97.2,26.7,135.8,61.78,21.67,19.7,40.3,41.88,52.53,68.85l-19.33,3.91c-2.23-7.72-3.13-16.39-13.2-18.53l-2-6.05c-2.5-7.74-6.19-14.62-13.55-18.88Q402.89,87,322,74.73Z"></path>
                            <path
                                d="M155.14,98.59c5.69,3.39,3.5,8.93,3.8,13.8-18.8,18.66-40,35.1-54.57,57.69C99,178.4,91.89,186,91.07,196.64c-10.19,11.41-14.68,25.4-18,39.9L54.7,240C69.29,179.47,101.71,131.57,155.14,98.59Z"></path>
                            <path
                                d="M473.87,172.12c10.07,2.14,11,10.81,13.2,18.53-32.54,13.8-53.61,36.74-55.8,73.21-2,33.23,11.67,59.29,40,77.05,12.13,7.61,25.84,11.39,40.12,12.87-5.52,10.7-5.25,23.78-13.74,33.26-6.83-2.32-13.79-2.72-21-2.81-18-.22-36.59.89-51.24-13.19-2.6-2.5-8.2-3.94-8.35.88-.25,8.45,7.55,13.79,11.64,20.62,3.4,5.67,8.54,4,11.69.82,9-9.13,15.42-.73,20,3.93,6.21,6.36-.92,12.58-5.27,16.62-13.6,12.64-30.49,20-47.45,27.09-4.89,2-8.22-.15-9.08-4.95-2.72-15.2-16.92-23.35-22.54-37.14-2.09-5.14-6.21-11.26-10.46-16.28-3-3.58-6.74-6-10.45-3.9-5.85,3.37-.41,7.21,1.52,9.75,6.81,9,10.42,19.45,15.33,29.31,6.13,12.3,17.36,22.35,27.47,32.28,6.9,6.78,15.41,1.14,23.15-.35,8.87-1.71,6.55,3.68,4.84,8a90.71,90.71,0,0,1-23.09,33.56c-2.48,6.63-7.48,9.74-13.95,12.63C350.6,521.66,309.09,528,265.93,524.94c-5.66-10.6-11.9-21-9.35-34,.39-2-1.72-6.45-2.79-6.49-11.89-.39-20.87-10-34.57-7.38-24,4.64-48.38,9.29-64-20.68-11.59-22.27-12.75-44.24,4.4-63.76,7.82-8.9,19.74-14.14,22.32-28.08.83-4.48,8.45-9.85,13.77-11,18.34-3.89,37-6.11,55.62-8.88,3.24-.48,7.39.57,7.54,3.64.93,18.18,17.42,17.29,28.06,23.39,3.34,1.91,7.81,4.28,10.93-.42,6.05-9.12,13.95-5.93,21.88-3.95,7.36,1.84,14.86,1.59,22.39,1.93,14.25.66,18.92-7,18.69-18.2-.27-13.37-11.59-5.95-17.71-6.78-7.31-1-14.89.1-16.76-9.26-1.95-9.72,8-7.12,12.12-10.31,10.51-8.08,22.45-2.2,33.85-1.86,3.39.1,7.8.88,9.11-3.54,1-3.41-2.33-6.74-4.59-7-9-1.11-8.67-27.37-24.61-9.24-.19.22-1.91-.47-2.51-1.12-8.55-9.31-13.42-.67-16.21,4.75-5.19,10-8.26,21-22,22.89-1.12.15-1.56,5.36-2.31,8.22l-.15.15c-12.3-3.31-12.08-19-23-23.42-6.27-2.55-11.69-14.71-16.87-8.62-4.77,5.61,6.35,11.49,11.17,16.8,2,2.18,8.08,2.19,4.6,7.44-4.14,6.24-5.23-1.51-7.44-2.38-5.05-2-9.65-5.62-13.83-9.27-10.57-9.21-23.4-7.79-34,1.58-8.94,7.89-14.62,19.78-27.2,23.37-7.55,2.16-15.09.85-19.4-5.38s-.29-14,1.66-20.28c2.12-6.82,9.28-4.16,14.67-2.83,5.21,1.29,10.64,2.17,13.49-3.48,2.39-4.74,1.74-9.94-1.79-14.37-1.55-1.93-3.14-3.84-5.39-6.59,13.74-4.71,24.7-12.28,35.43-20.86,6.82-5.45,14.83-10.88,25.8-8.9,13.19,2.37,24.25.17,35.07-11.95,6.6-7.39,8.89-23,26.88-19.39-7.29-6.89-12.09-4.5-16.83-3.05-3.52,1.07-7,2-9.83-1.42-3.14-3.75-2.3-7.68.06-11.33,2.21-3.41,5-6.43,7.17-9.86,1-1.53,1.93-4.36,1.2-5.32-.94-1.23-3.67-1.82-5.46-1.56-4.77.69-21,22.48-18.83,26.7,4.58,9-2.85,14.29-4.61,21.26-1.08,4.28-5,5.22-8.24,5.91-4.85,1-5.14-3.92-6.62-6.87-1.93-3.83-1.73-10.66-7.93-9.11-6.5,1.64-11.74,4.38-13.83-5-1.86-8.32,3.91-12.15,9.09-16.15,3.25-2.5,7.76-1.73,9.51-8,3.92-14.06,16.06-22.41,27.11-30.54,22.57-16.6,42.69-1.86,63,6.68,2.7,1.13,7.36,2.26,5.51,7.59-6.32,3.62-13.73-.18-21.67,2.31,4.56,6,10,16.36,13.65,12.77,7.63-7.58,24.34-8.64,20.69-25.14,5.78-.27,3.17,10.75,12.95,5.8,18.73-9.5,39.14-15.6,61.24-14.27-.65-1.49-.85-3.37-1.85-4-8.69-5.68-6.14-14.43-.8-17.76,8.15-5.1,5.78,6.81,9.92,9.42a16,16,0,0,1,2.23,2.06c.21,6.75,6.3,12.83,2.3,20.08-1,1.86-10-.24-3,5.39,4,3.26,7.66.45,9.52-3.64C466.61,177.9,465.06,170.43,473.87,172.12ZM420.1,293.53c-18.33.59-21.87,6.31-13.73,19.67,2.05,3.37,7.16,5.61,6.12,10-1.91,8.06.36,12.88,8.52,14.34,3.07.56,7-.14,7.24-3.7.38-6.33.15-13.2-5.23-17.71C415.27,309.6,411.89,302.71,420.1,293.53Z"></path>
                            <path
                                d="M174.07,138.79c-2.52,5.86-6.1,8.21-13,6.24-3.52-1-8.47,1.48-10.31,5-1.95,3.73.42,6.66,4.91,7.29.81.11,1.48,1.16,2.21,1.78-9.45,1.68-6.09,15.06-8.57,15-22.67-.21-38.23,16.8-58.23,22.48.82-10.66,7.93-18.24,13.3-26.56,14.58-22.59,35.77-39,54.57-57.69C166.85,119.55,170,129.46,174.07,138.79Z"></path>
                            <path
                                d="M471.83,166.07c-6.26.86-10.57-2.35-14.22-6.88-.93-4.07-1.22-8.09.66-12C465.64,151.45,469.33,158.33,471.83,166.07Z"></path>
                            <path
                                d="M205.9,237.38c5.41,10.52,10,19.9,15,29,3.11,5.62,1.33,8.9-4.28,9.9-4.75.84-14,.55-11.82-4.39,4.92-11.12-5.71-19.29-2.5-29.08C202.75,241.47,203.9,240.36,205.9,237.38Z"></path>
                            <path
                                d="M403.51,161.15c-5.88-3.43-13-4.13-9.83-9.84,4.43-7.94,2.16-22.63,19.32-21.35C406.44,139.13,399,147.08,403.51,161.15Z"></path>
                            <path
                                d="M150.21,202.71c1.95-1.79,2.66-2.49,3.42-3.13,6.22-5.19,13.14-7.94,21.06-4.68,2.72,1.12,3.16,4.79.75,6.22C168.06,205.5,160.27,209.23,150.21,202.71Z"></path>
                            <path d="M309.23,337.87l1.66,1.53c-.36,0-.86.09-1.06-.1a4.74,4.74,0,0,1-.75-1.28Z"></path>
                            <path
                                d="M513.81,313.33c-11.23,0-22.53-.7-33.69.19s-11.5-4-9-12.56c5.2-17.65,19.49-26.8,43-26.81,22.75,0,38.52,9.84,43.12,26.9,2.29,8.49,1.11,13.39-9.73,12.48C536.34,312.6,525,313.33,513.81,313.33Zm25.65-15.08c-14.9-13.81-38.47-13.49-49.33,0Z"></path>
                            <path
                                d="M517,220.9c11.6-.1,22.47,11.95,22.26,24.69-.23,13.41-12.39,25.15-25.85,25a25,25,0,0,1-24.62-25.83C489.09,229.83,499.47,221.06,517,220.9Zm8.21,24.15c-1.08-6.88-4.53-11.77-12-11.17-7,.56-11.05,5-10.7,12.32.33,6.82,5.11,10.43,11,10.47C520.38,256.7,524.78,252.35,525.22,245.05Z"></path>
                            <path
                                d="M97.92,325.73c-8.08-.59-16.25-.13-24.35,0-21,.33-32.91,12.06-34.3,33.77-.33,2.18.8,2.79,2.74,2.58l80,.09,1.41.28,1.41-.46C129,345.71,115.39,327,97.92,325.73ZM58.13,348.94c9.45-15.75,37-16,50.32,0Z"></path>
                            <path
                                d="M107.68,294.47c.39,14.5-10,25.24-24.54,25.3s-25.5-10.5-25.66-24.62c-.17-14.69,11.51-24.67,29-24.79C97,270.28,107.36,282.1,107.68,294.47ZM83.11,306.9c6.4-1.3,11.2-4.46,11.15-11.87S89.74,283.47,83,283.35c-7-.13-11.42,4.68-11.44,11.58S75.87,305.93,83.11,306.9Z"></path>
                            <path
                                d="M281.79,117c.68-6.08-2.58-10.68-6.05-14.92-14.31-17.41-33.22-16-52.56-12.56-2.85-.36-5.43,0-7.22,2.65-13.72,5.83-20.41,16.27-20.32,31.1-.34,2.33.8,3,2.92,2.73l79.91-.09C288.24,126.13,283.54,121,281.79,117Zm-67.18-4.51c9.95-15.63,37.18-15.81,50.32,0Z"></path>
                            <path
                                d="M263.7,57.62c-.41,15.71-10.59,26.14-25.27,25.86a24.62,24.62,0,0,1-24.5-25.62c.33-15.18,11.53-24.31,29.19-23.8C252.64,34.34,264,47.3,263.7,57.62ZM238.85,70.26c6.17-1,11.32-4,11.68-11.15S246.36,47.55,239.61,47c-7.15-.6-11.74,4.28-12.22,10.85C226.9,64.64,231.64,68.76,238.85,70.26Z"></path>
                        </svg>
                    </div>

                    <div class="dc_content">
                        <h4>All-Around Global Client Base</h4>
                        <p>Serving a diverse global clientele, from startups to established businesses, across various
                            industries.

                        </p>
                    </div>
                </div>


                <div class="dc_item">
                    <div class="dc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 672.67 583.86">
                            <path
                                d="M521.29,428.24c-9.07-23.36-5.16-43.57,4.48-66.85C580.35,230,480,82.7,337.37,82.58,254.91,82.5,181.44,129.13,149,207.12,116.41,285.34,128,359.7,184.75,422.79c57.24,63.7,131.44,85.81,212,57.25,40.1-14.24,74.15-12.91,111.23.16,3.18,1.09,6.58,1.45,9.72,2.58,14.24,5.25,20.42,2.63,15.05-13.92C528.35,455.51,526.38,441.31,521.29,428.24Zm-279-105.58c-18.23-.32-34.42-16.3-34.9-34.61-.52-19.33,15.57-36.19,34.9-36.43s36.15,16.17,36.27,35.34C278.63,305.47,260.88,323,242.28,322.66Zm93.43-.08c-19.08-.4-35.54-17.75-34.81-36.75.68-18.64,16.54-34,35.18-34.17,19.56-.12,35.86,16.09,35.7,35.54S355,323,335.71,322.58Zm94.37,0c-18.64.16-36-17.35-35.75-36.07.24-18.23,16.26-34.33,34.7-34.89,19.44-.57,36.07,15.37,36.27,34.77C465.5,306.12,449.6,322.46,430.08,322.62Z"></path>
                            <path
                                d="M670.64,340.09c-1.65,12.18-8.67,19.77-20.17,23.56-25.25,6.41-50.75,3.15-76.21,2.22-9.4-4.48-1.41-10.25-.36-14.57C615,184,490.27,32.55,318.61,42.07,195.72,48.85,97.61,152.33,91,273c-6.82,122.84,82,236,199.86,255.86,10.65,1.81,15.62-3.6,22.31-9.32,12-10.33,35-10.17,46.56-.25,13.91,11.94,17.18,27,9.84,43.53-7.54,17-21.79,22.68-39.62,20.58-6.17-.73-13.39-2.26-16-7.3-9.36-17.75-27-17.47-42.77-21.59C178.9,530.59,114.87,474,79.7,386c-6.38-15.9-13.8-19.85-29-18.88s-31.31,2.22-41.47-13.48C3.28,349.49.94,343.15.9,336.46c-.07-35-2.82-70,1.66-105,5.81-19.29,20.33-25.91,38.65-24.21,14.68,1.37,20-4.68,25.13-18C107.05,84.51,183.62,22.55,294.16,2.46c4.52-.85,9.32-.37,14-.53a203.73,203.73,0,0,1,56.24,0c113,11.86,190.26,72.42,237.42,174,1.69,3.67,3.79,7.39,4.31,11.26,2.3,16.38,11,21.14,27.48,20.25,23.56-1.25,34,9,37.72,31.83C672.62,272.92,673.83,306.52,670.64,340.09Z"></path>
                        </svg>
                    </div>

                    <div class="dc_content">
                        <h4>Dedicated Sales & Support
                        </h4>
                        <p>Personalized support and sales advice from our team, committed to your success every step of
                            the way.

                        </p>
                    </div>
                </div>

                <div class="dc_item">
                    <div class="dc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 461.68 370.03">
                            <path
                                d="M323.48,52.4c16.82,2.14,33,6.48,48,14.27,50.79,26.37,82,67.33,89,124.63A158.67,158.67,0,0,1,327.82,368c-85.64,13.58-165.06-41.51-182.38-126.24-17.89-87.51,41.63-174,129.77-188.7,3.88-.65,5.82-.14,7.89,3.92,4.38,8.61,12.78,10.78,21.75,9.91,8-.77,14.88-3.8,17.57-12.42A14.58,14.58,0,0,1,323.48,52.4ZM429.3,210.54c.12-69.44-56.84-127.13-125.66-127.27-70.78-.13-128.58,56.07-128.71,125.16-.14,71.95,56.35,129.47,127.1,129.44C372.07,337.83,429.17,280.7,429.3,210.54Z"></path>
                            <path
                                d="M60.9,217c-16.32,0-32.63,0-48.94,0-5.67,0-9.46-2.72-11.21-7.51-1.66-4.55-.56-9.78,3.33-12.6a13.34,13.34,0,0,1,7.24-2.7q49.44-.27,98.87-.08c7,0,11.38,4.2,11.85,10.35.55,7.31-4.38,12.51-12.2,12.55C93.52,217.05,77.21,217,60.9,217Z"></path>
                            <path
                                d="M78.85,158.26c-13.48,0-27,0-40.44,0-7.87,0-13-4.58-13-11.33s5.22-11.65,12.88-11.67c27.29-.06,54.59-.1,81.88,0,9.56,0,15.23,8.05,11.7,16.11-2.09,4.77-5.85,6.93-11.09,6.9C106.78,158.21,92.82,158.26,78.85,158.26Z"></path>
                            <path
                                d="M79.43,252.88c13.48,0,27,0,40.44,0,7.85,0,12.92,4.54,13,11.39s-5,11.64-12.82,11.67q-40.95.14-81.89,0c-7.77,0-12.91-5-12.77-11.72s5.25-11.32,13.08-11.34C52.13,252.85,65.78,252.88,79.43,252.88Z"></path>
                            <path
                                d="M116.83,101.27c-11.32,0-22.65.06-34,0-8.32-.06-13.49-4.53-13.52-11.45s5.17-11.69,13.38-11.72q34.71-.09,69.43.19c7.25,0,11.88,4.71,11.9,11.39s-4.63,11.42-11.76,11.54c-11.82.19-23.64,0-35.46,0Z"></path>
                            <path
                                d="M117,332.64c-11.82,0-23.64.15-35.46,0-9.29-.15-14.77-8.68-10.89-16.65a10.55,10.55,0,0,1,10-6.27c24.14-.06,48.28-.14,72.42,0,6.72,0,11.15,5.14,11,11.67s-4.75,11.09-11.62,11.2C140.61,332.77,128.78,332.64,117,332.64Z"></path>
                            <path
                                d="M303.32,27.85c-8.48,0-17,.06-25.45,0s-11.66-3.44-11.76-11.93c0-2.16-.1-4.34.07-6.49.48-6.14,3.83-9.35,10-9.37q27.19-.09,54.4,0c5.78,0,9,3.05,9.43,8.72a61.25,61.25,0,0,1,.08,8.46c-.46,7.74-3.46,10.53-11.35,10.6C320.29,27.91,311.81,27.85,303.32,27.85Z"></path>
                            <path
                                d="M301.9,32.23c13,0,12.44,0,13.19,13.53.83,14.83-9.64,15.71-18.94,13.57-4.38-1-6.72-4.14-6.81-8.69-.09-4.81.09-9.64-.08-14.45-.11-3.12,1.27-4.12,4.17-4S299.08,32.23,301.9,32.23Z"></path>
                            <path
                                d="M306.73,153.37c0,12.83,0,25.66,0,38.48,0,3.07.51,5.08,3.78,6.6,7.31,3.41,10.42,11.09,8.38,18.88-1.76,6.73-8.43,11.67-15.69,11.64a16.14,16.14,0,0,1-15.67-12.3,15.61,15.61,0,0,1,8.67-18.28c3.59-1.61,3.84-4,3.82-7.14q-.19-38.72-.25-77.42c0-2.09-1-5,2.91-5.1,3.37-.1,4.16,1.62,4.13,4.67C306.66,126.72,306.73,140.05,306.73,153.37Z"></path>
                            <path d="M330,195.93l-9.45-10.17,24.21-24.2,10.13,10.1Z"></path>
                        </svg>
                    </div>

                    <div class="dc_content">
                        <h4>Easy & Fastest Service
                        </h4>
                        <p>Streamlined processes for the quickest, hassle-free US company formation experience.


                        </p>
                    </div>
                </div>
                <div class="dc_item">
                    <div class="dc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 939.95 939.48">
                            <path
                                d="M704.7,61.56c2.1,23.91,4.12,47,6.2,70.76l69-17.09c-2.61,23.83-5.13,46.79-7.73,70.55l71-3.29c-7.19,22.79-14.13,44.81-21.33,67.66L892,260.74,857.86,323l66.87,24-45.68,54.4L940,438.06l-55.43,44.46,52.58,47.77-63.05,32.82,42.24,57.09-68.23,19.91c10.09,21.39,20,42.4,30.28,64.23l-70.8,6.21c5.72,23,11.29,45.39,17.14,68.88l-70.63-7.68c1.12,23.53,2.21,46.72,3.36,70.91l-67.77-21.29c-3.54,23.58-7,46.55-10.56,70.21l-62.27-34.16c-8.06,22.37-16,44.33-24.07,66.85l-54.43-45.66c-12.21,20.28-24.27,40.33-36.64,60.87l-44.48-55.4-47.8,52.53-32.84-63-57.11,42.21c-6.68-22.88-13.22-45.25-19.91-68.18l-64.28,30.22c-2.09-23.87-4.13-47.06-6.21-70.73L160.1,824.27c2.58-23.6,5.1-46.68,7.71-70.59l-71,3.36,21.34-67.74L47.92,678.74C59.41,657.8,70.6,637.42,82.09,616.5L15.22,592.44c15.35-18.28,30.31-36.1,45.68-54.39L0,501.41,55.43,457,2.85,409.17l63-32.79L23.66,319.25l68.2-19.87L61.63,235.13l70.77-6.21c-5.74-23.08-11.35-45.64-17.14-68.9l70.63,7.7c-1.12-23.72-2.21-46.95-3.34-70.93l67.73,21.34c3.52-23.32,7-46.38,10.59-70.23L323.14,82c8-22.21,15.92-44.19,24.07-66.83l54.42,45.65L438.28,0l44.47,55.4L530.56,2.84l32.83,63,57.12-42.21c6.69,22.88,13.23,45.29,19.92,68.18ZM172.91,683.63c89,124.39,257.06,188.28,419,131.21,160.73-56.66,234.12-201.73,241.9-308-1.84.42-3.61.77-5.35,1.23-45.65,12.24-91.27,24.56-137,36.61-4.56,1.2-6.65,3.37-8.47,7.64C646.2,639,581,688.41,487.26,697.37c-60.3,5.77-114.47-12.61-161.76-50.61a8.44,8.44,0,0,0-8.52-1.83q-53.22,14.49-106.53,28.68C198.12,676.92,185.78,680.19,172.91,683.63ZM766.8,255.88C687.54,142.38,528.36,70,364.58,119.27c-171.14,51.53-250.4,202.51-258.37,313.4,1.33-.29,2.63-.52,3.89-.86q69.69-18.66,139.38-37.26a8.91,8.91,0,0,0,6.82-6.16c56.42-146.21,236.87-194.16,358.59-95.31a7.57,7.57,0,0,0,7.67,1.54q52.53-14.21,105.11-28.25ZM592.94,302.46c-40.21-32.58-109.68-53-179.14-33.36a207.71,207.71,0,0,0-80.3,43.07c-22.93,19.83-50.43,57.75-53.58,74.13ZM346.51,637.14c108.46,80.81,263.81,35.7,313.77-84ZM234.66,599.51c-11.8-44-23.42-87.33-35.16-131.1-6.46,1.69-12.39,3.2-18.29,4.8-10.81,2.92-10.6,2.92-9.55,14.09,2.16,23,4.09,46,6.12,69a9.2,9.2,0,0,1-2.61-3.59c-10.08-21.74-20.12-43.5-30.29-65.19-.66-1.42-2.53-3.6-3.37-3.4-9.14,2.13-18.18,4.67-27.4,7.14,11.82,44,23.44,87.39,35.18,131.16l21.41-5.76c-6.91-25.83-13.68-51.17-20.45-76.51l.84-.27L184.61,613l14.74-4.07c-2.41-26.53-4.76-52.51-7.11-78.48l.82-.16c6.72,24.94,13.43,49.87,20.2,75Zm144.06-38.58c-11.83-44.16-23.45-87.48-35.16-131.16l-21.42,5.74c6.34,23.74,12.59,47.11,18.84,70.48a8.72,8.72,0,0,1-2.67-3.06q-17-29.12-34-58.2c-.83-1.41-2.64-3.57-3.55-3.36-7.07,1.58-14,3.65-21.26,5.64,11.82,44,23.47,87.46,35.18,131.14l21.39-5.83L316.9,500.58a9.53,9.53,0,0,1,3.42,3.71c11.63,19.62,23.21,39.26,34.95,58.81.81,1.35,3,3,4.2,2.8C365.78,564.61,372,562.74,378.72,560.93ZM572.28,433.6c1.69-3.71,4-7.3,5-11.22,2.8-10.85.57-21.18-4.76-30.83-5.87-10.63-15.11-16.47-27.19-14.71s-23.88,5.32-36.1,8.15c11.91,44.38,23.56,87.82,35.33,131.68,12.42-3.44,24.23-6.3,35.77-10,8.7-2.82,14.45-9.31,17.55-17.95C605.65,466.88,593.51,441.09,572.28,433.6ZM248.19,454.49c-1.11.11-2.77.22-4.42.44-20.87,2.78-33.21,18.61-28.43,37.75,6.52,26.14,13.6,52.16,20.95,78.09,4.1,14.48,16.15,22.16,31.17,21.08,22.06-1.57,36.27-18.59,31.29-38.45-6.51-26-13.59-51.82-20.75-77.63C274.32,462.53,262.28,454.12,248.19,454.49Zm570-11.23c-1.76-2.09-2.9-3.46-4.07-4.81-15.84-18.25-31.63-36.54-47.58-54.68a8.42,8.42,0,0,1-2.27-8.06c3-14.18,5.74-28.39,8.54-42.6,1.24-6.25,2.37-12.53,3.64-19.28-3,.8-5,1.37-7.14,1.92-13.23,3.53-13.14,3.54-15.19,17.16-1.87,12.37-4,24.72-6,37.08h-.84l-12.21-45.12-21.37,5.78c11.75,43.86,23.4,87.32,35.16,131.18L770.3,456c-4.53-17.07-8.88-33.43-13.24-49.79l1.27-.53c1.15,1.34,2.33,2.65,3.43,4,9.84,12.39,19.62,24.84,29.58,37.13,1,1.23,3.29,2.46,4.65,2.16C803.12,447.47,810.13,445.42,818.23,443.26ZM607.09,499.81l20.16-5.44c-1.35-10.67-2.65-21-4-31.6l20.45-5.37,12.49,29.23L677,481.05c0-.78.11-1.14,0-1.4q-28.86-60.28-57.88-120.48c-.56-1.15-3.15-2.15-4.54-1.89-4.73.89-9.29,2.57-14,3.57-3.23.68-4.13,1.95-3.84,5.4,2.35,28.53,4.42,57.08,6.61,85.63C604.53,467.62,605.8,483.36,607.09,499.81ZM717.2,370.56c-2.27-6.38-3.55-12.38-6.39-17.51-9.12-16.45-30.44-20.08-48-8.64-10.69,6.95-16,18.83-12.83,31.11,6.78,26.41,14,52.73,21.14,79a27.52,27.52,0,0,0,13.19,16.9c12.14,7.07,31.72,4.16,42.22-6.2,9.85-9.7,11.65-25.93,4.21-39.45L710,431.44c.84,3.32,1.6,6.19,2.3,9.07,1.63,6.76-1.1,12.9-6.38,14.38-6.2,1.74-11.85-1.84-13.84-8.9-2.2-7.85-4.27-15.73-6.39-23.6-4.45-16.54-9-33.07-13.29-49.64-1.8-6.9,1.3-12.86,7.08-14.55,5.4-1.58,11,2.14,13,8.73.93,3,1.74,6,2.74,9.47ZM437,525.2l-32.5,8.57c-3.82-14.25-7.56-28.17-11.37-42.38l21.55-6c-1.73-6.46-3.31-12.36-5-18.63L388,472.31l-8.47-31.9,30-8.22c-1.74-6.49-3.32-12.37-5-18.76L353,427.24l35.19,131.22,54-14.52C440.35,537.28,438.73,531.38,437,525.2ZM408.68,412.32c1.28,2.14,2.18,3.71,3.14,5.23q20.35,32.32,40.66,64.68a33,33,0,0,1,3.7,8.6c4.23,15.19,8.26,30.44,12.45,46l20.74-5.57c-3.35-12.45-6.64-24.45-9.77-36.49-1.42-5.45-3.58-11-3.55-16.48.09-16.64,1.24-33.28,1.66-49.92.29-11.43.06-22.88.06-34.56L458,399.11c1,21.86,2,43.47,3,65.08a13.53,13.53,0,0,1-3.75-4.89c-8.65-16.32-17.34-32.62-25.88-49-1.35-2.59-2.55-3.72-5.72-2.64C420.37,409.47,414.83,410.68,408.68,412.32Z"></path>
                            <path
                                d="M502,799.29a5.62,5.62,0,0,1-1,.55c-10.66,1.47-10.67,1.48-14.51-8.42l-18.2-47a7.79,7.79,0,0,0-2-3.32c1.71,20,3.42,39.9,5.18,60.41l-9.07.58c-1.33-24.69-2.64-49.06-4-74,3.44-.27,6.75-1,9.93-.59,1.34.15,2.94,2.29,3.57,3.87,6.77,17.17,13.38,34.4,20,51.62a11.7,11.7,0,0,0,2.07,3.8c-1.66-20-3.31-39.93-5-60.57l9.06-.42C499.41,750.49,500.73,774.85,502,799.29Z"></path>
                            <path
                                d="M557.71,711.13l7.84-3.6c3.67,8.29,7.14,16.16,10.64,24,3.19,7.16,5,7.83,12.31,4.62,2.1-.93,4.19-1.9,6.65-3-4.74-10.83-9.38-21.4-14.19-32.39l8-3.53,30.06,68.14c-7.69,3.23-14.84,6.81-22.37,9.11-2.83.87-7-.41-9.8-2.08-6.85-4.16-10.94-19.23-7.63-27.4-7.2-.61-9.53-6.12-11.88-11.74C564.36,726.08,561.14,719,557.71,711.13Zm41.21,30.52c-16,5.13-15.62,7.46-9.72,19.41.36.75.48,1.88,1.07,2.2,1.83,1,4.11,2.73,5.71,2.3,3.9-1,7.51-3.14,11.34-4.86C604.43,754.13,601.75,748.07,598.92,741.65Z"></path>
                            <path
                                d="M662.81,738.63l-10.57,7.15L597.4,693.07l7.45-5L622.2,706l13-8.8L625.5,674.2l7.25-5C642.85,692.54,652.74,715.37,662.81,738.63Zm-34.25-26.4L651.38,734c-4.1-9.38-8.21-18.83-12.51-28.68Z"></path>
                            <path
                                d="M553,789.85c-4.16,1-8,2.21-11.87,2.9a4,4,0,0,1-3.37-1.69q-15.08-32.84-29.88-65.77c7.39-3.88,8.09-3.66,11.17,3.34,1.81,4.11,3.84,8.15,5.32,12.37,1.29,3.67,3.21,4.4,6.74,3.12,3.1-1.13,6.43-1.66,10.39-2.63-.37-8.16-.76-16.38-1.15-25l8.48-2C550.2,739.76,551.56,764.44,553,789.85Zm-9.88-7.73.83-.3c-.61-10.34-1.21-20.68-1.84-31.47l-12,3C534.58,763.35,538.84,772.74,543.09,782.12Z"></path>
                            <path
                                d="M697.82,710.17l-4.6,5c-11.49-10.9-22.59-21.39-33.63-31.95q-5.4-5.19-10.47-10.71c-5.37-5.82-5.25-13,.24-18.76,2.3-2.41,4.69-4.74,7.19-6.93,5.83-5.09,12.88-5,18.35.54,14.17,14.32,28.2,28.77,42.62,43.51l-5.27,4.44c-11.48-10.88-23.33-22.07-35.13-33.31-2.77-2.64-5.36-5.46-8-8.2-2.45-2.48-4.73-2.34-7.37,0-10,8.88-10,8.92-.8,18.32q17,17.26,33.88,34.61C695.82,707.76,696.73,708.92,697.82,710.17Z"></path>
                            <path
                                d="M717.62,659.9l5-6.73a14,14,0,0,1,2,1.15c8,6.71,8.81,3,13.35-3.16,1.8-2.44,1.44-4.72-1-6.49Q717.74,630.79,698.48,617c-2.66-1.91-5-1.43-6.87,1.2-.87,1.22-1.7,2.47-2.64,3.63-2.37,2.94-2,5.45,1,7.62,3.38,2.4,6.74,4.82,10.32,7.38l4.35-5.07,6.83,4.92-9,12.54c-6.86-5.08-13.61-10.07-20.34-15.08a3.72,3.72,0,0,1-.65-.76c-4.72-6.09-3.3-13.3,4.3-21.82,4.52-5.07,11.41-6.22,17.12-2.22q20,14,39.7,28.56c6,4.41,7,11.5,3,17.75-1,1.54-2.1,3-3.18,4.47-5.43,7.42-12.35,8.63-19.88,3.44C721.05,662.52,719.62,661.39,717.62,659.9Z"></path>
                            <path
                                d="M314.47,767.61l3.42-8,16.7,7c2.86-6.58,5.57-12.79,8.44-19.37l-14.56-6.62,3.31-7.83L346.54,739l10.64-24.47-16.5-7.29,3.34-7.92L368.63,710l-29.58,68.21Z"></path>
                            <path
                                d="M394.82,727.22l-17.39-5c.73-2.71,1.41-5.2,2.23-8.24l25.86,7-19.63,71.73L360,785.71c.77-2.81,1.46-5.3,2.31-8.36l17.44,4.58c1.89-6.82,3.74-13.46,5.69-20.5L370,757.05c.8-2.84,1.5-5.32,2.31-8.21l15.45,4Z"></path>
                            <path
                                d="M427.92,724.86l8.53,1.09c-2.58,21.68-5.11,42.94-7.72,64.81l11.47,1.69c-.33,2.76-.64,5.32-1,8.57l-31.85-3.8c.37-3,.66-5.42,1-8.42l11.69.87C422.67,768.1,425.27,746.7,427.92,724.86Z"></path>
                            <path d="M272.34,686.91a10.94,10.94,0,0,1,.07,21.88,10.94,10.94,0,1,1-.07-21.88Z"></path>
                            <path d="M752,580.25a10.85,10.85,0,1,1-.09-21.7,10.85,10.85,0,1,1,.09,21.7Z"></path>
                            <path
                                d="M451.4,215h-9.1c-1.19-24.37-2.38-48.77-3.62-74.14a66.83,66.83,0,0,0,8.18-.06c3.13-.42,4.33,1,5.34,3.71,6.42,17.14,13,34.22,19.52,51.31a12.17,12.17,0,0,0,2.43,4.18c-1.6-19.81-3.19-39.62-4.83-59.95l9-.93c1.23,24.8,2.44,49.31,3.68,74.3a70.65,70.65,0,0,0-7.62.57c-3.57.66-4.92-1.05-6.07-4.14-6.57-17.61-13.32-35.15-20-52.72-.4-1-.85-2.06-1.78-4.33C448.2,174.17,449.77,194.23,451.4,215Z"></path>
                            <path
                                d="M345.27,207.57c4.8,11.09,9.34,21.56,14.07,32.46l-8,3.5-29.73-68.21c7.49-3.17,14.51-6.54,21.82-9.09,4.51-1.57,9.66-.34,12.14,3.7,4.74,7.72,11.07,15.45,5.73,25.93,6.19.74,8.95,4.76,11,9.85,3.22,8,6.79,15.81,10.4,24.14l-7.87,3.49-10.29-23.48c-3.41-7.82-5-8.47-12.88-5.08C349.64,205.63,347.69,206.51,345.27,207.57Zm-12-27.6,8.57,19.53c3.09-1.33,5.86-2.12,8.16-3.63,1.95-1.28,5-3.82,4.69-5a90.49,90.49,0,0,0-6.09-15.35c-.3-.65-2.89-.76-4.12-.31C340.72,176.51,337.15,178.25,333.22,180Z"></path>
                            <path
                                d="M277.66,201.83l12.25-8.17,52.84,54.05-7.06,4.8L317.59,235,305,243.42c3.2,7.63,6.36,15.21,9.63,23l-7.25,4.92C297.48,248.15,287.68,225.26,277.66,201.83Zm34.21,26.49-22.05-20.08,11.62,27.08C305,232.93,308.13,230.82,311.87,228.32Z"></path>
                            <path
                                d="M402.06,147.63c10.32,23.11,20.43,45.72,30.81,69l-8.59,2.15-9.94-22.35c-.69-.13-1-.3-1.32-.23-14.38,3.31-14.38,3.31-13.48,17.93.21,3.31.4,6.61.63,10.36l-8.58,1.89c-.71-13.22-1.41-25.85-2-38.48-.54-10.82-.83-21.65-1.6-32.45-.27-3.7,1-5.06,4.41-5.56C395.45,149.39,398.48,148.47,402.06,147.63Zm8.43,40.12c-4.48-10-8.62-19.33-12.77-28.63l-.9.18c.52,10.29,1,20.58,1.59,31.34Z"></path>
                            <path
                                d="M222.63,249l5.74-5.72-1.09,1.79c10.88,10,21.8,20,32.61,30.13,3.64,3.4,7.05,7.07,10.43,10.74,2.79,3,5.33,3.38,8.44.33,9.64-9.46,10.11-8.16.53-17.93-12.33-12.57-24.52-25.28-37-38.15l5.8-6c4.21,4.19,8.11,8,11.9,11.84,10.11,10.37,20.23,20.73,30.23,31.19,6.41,6.71,6.14,13.57-.07,20.2-11.88,12.68-18.55,13.52-31-.25-10.58-11.73-21.92-22.79-32.91-34.15C225.16,251.85,224.08,250.62,222.63,249Z"></path>
                            <path
                                d="M222.49,280.26l-4.94,6.79c-1.27-.8-2.4-1.45-3.45-2.2-5.46-3.87-6.28-3.73-10.35,1.82s-3.85,6.49,1.54,10.41q17.36,12.65,34.73,25.23c4.77,3.44,5.88,3.13,9.92-2.4,3.68-5,3.55-6.39-1.06-9.8-2.93-2.17-5.93-4.26-9.15-6.57l-4.41,4.92-6.79-4.89c3.09-4.26,5.9-8.13,9.05-12.45,6.74,5,13.25,9.76,19.75,14.58a6.26,6.26,0,0,1,1,1.1c4.89,6.07,3.57,13.18-4,21.79-4.65,5.26-11.73,6.34-17.54,2.21q-19.71-14-39.17-28.46c-6.16-4.57-7.16-11.7-3-18.13,1.09-1.67,2.31-3.26,3.54-4.83,5.08-6.52,12.08-7.69,18.89-3.13C218.83,277.44,220.5,278.79,222.49,280.26Z"></path>
                            <path
                                d="M571.7,231.79c10-22.84,19.85-45.18,29.9-68.07l24.58,10.75c-1.19,2.67-2.24,5.05-3.52,7.93l-16.59-7-8.61,19.3,14.59,6.77-3.43,7.79-14.69-6.36-10.76,24.37,16.49,7.42-3.39,7.9Z"></path>
                            <path
                                d="M554.82,148.94l25.71,7.14c-.73,2.8-1.38,5.29-2.18,8.39l-17.5-4.63c-1.91,6.8-3.78,13.41-5.76,20.43l15.42,4.51c-.77,2.77-1.47,5.25-2.28,8.15l-15.48-4.07c-2.37,8.48-4.67,16.73-7.14,25.59l17.28,5c-.7,2.67-1.34,5.14-2.16,8.26l-25.86-7.15C541.56,196.55,548.14,172.94,554.82,148.94Z"></path>
                            <path
                                d="M533.45,144.38c-.45,3.17-.8,5.73-1.21,8.64l-5.78-.64c-1.79-.19-3.58-.36-5.8-.58-2.73,21.73-5.42,43.11-8.16,64.81l-8.53-.92c2.66-21.6,5.3-43,8-64.85l-11.48-1.91c.37-2.83.68-5.25,1.08-8.41Z"></path>
                            <path d="M664.24,252.94a10.82,10.82,0,0,1-11-10.62,10.95,10.95,0,1,1,11,10.62Z"></path>
                            <path
                                d="M184.39,381.33a10.88,10.88,0,1,1,.45-21.76c6.3.14,10.79,5,10.6,11.38A10.55,10.55,0,0,1,184.39,381.33Z"></path>
                            <path
                                d="M549.58,449.79c12.94-4.68,20.48-1.51,25.48,10.28a52.16,52.16,0,0,1,2.21,6.6c3.85,14.15-1.32,22.2-16.45,24.93C557.1,477.79,553.38,463.92,549.58,449.79Z"></path>
                            <path
                                d="M535.85,398.55c6.18-1.35,12-5.46,17.27,0a23.13,23.13,0,0,1,6.21,21.1c-1.49,7.25-8.8,7.52-15.12,9.93C541.38,419.06,538.66,409,535.85,398.55Z"></path>
                            <path
                                d="M277.32,559.65c0,6.81-3.13,11.29-7.89,12.14-5.29.93-10.51-2.51-12.28-8.68-3.33-11.67-6.38-23.42-9.53-35.14q-5.06-18.78-10.06-37.57a21.33,21.33,0,0,1-1-5.87c.19-5.19,3.93-9.57,8.53-10.4,4.35-.79,9.6,2.57,11.44,7.88,1.63,4.7,2.71,9.59,4,14.4q7.94,29.62,15.86,59.26C276.85,557.26,277.15,558.89,277.32,559.65Z"></path>
                            <path d="M617,396.05l18.18,43.09-13.46,3.54c-1.94-15.85-3.8-31.11-5.66-46.36Z"></path>
                        </svg>
                    </div>

                    <div class="dc_content">
                        <h4>60-Day Money Back Guarantee

                        </h4>
                        <p>Enjoy peace of mind with our 60-day money-back guarantee on service.


                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="article_e wantHide">
        <div class="container">
            <div class="ec_head" style="text-align: center; padding-bottom: 10px;">
                <h4>Our Services
                </h4>
                <h2 style="color: #ff5700">All You Will Get from Our Service

                </h2>
            </div>
            <div class="ec_items">
                <div class="ec_item">
                    <div class="ec_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 427.84 554.51">
                            <path
                                d="M142,.33c1.66-.11,3.31-.31,5-.32H416.57c8.88,0,11.27,2.34,11.27,11.14V543.32c0,8.73-2.48,11.18-11.26,11.18H11.7c-9.38,0-11.6-2.27-11.6-11.83q0-195.45-.1-390.9a18.22,18.22,0,0,1,5.67-14q65.27-66.36,130.21-133c1.34-1.37,2.36-3.29,4.59-3.57Zm-7,137.75c.18.35.35.71.53,1.06l.34-1.53q-.09-33.83-.16-67.66c0-12.92.15-25.85.23-38.78.77-.37.65-.71,0-1-1.69-.45-2.25,1-3.1,1.88Q82.29,83.7,31.77,135.42c-.82.84-2.38,1.43-1.73,3.17q49.2,0,98.32,0C130.59,138.55,132.91,139.29,135.07,138.08ZM410.89,537.23l.84-.49-.67-.46c-.08-2-.22-4-.22-6q0-252.87,0-505.74c0-7.68,0-7.69-7.44-7.69q-122.56,0-245.13-.12c-4.83,0-5.56,1.53-5.54,5.82.15,40.44.09,80.88.09,121.32,0,8.61-2.76,11.39-11.26,11.41-39.61.08-79.21.22-118.82.15-4.26,0-5.83.67-5.83,5.52q.24,185.46,0,370.94c0,4.42.92,5.71,5.57,5.7q191.71-.21,383.43-.12C407.59,537.51,409.24,537.33,410.89,537.23Z"></path>
                            <path d="M142,.33l-1.55.81A1.38,1.38,0,0,1,142,.33Z"></path>
                            <path d="M135.07,138.08l.87-.47-.34,1.53Z"></path>
                            <path d="M136,31.17l0-1C136.66,30.46,136.78,30.8,136,31.17Z"></path>
                            <path d="M410.89,537.23a1.37,1.37,0,0,1,.17-1l.67.46Z"></path>
                            <path
                                d="M70.43,241c-3.42-2-3.87-5.31-3-8.66a8,8,0,0,1,7.15-6.06,43.52,43.52,0,0,1,5.48-.21q74.64,0,149.27.08c3.87,0,5-.92,4.91-4.85-.24-15.8-.15-31.61-.06-47.42a8.7,8.7,0,0,0-2.23-6.27c-5.57-6.39-10.83-13.05-16.4-19.43a16.38,16.38,0,0,1-4.36-10.27c-.65-12-1.52-23.9-2.37-35.85a11.91,11.91,0,0,1,1.86-7.55q10-15.76,19.81-31.66a12.49,12.49,0,0,1,6.38-5.23Q253.76,51,270.53,44.08a13.61,13.61,0,0,1,8.75-.78c11.89,3,23.76,6,35.66,9a12.67,12.67,0,0,1,7,4.34Q333.86,71,346,85.28A12.42,12.42,0,0,1,348.86,93q1.14,18.42,2.57,36.82a12.52,12.52,0,0,1-2.27,7.94c-6.66,10.52-13.24,21.09-19.9,31.61a9.68,9.68,0,0,0-1.77,5.5c.08,15.81.12,31.62,0,47.43,0,3.11.83,4,3.91,3.84,6.48-.24,13-.14,19.46-.06,6.29.09,10.08,3.44,10,8.64-.09,5.38-3.59,8.26-10.14,8.3s-13.32.11-20,0c-2.34,0-3.36.62-3.17,3.08.16,2.15,0,4.32,0,6.48.13,4.31-1.72,7.58-5.71,9s-7.39,0-10.09-3.4c-8.62-10.77-17.32-21.47-26-32.19-1-1.28-2.12-2.52-3.29-3.91-10.75,12-21.36,23.68-31.81,35.51-3,3.43-6.41,5.56-10.89,3.94s-5.6-5.65-5.63-10.13c-.07-8.34-.14-8.34-8.26-8.34q-72.88,0-145.77,0c-2,0-4-.18-6-.28C73.77,240.33,72,241,70.43,241Zm239.48-11.82c.08.74-.29,1.65.68,2.06.18.08.5-.2.75-.31l-1.07-1.42c.84-15.93.17-31.87.35-47.8,0-3.29-2-1.69-3.32-1.18C301.14,183,295,185.39,288.89,188a10,10,0,0,1-6.28.89c-9.93-2.53-19.81-5.2-29.71-7.83-.29-.63-.6-.9-1-.08-1.27.79-.81,2.07-.81,3.15q0,22.42,0,44.84c0,.64-.08,1.34,1.1,1.43,7.89-8.75,15.82-17.67,23.89-26.46,4.33-4.72,9.63-4.74,13.65.11C296.57,212.3,303.19,220.78,309.91,229.18ZM226,105.5c.38,4.94,1.11,9.1.94,13.22-.5,12.17,2.58,22.78,12.11,31a20.59,20.59,0,0,1,3.83,4.58c4.34,6.83,10.37,10.58,18.49,11.78,6.35.94,12.53,3.06,18.79,4.67a11.38,11.38,0,0,0,7.65-.61c8.23-3.49,16.54-6.79,24.87-10a9.19,9.19,0,0,0,4.94-3.82c4.94-8.05,10-16,15-24a7.91,7.91,0,0,0,1.63-5.06c-.74-9-1.32-17.9-1.84-26.86a15.16,15.16,0,0,0-4.08-9.77c-5.54-6.17-10.81-12.61-16-19.1a11.14,11.14,0,0,0-6.51-4c-9-2.18-18-4.36-27-6.69a6.82,6.82,0,0,0-4.75.26c-8.87,3.69-17.76,7.32-26.71,10.78a9.77,9.77,0,0,0-5.15,4.33c-4.67,7.64-9.4,15.25-14.27,22.76C226.42,101.19,225.52,103.51,226,105.5Z"></path>
                            <path
                                d="M155.84,381.18c1.6-2.34,4-2.74,6.57-2.74,23.63,0,47.26-.05,70.89,0,5.65,0,9.26,3.27,9.42,8.12s-3.63,8.73-9.41,8.76c-19.3.1-38.6.15-57.91-.05-4,0-5.31.84-5.28,5.11q.3,45.18,0,90.36c0,3.81.8,5,4.85,5q45.42-.27,90.85,0c3.76,0,5-.7,5-4.78-.17-20.13,0-40.25.11-60.38.13-.08.38-.19.37-.23a4.41,4.41,0,0,0-.29-.71c1.85-5.1,5.23-7.52,9.41-6.75,4.41.81,7.28,4.26,7.3,9.31q.09,35.61,0,71.21c0,4.58-2.07,7.93-6.93,8.91-.36-.51-.67-.46-.94.08q-41,.11-82.07.2c-12.27,0-24.53-.14-36.8-.22-.26-.55-.58-.57-.93-.08-4.32-.81-6.25-3.66-6.67-7.79,2.52-.87,1.57-3,1.58-4.67.07-11.61.06-23.21,0-34.82q-.08-41.3-.19-82.58l-.05.08Z"></path>
                            <path
                                d="M213.42,354.88q-67.38,0-134.78,0c-2.28,0-4.67.48-6.82-.73-3.16-1.78-4.91-4.46-4.69-8.16s2.28-6.09,5.68-7.45c2.09-.83,4.26-.63,6.41-.63H349.28a21.49,21.49,0,0,1,5,.35,8.33,8.33,0,0,1,6.54,9.26c-.73,4.47-3.43,7.18-8.08,7.33-5.15.16-10.31.05-15.47.05Z"></path>
                            <path
                                d="M221.76,455.05c4.6-7.68,9-15,13.41-22.37q13.67-22.81,27.32-45.64c1.47-2.46,3-4.81,6.08-5.43,3.52-.7,6.71-.08,8.91,2.94,2.4,3.3,2.21,6.79.15,10.23Q265,415.9,252.41,437q-11,18.35-22,36.67c-4.8,8-11.51,8.11-16.65.28q-11.33-17.25-22.57-34.57c-3.45-5.3-2.87-10.3,1.44-13.14s9-1.65,12.63,3.65c2.79,4.12,5.41,8.35,8.14,12.52C216,446.46,218.72,450.46,221.76,455.05Z"></path>
                            <path
                                d="M154.81,382.41q.1,41.29.19,82.58c0,11.61,0,23.21,0,34.82,0,1.64.94,3.8-1.58,4.67-.07-19.59-.17-39.17-.2-58.76,0-18.76,0-37.52,0-56.28C153.17,387,153,384.46,154.81,382.41Z"></path>
                            <path
                                d="M360.54,293.72c-1.87,2.88-4.15,5.15-7.83,5.42l-3.95,0-2-.49a19,19,0,0,1-7,.05l-10,.36-9.94-.42-1,.05-3,0h-9l-2,0-1,0h-2l-1,0-1-.05-8,.07h-2l-4-.08h-1a17.83,17.83,0,0,1-7,0l-5,.1h-2l-8-.09h-1a97.64,97.64,0,0,1-16,0l-2,.11-17-.17a39.6,39.6,0,0,1-10,.07l-2,0h-5l-1-.07-3,.13-10-.07-1,0-4,0h-1a32.64,32.64,0,0,1-8.94,0l-1,.06-4-.07h-1l-6,.44-1-.43-2,0-3,0h-2l-3,0-3,0-9,.37-5,0-4-.44a52.26,52.26,0,0,1-12,.06l-4,.35-3,0-1-.06-17,0,.13-.37H94.09l-1,.45-1-.35-5.06.37.07-.4c-4,.07-8,.27-11.93.15a8.11,8.11,0,0,1-8-7.34c-.44-4.69,2.19-8.25,7-9.09a49.34,49.34,0,0,1,11.9-.2l2.15,0,.91-.51,4.92.49h3.15l3.84,0,2.17.15,13.88-.54,3.92.39,2.16.08,1.8.1a6,6,0,0,1,4.17-.15l3.93-.48.93.48h17l2.16,0h3.83a3.77,3.77,0,0,1,3.15-.06,9.57,9.57,0,0,1,4.81.22l2.18-.24,10.91-.36,2,0,1,.4,1-.5,2.1.69,2.81-.12,2.16-.07,5.91.1,9-.07,5-.41h15l5,.48,13.92-.08,2.15,0,3.15,0,1.66.18,18.08-.66,2-.06,2,.58a9.81,9.81,0,0,1,5,0l3-.55,5,0,6.91.44,2.19.23,2.78-.09,2.18-.12h6.9l11.93,0h2.14l.92-.48,9,.09,6,.33a2,2,0,0,1,2.11.27h1.84a3.34,3.34,0,0,1,3.14-.23l5,.09a.53.53,0,0,1-.08-.6l2.06.59C358,281.81,361.33,285.3,360.54,293.72Z"></path>
                            <path d="M70.43,241c1.52,0,3.34-.67,3.71,1.76A4.06,4.06,0,0,1,70.43,241Z"></path>
                            <path d="M155.84,381.18l-1.08,1.31Z"></path>
                            <path d="M271,429.61a4.41,4.41,0,0,1,.29.71s-.24.15-.37.23A1,1,0,0,1,271,429.61Z"></path>
                            <path d="M160.06,512.27c.35-.49.67-.47.93.08l-.48.09Z"></path>
                            <path d="M279.86,512.37c.27-.54.58-.59.94-.08Z"></path>
                            <path
                                d="M309.91,229.18a.35.35,0,0,1,.36.33l1.07,1.42c-.25.11-.57.39-.75.31C309.62,230.83,310,229.92,309.91,229.18Z"></path>
                            <path d="M252.9,181l-1-.08C252.3,180.12,252.61,180.39,252.9,181Z"></path>
                        </svg>
                    </div>

                    <div class="ec_content">
                        <h4>Free US Company Registration
                        </h4>
                        <p>Start your US business journey with our $0 registration offer.
                        </p>
                    </div>
                </div>
                <div class="ec_item">
                    <div class="ec_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 249.77 282.51">
                            <path
                                d="M187.75,59.9A312.27,312.27,0,0,1,180,111.08c-.24,1-.52,1.92-.75,2.89-.52,2.26-1.79,3.66-4.23,3.07-2.61-.63-2.62-2.74-2.13-4.79,2.15-8.88,4.06-17.81,5.36-26.85a288.38,288.38,0,0,0,2.89-34.74c.08-4-1.33-5.6-5.43-5.8-30.52-1.44-56.9-12-77.49-35.35-3.2-3.63-5.94-3.65-9.29-.2C68,30.76,42.39,41.8,12.84,44.35c-3.57.31-6.54.86-6.39,5.62,1.38,42.13,9.3,82.5,32.44,118.62C48.15,183,59,196.27,72.2,207.39c16,13.48,23.79,13,38.25-1.89,2.08-2.14,4.21-4.24,6.36-6.32,1.57-1.53,3.4-2.38,5.23-.56s1.09,3.62-.51,5.21c-4.24,4.21-8.29,8.65-12.79,12.57-10.27,8.94-19.64,9.66-31.52,2.7C67.94,213.66,60.54,206,53.3,198.22c-32.46-35-47-77.54-52-124.08A227.13,227.13,0,0,1,0,49.27C0,42,3.26,38.62,10.43,38,39.29,35.59,64.48,25.24,84.79,4c5.35-5.59,12.76-5.32,17.93.55,19.36,22,44.08,32.26,72.94,33.6,9,.41,12.19,3.85,12.1,12.75C187.73,53.92,187.75,56.91,187.75,59.9Z"></path>
                            <path
                                d="M93.85,194.7c-4.55,0-8.29-1.81-11.74-4.68-20.81-17.35-33.7-39.9-42.67-65A245.05,245.05,0,0,1,27.35,72.22c-.91-7.43.87-10,8-11.85A152.87,152.87,0,0,0,84.23,38.54c6-4,11.27-4,17,.15a142.65,142.65,0,0,0,51.43,23.1c6.77,1.58,8.61,4.57,7.67,11.51a283.09,283.09,0,0,1-5.48,29.87c-.6,2.43-1.09,5.45-4.56,4.54s-2.44-3.7-1.84-6.19c2.21-9.21,3.71-18.55,5.22-27.89.54-3.39-.2-5-3.91-5.85A138.94,138.94,0,0,1,98,44.4c-3.61-2.63-6.8-2.67-10.45-.15a151.82,151.82,0,0,1-49.7,22.32c-2.85.71-4.3,1.71-3.86,5,4.59,34.52,13.84,67.3,35.31,95.57A102.15,102.15,0,0,0,86.55,185c5.16,4.16,9.66,4.12,14.8-.1,2.44-2,4.74-4.16,7.07-6.29,1.68-1.53,3.51-2.16,5.26-.39s1,3.73-.68,5.18C107.35,188.4,102.55,194.87,93.85,194.7Z"></path>
                            <path
                                d="M192.82,153.57c-.52,3.82.08,8,1.68,12.75,2.55,7.53-1.95,14.87-5.67,21.5-1.44,2.59-2.86,5.15-4.06,7.86-3.66,8.2-9.11,14.64-17.86,17.69a25,25,0,0,1-29.48-10.85c-5-8.11-9.88-16.44-12.81-25.65-1.58-5-2.81-10,.68-14.77,1.39-1.9.66-4.19.47-6.31-.63-7.15-.08-14,5-19.65a3.49,3.49,0,0,0,.64-3.64,20.08,20.08,0,0,1-.57-5.41c.11-5.28,2.64-7.75,7.61-6.22,7.57,2.31,14.94,1.87,22.62,1,8.54-1,16.26,1,20.56,9.68a3.35,3.35,0,0,0,1.35,1.39C191.14,137.12,192.68,144.55,192.82,153.57Zm-6.58-.61c0-8-1-9.91-8.27-14.86a4.2,4.2,0,0,1-1.71-1.74c-3-8.7-9.94-8.73-17.15-7.64-5.63.85-11.16,1.41-16.78,0-1.47-.38-3.38-2-4.5-.21-1,1.52.48,3,1.72,4.25,1.82,1.79,2.43,4.24,0,5.45-8.18,4.07-7.83,11.13-7,18.4.36,3.09.27,6-1.38,8.66s-1.42,5.26-.68,8.1c2.27,8.73,7.26,16.27,11.59,23.88,8.68,15.25,27,14.13,35.31-1.49a59.38,59.38,0,0,0,2.79-6.91,11.66,11.66,0,0,1,2.26-4.36c3.6-3.74,4.6-8.68,5.88-13.46.31-1.15.42-2.42-1-3-3.45-1.36-2.69-4.06-2.28-6.71S185.85,155.75,186.24,153Z"></path>
                            <path
                                d="M93.66,78.71A30.95,30.95,0,1,1,63,110,30.94,30.94,0,0,1,93.66,78.71Zm24.42,31A24.34,24.34,0,0,0,93.84,85.24a24.34,24.34,0,0,0-.24,48.68A24.19,24.19,0,0,0,118.08,109.73Z"></path>
                            <path
                                d="M166.16,231.9h-13.7a1.21,1.21,0,0,0,.14,1.75c5.61,4.54,5.46,10.33,4.2,16.74-1.7,8.62-2.72,17.37-4.23,26-.45,2.53.07,6.6-4.16,6-4.71-.64-2.7-4.63-2.34-7.23q1.86-13.56,4.29-27.05c.7-3.84.53-6.92-2.53-9.91-2.46-2.42-5.9-5.12-4.13-9.36,1.86-4.46,6.16-3.78,9.93-3.83,4.81-.06,9.63-.09,14.43.09,2.71.1,5.41.84,6.58,3.66a5.72,5.72,0,0,1-1.91,6.77c-5.7,4.7-5.6,10.43-4.21,17,1.66,7.78,2.5,15.73,3.75,23.6.4,2.46.65,5-2.49,5.49s-3.68-2-4.06-4.44q-2.33-15.27-4.78-30.51c-.7-4.32-.44-8.25,3.34-11.27A3.94,3.94,0,0,0,166.16,231.9Z"></path>
                            <path
                                d="M75.53,280.69c-2.43-.4-3.46-2.15-2.62-4.3,4-10.14,6.3-21,12.76-30.07a35.36,35.36,0,0,1,15.1-11.79c8.65-3.78,17.26-7.65,25.92-11.4,2.34-1,5.23-3,6.87.53s-1.63,4.45-4,5.51c-8.63,3.82-17.25,7.67-25.92,11.4a30.23,30.23,0,0,0-17,17.81c-2.34,6.2-4.65,12.41-7,18.6C78.92,278.85,78.25,280.83,75.53,280.69Z"></path>
                            <path
                                d="M249.75,276.68c.12,2-.24,3.37-2,3.84a3.27,3.27,0,0,1-4.29-2.3c-2.27-6.05-4.72-12-6.83-18.14a32.3,32.3,0,0,0-19.15-20.24c-8.42-3.47-16.7-7.28-25.06-10.9-2.43-1.06-4.86-2.36-3.36-5.46,1.4-2.91,3.92-1.6,6.05-.67,9.4,4.13,18.82,8.2,28.15,12.48a34.73,34.73,0,0,1,18.33,19.36c2.56,6.47,4.95,13,7.39,19.52C249.3,275.09,249.55,276.05,249.75,276.68Z"></path>
                            <path
                                d="M87.72,122.24a5.43,5.43,0,0,1-2.14-.92q-4.12-3.94-8-8.17a3,3,0,0,1,.08-4.48c1.37-1.39,3-1.19,4.48-.07.14.1.25.22.39.31,2.28,1.4,3.29,5.55,6.35,4.54,2.41-.79,4.17-3.63,6.2-5.58q4.65-4.49,9.28-9c1.65-1.61,3.46-3,5.57-1s1,3.92-.73,5.56q-8.92,8.66-17.87,17.27A4.67,4.67,0,0,1,87.72,122.24Z"></path>
                        </svg>
                    </div>

                    <div class="ec_content">
                        <h4>Reliable Registered Agent

                        </h4>
                        <p>Secure a reliable Registered Agent service to ensure legal compliance and safeguard your
                            business's reputation.

                        </p>
                    </div>
                </div>
                <div class="ec_item">
                    <div class="ec_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 186.07 274.22">
                            <path
                                d="M130.5,147.48c-7-.09-14.09,0-21.14,0-3,0-3.94.89-3.94,4v60.47q0,30.14,0,60.28c0,1.64-.4,2-2,2q-30.14-.09-60.27,0c-1.57,0-2.07-.29-2-2q.16-11.31,0-22.63c0-1.73.52-2,2.06-2,3.46.11,6.93,0,10.39.06,1,0,1.5-.12,1.5-1.37,0-4.42.08-4.42-4.41-4.42-2.72,0-5.44,0-8.16,0-1.05,0-1.36-.3-1.35-1.36,0-6.62.07-13.23,0-19.85,0-1.55.74-1.47,1.81-1.47q15.39,0,30.78,0c5.87,0,11.74,0,17.62,0,1.19,0,1.56-.33,1.56-1.55,0-4.24.07-4.24-4.17-4.24-15.27,0-30.53,0-45.8,0-1.52,0-1.81-.45-1.79-1.85.07-6.3.11-12.61,0-18.92,0-1.76.57-1.94,2.08-1.93,15.88,0,31.77,0,47.65.07,1.78,0,2.1-.55,2-2.15-.1-3.71,0-3.71-3.64-3.71-15.39,0-30.79,0-46.18,0-1.49,0-2-.28-2-1.89q.15-9.55,0-19.1c0-1.43.41-1.73,1.77-1.72,7,.07,14.09,0,21.14.06,1.14,0,1.59-.19,1.58-1.49,0-4.25,0-4.25-4.17-4.25-6.24,0-12.49,0-18.73,0-1.16,0-1.59-.22-1.58-1.5.07-6.49.08-13,0-19.48,0-1.4.36-1.72,1.74-1.71,16,.05,32,0,48,.08,1.67,0,2-.44,2-2-.11-3.83,0-3.83-3.87-3.83-15.33,0-30.65,0-46,0-1.52,0-1.95-.33-1.92-1.89.1-6.43.08-12.86,0-19.29,0-1.22.31-1.54,1.53-1.53,7.11.06,14.22,0,21.32.06,1.32,0,1.64-.35,1.62-1.64-.07-4.16,0-4.16-4.09-4.16-6.24,0-12.48,0-18.73,0-1.26,0-1.7-.27-1.66-1.61.09-3.52.08-7,0-10.57,0-1.2.3-1.66,1.53-1.94q20.87-4.64,41.7-9.42c1.15-.26,1.59,0,2,1.15,8.15,24.93,23,44.85,44.84,59.46a2,2,0,0,1,1,2c-.06,2.29-.1,4.58,0,6.86C132.26,147.06,132,147.5,130.5,147.48Z"></path>
                            <path
                                d="M183.89,219.24c-10.5.06-21,0-31.52,0-3.94,0-3.88,0-4-4,0-1.43.32-1.86,1.81-1.85,11.12.07,22.25,0,33.38.07,1.59,0,2.16-.26,2.15-2.05q-.12-28.11,0-56.2c0-1.67-.37-2.15-2.1-2.14q-35.23.09-70.46,0c-1.67,0-2,.44-2,2,.06,19.48,0,39,0,58.43s0,39.2,0,58.8c0,1.47.4,1.81,1.84,1.81,13.78-.06,27.56,0,41.35,0H184c.82,0,1.7.28,1.69-1.19-.06-8,0-16.08,0-24.11,0-1-.35-1.26-1.28-1.23-1.92.06-3.83,0-5.75,0-4.35,0-4.31,0-4.27-4.32,0-1.13.29-1.51,1.45-1.47,2.72.08,5.45-.08,8.16.06,1.48.07,1.71-.46,1.69-1.78-.06-6.37-.07-12.74,0-19.11C185.76,219.57,185.35,219.23,183.89,219.24Zm-30-49.42c0-2,1.07-3.14,3.06-3.16q5.66-.07,11.31,0c2.06,0,3.06,1.05,3.11,3.09s0,3.83,0,5.74,0,3.59,0,5.38c0,2.21-1.08,3.27-3.32,3.3-3.64,0-7.29,0-10.93,0a2.91,2.91,0,0,1-3.23-3.22Q153.83,175.38,153.88,169.82ZM141,263c0,2.15-1,3.21-3.15,3.24q-5.56,0-11.12,0c-2.09,0-3.17-1.11-3.19-3.22q0-5.57,0-11.12a2.82,2.82,0,0,1,3.08-3.13q5.66-.08,11.31,0c2,0,3,1.09,3.07,3.13,0,1.85,0,3.7,0,5.55S141,261.12,141,263Zm0-81.8a2.75,2.75,0,0,1-2.87,3c-3.89.07-7.79.07-11.68,0a2.78,2.78,0,0,1-2.89-3c0-3.89,0-7.79,0-11.68a2.69,2.69,0,0,1,2.8-2.83q5.92-.09,11.86,0c1.79,0,2.75,1.15,2.79,3s0,3.83,0,5.75S141,179.27,140.94,181.18ZM171.36,263c0,2.13-1.07,3.16-3.2,3.2-1.86,0-3.71,0-5.56,0s-3.59,0-5.38,0c-2.25,0-3.32-1.07-3.34-3.27,0-3.65,0-7.29,0-10.94,0-2.22,1.08-3.27,3.32-3.28q5.48,0,10.93,0c2.15,0,3.2,1,3.23,3.17C171.39,255.61,171.39,259.31,171.36,263Z"></path>
                            <path
                                d="M185.74,43.18c-1-11-4.76-20.9-12.69-28.87C155.78-3,124.45-4.88,105,10.27c-6.17,4.81-11,10.5-13.06,18.33-.94,3.63-2.37,7.13-3.55,10.7a10.7,10.7,0,0,0-.52,2.15,66.31,66.31,0,0,0,.49,19.94q8.25,45.54,46.77,71.29a2.39,2.39,0,0,0,3.09,0A103.65,103.65,0,0,0,170,100.55C179.8,85,185.62,68.18,186.07,49.16,186,47.5,185.93,45.33,185.74,43.18ZM136.69,79.79a34.73,34.73,0,1,1,34.68-34.24A34.74,34.74,0,0,1,136.69,79.79Z"></path>
                            <path
                                d="M35.51,272.29c0,1.55-.43,1.93-1.95,1.93q-15.86-.11-31.7,0c-1.43,0-1.87-.34-1.86-1.83.08-7.73.06-15.45,0-23.18,0-1.15.21-1.62,1.5-1.57,2.84.11,5.69,0,8.53.05.9,0,1.26-.16,1.29-1.19.17-4.59.21-4.59-4.42-4.59-1.8,0-3.59-.08-5.38,0C.28,242,0,241.55,0,240.36q.08-9.83,0-19.65c0-1.12.28-1.51,1.44-1.48,2.78.08,5.56,0,8.34.06,1.25.05,1.54-.4,1.54-1.57,0-4.22.06-4.22-4.18-4.22-1.91,0-3.83-.05-5.74,0-1,0-1.4-.18-1.4-1.3q.06-17.52,0-35c0-.94.24-1.29,1.24-1.29,11,0,22,.05,33,0,1.62,0,1.21,1,1.21,1.84q0,23.64,0,47.28C35.47,240.77,35.45,256.53,35.51,272.29Z"></path>
                            <path
                                d="M135.24,175.4c0,2.95,0,2.95-3,2.95s-2.91,0-2.91-3,0-3,3-3S135.24,172.38,135.24,175.4Z"></path>
                            <path
                                d="M165.66,175.48c0,2.87,0,2.87-2.93,2.87s-3.07,0-3.06-3.11c0-2.87,0-2.87,2.91-2.86C165.66,172.38,165.66,172.38,165.66,175.48Z"></path>
                            <path
                                d="M135.25,257.5c0,3,0,3-3.05,3s-2.91,0-2.92-3.07,0-3,3-3S135.25,254.44,135.25,257.5Z"></path>
                            <path
                                d="M165.67,257.57c0,2.91,0,2.91-4,2.91-2,0-2,0-2-4.15,0-1.89,0-1.92,3.9-1.88C166,254.47,165.63,253.91,165.67,257.57Z"></path>
                            <path d="M165.64,45a28.92,28.92,0,1,1-28.93-28.84A28.94,28.94,0,0,1,165.64,45Z"></path>
                        </svg>
                    </div>

                    <div class="ec_content">
                        <h4>Professional Business Address

                        </h4>
                        <p>Enhance your business's credibility with a prestigious US address
                        </p>
                    </div>
                </div>
                <div class="ec_item">
                    <div class="ec_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 329.22 365.17">
                            <path
                                d="M0,206.43v-147C0,51,3.08,47.9,11.44,47.9q85.08,0,170.18.08c3.32,0,4.08-.8,4-4-.22-11.22-.11-22.44-.08-33.67C185.58,3.6,189.07,0,195.64,0q61.73,0,123.43,0c6.61,0,10.12,3.54,10.13,10.19q0,28.82,0,57.61c0,6.37-3.6,10-10,10-7.48.06-15,.19-22.44-.07-3.11-.11-3.55,1-3.55,3.74q.11,135.6.05,271.2a39.36,39.36,0,0,1-.09,4.48A9,9,0,0,1,285,365.1c-1.23.12-2.49.06-3.74.06H12c-9.1,0-12-2.92-12-12.09ZM275.31,78c-1.37,0-2.74-.12-4.11-.12H214.73c-8,0-11.21-3.22-11.22-11.38a79.35,79.35,0,0,1,.06-8.59c.37-3.33-.76-4.06-4-4.05q-84.7.16-169.42.08c-6,0-6.18.21-6.18,6V353.15c0,5.81.22,6,6.2,6H281.08c6.09,0,6.23-.14,6.23-6.36V83.52c0-5.88,0-5.88-6-5.57ZM266,71.84c17.45,0,34.89,0,52.33,0,3.43,0,5-1.06,5-4.72q-.15-28.21,0-56.44c0-3.6-1.45-4.78-4.93-4.77q-52,.1-103.91,0c-4.29,0-4.93.66-4.93,5q0,27.85,0,55.7c0,4.54.58,5.09,5.25,5.1Zm-248,135h0V60.26c0-1.5.05-3,.06-4.49,0-.69.34-1.75-.72-1.77-3.21-.07-6.6-.88-9.6.38C4.93,55.54,6,58.53,6,60.77Q6,205.3,6,349.81c0,10.37-.63,9.29,10,9.4,2,0,2.09-.75,2.09-2.44Q18,281.8,18,206.83ZM203.51,26.71V13.28c0-7.42,0-7.29-7.32-7.34-3.65,0-4.74,1.58-4.69,5,.12,9.33,0,18.65,0,28,0,9.49,0,9.43,9.47,9,2-.07,2.56-.66,2.53-2.59C203.45,39.14,203.51,32.92,203.51,26.71Z"></path>
                            <path
                                d="M281.35,78l0,268.62a33.13,33.13,0,0,1-.06,3.73,2.93,2.93,0,0,1-5.86,0,33.13,33.13,0,0,1-.06-3.73l0-268.62Z"></path>
                            <path
                                d="M155.81,95.78h95.36c6,0,6.21.2,6.21,6V263.36c0,5.83-.2,6-6.19,6H60.08c-6.08,0-6.21-.14-6.21-6.37V102.18c0-6.32.07-6.4,6.57-6.4Zm-.15,95.78c30.78,0,61.56,0,92.34.07,2.82,0,3.54-.7,3.47-3.49-.21-7.72-.23-15.45,0-23.17.09-2.94-.88-3.41-3.55-3.4-26.79.1-53.58.06-80.37.06-34.77,0-69.53,0-104.3-.07-2.82,0-3.54.7-3.46,3.49.2,7.59.25,15.21,0,22.8-.12,3.25.94,3.79,3.93,3.78C94.36,191.52,125,191.56,155.66,191.56Zm-.46,35.92c30.91,0,61.81,0,92.71.06,2.66,0,3.66-.43,3.57-3.39-.24-7.84-.18-15.7,0-23.55.05-2.41-.58-3.16-3.06-3.11-8.1.16-16.2.06-24.3.06q-80.19,0-160.38-.07c-3,0-4.06.5-3.94,3.77.28,7.47.25,15,0,22.43-.1,3.09.69,3.89,3.83,3.88C94.14,227.43,124.67,227.48,155.2,227.48Zm.52,6c-30.65,0-61.31,0-92-.06-2.9,0-4.12.37-4,3.72.3,7.72.18,15.45.05,23.18,0,2.33.45,3.16,3,3.15q92.9-.1,185.79,0c2.42,0,2.87-.76,2.83-3-.12-7.6-.2-15.21,0-22.8.1-3.27-.61-4.34-4.16-4.32C216.78,233.53,186.25,233.46,155.72,233.46Zm.07-95.77c-30.66,0-61.33.06-92-.1-3.42,0-4.27.95-4,4.14a53.49,53.49,0,0,1,0,9.72c-.31,3.39.78,4.28,4.22,4.28q91.63-.18,183.27-.09a14.59,14.59,0,0,1,1.87,0c1.86.23,2.32-.65,2.27-2.37-.09-4-.21-8,0-12,.18-2.91-.69-3.72-3.66-3.71C217.13,137.73,186.46,137.69,155.79,137.69ZM153,101.77c-10.21,0-20.42,0-30.63,0-2.07,0-2.76.51-2.73,2.67q.18,12.31,0,24.65c0,2.12.58,2.7,2.71,2.7q30.24-.12,60.5,0c2.56,0,2.74-1,2.72-3.06-.09-8-.13-15.94,0-23.9,0-2.45-.64-3.12-3.08-3.09C172.69,101.85,162.86,101.77,153,101.77Zm68.82,0c-9.21,0-18.42.06-27.63,0-2.11,0-2.75.54-2.72,2.69q.18,12.32,0,24.65c0,2.14.61,2.69,2.71,2.69q27.27-.12,54.53,0c2.1,0,2.75-.54,2.71-2.69-.12-8.09-.14-16.18,0-24.27.05-2.47-.67-3.12-3.09-3.08C239.52,101.86,230.68,101.77,221.84,101.77Zm-135,29.93c8.09,0,16.18-.07,24.27.05,2.1,0,2.75-.54,2.72-2.69q-.19-12.32,0-24.64c0-2.14-.6-2.71-2.71-2.7q-24.27.14-48.55,0c-2.1,0-2.75.54-2.71,2.69q.18,12.32,0,24.64c0,2.14.59,2.73,2.71,2.7C70.61,131.63,78.7,131.7,86.79,131.7Z"></path>
                            <path
                                d="M35.91,206.92q0,70.11,0,140.23c0,2.37.79,5.74-2.81,5.85-4,.12-3.14-3.41-3.14-5.89q0-140.6,0-281.2c0-2.38-.79-5.75,2.81-5.86,4-.12,3.13,3.41,3.13,5.89Q35.94,136.43,35.91,206.92Z"></path>
                            <path
                                d="M156,293.32h95.35a23.5,23.5,0,0,1,3.36.08,2.93,2.93,0,0,1-.06,5.82,18.61,18.61,0,0,1-3,.08H59.5a17.52,17.52,0,0,1-3-.09,2.78,2.78,0,0,1-2.57-2.75,2.83,2.83,0,0,1,2.64-3.07,23.5,23.5,0,0,1,3.36-.07Z"></path>
                            <path
                                d="M155.61,311.28h95.72a23.5,23.5,0,0,1,3.36.07,2.93,2.93,0,0,1,0,5.83,21.25,21.25,0,0,1-3,.08H59.55a25.45,25.45,0,0,1-2.62,0c-1.86-.19-3.08-1.2-3-3.13a2.87,2.87,0,0,1,2.95-2.8c1-.07,2,0,3,0Z"></path>
                            <path
                                d="M287.31,32.1c0,7.68,0,15.36,0,23,0,2.25-.11,4.61-3,4.6s-3-2.35-3-4.61q0-16.26,0-32.52c0-2,.05-3.9,2.36-4.49,2.15-.56,3.12,1.11,4.09,2.57,5.6,8.38,11.19,16.78,17.5,25.13V36.89c0-5,0-10,0-14.95,0-2.14.67-3.87,3-3.87s3,1.78,3,3.89q0,16.83,0,33.65c0,1.89-.31,3.57-2.39,4.11s-2.93-.9-3.86-2.29L288,32Z"></path>
                            <path
                                d="M221.47,39.05c0-5.6.05-11.21,0-16.81,0-3,1.21-4.33,4.23-4.3,7.1.07,14.2,0,21.3,0,2.18,0,4.25.33,4.31,2.94S249.33,24,247.11,24c-5.61,0-11.21.11-16.81-.06-2.36-.08-2.89.69-2.9,3-.08,9.07-.16,9.07,9,9.07,3.73,0,7.47,0,11.2,0,2,0,3.57.76,3.64,2.87.07,2.36-1.59,3.13-3.75,3.12-5.85,0-11.7.07-17.55,0-1.91,0-2.52.5-2.59,2.5-.33,9.51-.4,9.51,9,9.51h11.21c2.18,0,3.79.83,3.7,3.17-.09,2.13-1.69,2.83-3.68,2.82q-11.22,0-22.42,0c-2.68,0-3.76-1.42-3.74-4C221.5,50.26,221.47,44.65,221.47,39.05Z"></path>
                            <path
                                d="M263.37,38.53c0-5.48,0-11,0-16.42,0-2.09.51-3.93,2.84-4,2.61-.11,3.18,1.83,3.17,4.07q0,16.79,0,33.57c0,2.08-.48,4-2.83,4-2.6.1-3.19-1.81-3.18-4.06C263.39,50,263.37,44.25,263.37,38.53Z"></path>
                            <path
                                d="M87.17,113.74c3.6,0,7.21,0,10.81,0,2.19,0,3.78.87,3.68,3.19-.09,2.11-1.68,2.82-3.67,2.82q-11.2,0-22.39,0c-2,0-3.59-.7-3.68-2.82-.1-2.33,1.5-3.19,3.68-3.18C79.46,113.75,83.31,113.74,87.17,113.74Z"></path>
                        </svg>
                    </div>

                    <div class="ec_content">
                        <h4>Flawless EIN Setup

                        </h4>
                        <p>Streamline your startup with our quick EIN service, ensuring hassle-free business operations.


                        </p>
                    </div>
                </div>
                <div class="ec_item">
                    <div class="ec_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 661.21 665.5">
                            <path
                                d="M0,330.11Q0,207.53,0,85C.06,41.58,30,7,72.82.68A75.34,75.34,0,0,1,83.76,0Q213.33,0,342.9,0a81.68,81.68,0,0,1,54.89,20.55q40.57,35.12,80.93,70.5c19.91,17.43,30,39.36,29.94,66q-.11,120.08,0,240.16a6.82,6.82,0,0,0,0,1.5c.37,1.61-.95,4.66,1.27,4.57,3.36-.14,1-3.07,1-4.67-.13-4.95,1.75-8.8,5.81-11.45,13.24-8.63,26.46-17.3,39.85-25.69,9-5.64,19.76-3.27,26.44,5.82,18.53,25.2,36.89,50.52,55.33,75.79,6,8.2,12,16.36,17.95,24.59,8.16,11.31,6.13,22.65-5.48,30.46s-23.49,15.76-35.28,23.57c-7.73,5.13-13,4.61-19.29-2.3-2-2.2-3.2-1.35-5-.16-7.32,4.91-14.71,9.72-22,14.68-4.62,3.14-9.44,5.69-15.17,5.71-2.47,0-3,1.1-3,3.36-.07,13.61-6.55,22.67-19.62,26.74-2.35.73-2.81,1.7-1.91,3.88,6.87,16.68-6.18,37.7-28,35.58-3.09-.3-3.55.93-3.87,3.5-2.05,16-12.78,25.08-29,24.48-2.87-.11-3.57.59-3.89,3.38-2.4,21.13-21.44,31.07-40.29,21-2.57-1.37-5.11-1.22-7.74-1.22q-166,0-332,0c-36.3,0-66.9-21.31-79.66-55.2C1.36,595.19,0,584.85,0,574.27Q.06,452.19,0,330.11ZM375,650c-7.78-5.17-12.82-11.54-14-20.64-.33-2.5-2-2-3.71-2-14.41.36-23-6.14-26.13-20-.6-2.69-1.5-3.31-4.24-3.16-15.41.84-26.29-9.4-26.2-24.7,0-3-.73-3.79-3.73-4.14-19-2.2-28.07-22.53-17.09-38.19,1.9-2.72,4.11-5.24,6.08-7.91,2.94-4-1.18-17.11-5.83-18.78-1.1-.4-1.91.22-2.78.65-4.72,2.31-9,1.27-13.18-1.49-12.46-8.31-25-16.53-37.33-25-10-6.86-12.21-18.61-5.13-28.37q37.07-51.12,74.4-102c6.49-8.85,17.38-11,26.6-5.17q19.43,12.24,38.56,24.94c7.17,4.74,8.64,11,4.3,18.49-1.54,2.66-.77,3.36,1.64,4.08,5.73,1.74,11.47,3.47,17.11,5.45a6.74,6.74,0,0,0,6.52-.89q10.88-7.08,21.93-13.88c13.55-8.36,27.75-9.5,42.54-3.65l37.13,14.65c5.91,2.34,5.91,2.34,5.91-3.8q0-119.34,0-238.68c0-2.66-.35-5.31-.37-8,0-4.92-2-6.63-7.25-6.59-36.62.26-73.24.14-109.85.13-21.11,0-33.24-12-33.26-33.06q0-45.45,0-90.88c0-7.24,0-7.28-7.32-7.28q-127.57,0-255.16,0c-42.6,0-74.8,32.52-74.8,75.13q0,244.18,0,488.35a86.43,86.43,0,0,0,1.08,14.91C17.89,624.9,47.94,650,84.93,650q137.07.08,274.14,0Zm1.22-239.69c-5.76-1.85-10.24-3-14.5-4.73-3.44-1.4-5.26-.45-7.35,2.46q-31.08,43.13-62.43,86.06c-5.05,6.95-5.05,6.93-.37,13.85a20.45,20.45,0,0,1,2.46,4.33c1.23,3.39,2.4,3.2,5,.91,12.54-11,30.5-7.47,37.75,7.43,1.55,3.18,2.61,3.09,5.44,1.72,17.57-8.46,36,4,34.79,23.46-.16,2.66.41,3.34,3,3.64,14.17,1.61,22.57,11.36,22.09,25.79-.1,2.88.91,3.2,3.26,3.45,10,1,17,6.3,20.54,15.78a10.12,10.12,0,0,0,3.56,4.62c10.47,8,20.87,16,31.32,24,7.66,5.86,18,4.67,23.56-2.65,5.45-7.14,3.86-16.94-3.82-22.91-5.12-4-10.33-7.85-15.51-11.77q-14.12-10.71-28.25-21.4c-2.49-1.89-4-4.15-2.36-7.28a4.62,4.62,0,0,1,5.9-2.44,13.1,13.1,0,0,1,3.8,2.3q17.92,13.55,35.79,27.15c4.77,3.63,9.47,7.33,14.23,11,7.4,5.67,17.44,5,22.93-1.59,6.07-7.23,5.25-17.26-2.56-23.45-13.29-10.55-26.9-20.7-40.37-31-4.23-3.23-8.55-6.36-12.69-9.71-2.36-1.9-2.95-4.49-1.1-7.08s4.41-2.7,7-1.15a29.5,29.5,0,0,1,2.84,2c15,11.34,29.91,22.79,45,34A16.25,16.25,0,0,0,537.61,554c5.31-6.9,4.14-16.49-2.89-22.28Q484.06,490,433.42,448.21c-2.55-2.11-4.32-2-7-.35q-14.83,9.22-29.91,18.05c-17.48,10.27-38.16,7.52-52.18-6.81-10.36-10.59-8.89-23,3.66-30.92Zm61.24-19.89a33.12,33.12,0,0,0-18.07,4.92q-33.42,21-66.7,42.1c-5.86,3.72-6.29,8.52-1.56,13.72,10.41,11.42,26.28,13.87,40,5.88,11.37-6.61,22.65-13.36,33.76-20.4,4.55-2.88,7.84-2.5,12,.94q53.22,44.14,106.71,88c5.59,4.6,11.35,5.15,17.49,1.22,8-5.12,15.76-10.57,23.77-15.64,2.91-1.84,2.76-3.24.88-5.82q-32.82-45-65.41-90.09c-1.77-2.45-3.46-3.23-6.23-1.85-4.15,2.06-8.13,1.53-12.44-.24-16.62-6.83-33.39-13.29-50.09-19.93A37.77,37.77,0,0,0,437.43,390.46ZM432.9,131.08h55.4c6,0,6,0,3.47-5.67A72.07,72.07,0,0,0,473,99.88q-41.34-36.09-82.74-72.13c-8-7-17.42-11.5-27.58-14.56-3.67-1.11-4.9-.47-4.88,3.69.15,30.94,0,61.88.1,92.82,0,13.46,8.16,21.34,21.58,21.37C397.3,131.11,415.1,131.08,432.9,131.08ZM228,468.76c.21,3.22,2.07,5.77,5,7.74,11.92,7.92,23.85,15.82,35.66,23.89,3.08,2.11,4.87,1.51,6.94-1.36Q315.74,443.64,356,388.37c1.87-2.57,1.94-4.23-.91-6.05-12.48-8-24.83-16.13-37.34-24.06-5.48-3.47-9.86-2.44-13.83,2.86-3.4,4.53-6.68,9.13-10,13.7q-31.34,42.94-62.67,85.89C229.57,463,228,465.34,228,468.76Zm422.83,12.1a13.15,13.15,0,0,0-2.74-6.9c-5.74-7.75-11.38-15.58-17.07-23.38q-27.79-38.11-55.62-76.21c-4.6-6.28-8.83-7.2-14.9-3.3-12.19,7.82-24.26,15.8-36.48,23.57-3,1.91-3.24,3.63-1.14,6.4,4.81,6.37,9.41,12.91,14.1,19.37q32.85,45.24,65.7,90.49c1.83,2.52,3.26,4.92,7.08,2.28,12-8.32,24.29-16.37,36.47-24.5A10,10,0,0,0,650.83,480.86Zm-284,62.85a13.77,13.77,0,0,0-8.61-12.83A13.32,13.32,0,0,0,342.48,535q-14.39,18.16-28.42,36.61c-5.09,6.72-4.07,14.75,2,19.52,6.31,4.94,14.52,3.87,19.82-2.86,9.26-11.74,18.35-23.61,27.53-35.42A14.3,14.3,0,0,0,366.83,543.71Zm25.07,29.5a13.47,13.47,0,0,0-8.78-12.71c-5.55-2.13-11.46-.9-15.34,3.93-8.12,10.09-16.12,20.3-23.85,30.69-4.93,6.6-3.58,14.93,2.58,19.47s14.25,3.43,19.43-3.11c7.75-9.75,15.31-19.66,23-29.49A13.85,13.85,0,0,0,391.9,573.21ZM385,640.43c3.67-.28,7.21-1.39,9.62-4.39,6.88-8.54,13.81-17.06,20.24-25.93,4.24-5.87,2.54-14-3-18.32s-13.74-4-18.46,1.59c-7,8.39-13.71,17.12-20.17,26-3.2,4.38-2.92,9.49-.28,14.18S379.74,640.17,385,640.43Zm-56.1-109.6a13.72,13.72,0,0,0-24.5-8.4q-8.15,10.05-15.87,20.46c-4.87,6.56-3.83,15,2.17,19.55,6.18,4.72,14.06,3.69,19.41-2.86s10.64-13.59,15.92-20.42A13.77,13.77,0,0,0,328.93,530.83ZM454.62,639.12a14.42,14.42,0,0,0-5.33-11.88c-6.69-5.43-13.68-10.49-20.54-15.73-1.17-.89-2.18-1.56-3.11.32-3.71,7.52-9.6,13.48-14.56,20.1-1.42,1.9-1.86,3.22.24,5,6,5,11.69,10.32,17.82,15.13,5.18,4.06,11.12,4.05,16.91,1.19S454.37,645.4,454.62,639.12ZM410,649.91c-7.09-7.94-7.29-7.93-16.83,0Z"></path>
                            <path
                                d="M176.31,161.18H67c-15,0-22-7-22-21.93q0-27.21,0-54.43c0-12.89,7.54-20.49,20.49-20.5q111.1,0,222.21,0c12.37,0,20,7.66,20,20q.08,28.47,0,56.93c0,12.28-7.65,19.93-20,20Q232,161.24,176.31,161.18Zm0-86.44q-54.9,0-109.79,0c-8.6,0-11.31,2.74-11.32,11.34q0,26.7,0,53.4c0,8.56,2.79,11.4,11.34,11.4q109.79,0,219.58,0c8.56,0,11.24-2.72,11.26-11.41q0-26.44,0-52.9c0-9.44-2.39-11.84-11.78-11.84Z"></path>
                            <path
                                d="M202.13,541.33a79.73,79.73,0,1,1-159.45-.14c0-43.63,35.79-79.4,79.52-79.44A79.86,79.86,0,0,1,202.13,541.33Zm-79.34-69.21c-36.89-.77-68.88,30-69.84,67.23a69.48,69.48,0,0,0,68,71.51c38.05.88,70.08-29.72,70.84-67.69C192.6,504.28,162.16,473,122.79,472.12Z"></path>
                            <path
                                d="M243.21,321.23H51.46a27.81,27.81,0,0,1-4.48-.15,4.58,4.58,0,0,1-4.19-4.8,4.64,4.64,0,0,1,4-5,25.69,25.69,0,0,1,5-.28q191.49,0,383,0c4,0,8.51-.69,9.18,5,.44,3.74-2.38,5.19-9.43,5.19H243.21Z"></path>
                            <path
                                d="M243.22,268.8q-95.62,0-191.24,0c-3.88,0-8.57,1-9.14-5-.37-3.9,2.27-5.29,9.33-5.29q191.23,0,382.47,0c3.9,0,8.57-.93,9.18,4.95.39,3.81-2.42,5.29-9.37,5.29Z"></path>
                            <path
                                d="M242.69,216.28H53c-1.83,0-3.67,0-5.49-.13a4.64,4.64,0,0,1-4.69-4.85c-.1-2.92,1.67-4.64,4.46-5.14a26.7,26.7,0,0,1,4.48-.17q191.72,0,383.43,0a23,23,0,0,1,4.48.19,5,5,0,0,1-.25,9.95,43.67,43.67,0,0,1-5.49.14Z"></path>
                            <path
                                d="M128.33,426.24q-38.43,0-76.88,0a23.29,23.29,0,0,1-5-.3,5,5,0,0,1-.35-9.58,17.21,17.21,0,0,1,4.93-.46q77.88,0,155.76,0a21.49,21.49,0,0,1,4.47.27,4.76,4.76,0,0,1,4,5,4.64,4.64,0,0,1-4.14,4.87,28.43,28.43,0,0,1-5,.21Z"></path>
                            <path
                                d="M135.86,363.54H218.7a33,33,0,0,1,5,.16,4.51,4.51,0,0,1,4.1,4.83,4.7,4.7,0,0,1-4,5,18.73,18.73,0,0,1-4,.16l-168.17,0a27.82,27.82,0,0,1-4.48-.13c-2.84-.47-4.45-2.26-4.35-5.18s1.77-4.57,4.71-4.77c1.66-.11,3.32-.09,5-.09Z"></path>
                            <path
                                d="M412.51,363.54c8.31,0,16.63,0,24.95,0,3.67,0,6.51,1.22,6.41,5.2s-3,5-6.65,5q-24.95-.11-49.9,0c-3.56,0-6.57-1-6.64-5-.08-4.42,3.14-5.25,6.88-5.21C395.87,363.59,404.19,363.54,412.51,363.54Z"></path>
                            <path
                                d="M91.94,572.51c.78-4.53,1.63-10,2.68-15.34.5-2.52.09-4.4-2-6.16-3.16-2.68-6-5.75-9.08-8.55-3.44-3.12-5.59-6.68-4-11.46s5.34-6.46,10-7c2.81-.32,5.6-1.19,8.39-1.16,5.93.06,9.57-2.44,11.36-8.16.93-3,2.66-5.73,4-8.58a10.15,10.15,0,0,1,18.29-.12c1,1.93,2.3,3.78,2.82,5.82,2.24,8.89,8.36,11.63,16.84,11.83,5.58.14,11.72.45,14,7.21s-2.28,11-6.77,14.2c-7.88,5.65-9.87,12.3-6.8,21.38,1.75,5.15,2.79,10.94-2.85,15-5.42,3.89-10.44,1.28-14.73-1.84-8.14-5.93-15.78-6.37-23.69.18a18.49,18.49,0,0,1-5.3,2.73C98.48,585,92,580.44,91.94,572.51Zm-2.83-37.93c3.88,3.46,6.76,6.41,10,8.84,5.64,4.21,7.3,9.41,5.59,16.2-1,4.07-2.12,8.27-1.71,13.27,4-2.31,7.74-4.13,11.09-6.47,5.43-3.78,10.6-3.95,16.22-.42,3.81,2.4,8,4.23,13,6.84C142,567,141.16,562.46,140,558c-1.34-5.19-.25-9.4,3.84-13,3.76-3.35,7.22-7,11.61-11.32-6-.59-10.66-1.18-15.29-1.46-5.36-.33-9-2.73-11.13-7.74-1.88-4.37-4.23-8.53-6.81-13.65-2.4,5-4.6,9.07-6.33,13.33-2.13,5.24-5.92,7.68-11.4,8.25C99.75,532.86,95,533.71,89.11,534.58Z"></path>
                        </svg>

                    </div>

                    <div class="ec_content">
                        <h4>Filing Operating Agreements

                        </h4>
                        <p>Outline your company’s financial and functional decisions with the operating agreement.


                        </p>
                    </div>
                </div>
                <div class="ec_item">
                    <div class="ec_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 497.84 336.88">
                            <path
                                d="M277.53,50.59c16.92,0,33.84-.15,50.75.1,4.46.07,5.73-1.2,5.66-5.65-.19-11.1,0-11.11,11.24-11.1,7.83,0,15.66.13,23.48,0,3.28-.08,5,.41,4.91,4.37-.1,4.36-2.09,9.92.89,12.82,2.53,2.48,7.87,2.07,12,3a128.73,128.73,0,0,1,39.87,15.78c3.91,2.39,5.58,1.54,8-1.84,6.5-9.15,6.66-9,15.51-2.51,6.69,4.93,7.06,5.25,1.66,11.56-4.42,5.16-3.58,8,1.25,12.58,71.29,68.21,56.07,183.27-31,229.82-44.45,23.76-90.06,22.85-134.9-.35-5.8-3-11.34-4.86-17.95-4.61-11.41.42-22.84.16-34.26.12-9,0-14.53-4.89-14.37-12.41.15-7.17,5.59-11.66,14.36-11.68,14.59-.05,29.19.06,43.78-.07a15.31,15.31,0,0,1,8.79,2.78c41.47,26.31,84.64,28.86,127.16,4.55,42.76-24.44,63.48-63,60.41-112.43C470.31,114.62,407.76,64.62,337.08,74a52.13,52.13,0,0,1-6.93.6q-51.07.08-102.15,0c-11.28,0-17.59-8-13.55-17,2.37-5.28,6.74-7.09,12.32-7.06C243.69,50.65,260.61,50.6,277.53,50.59Z"></path>
                            <path
                                d="M354.37,130.49c0-13.72.26-27.46-.12-41.18-.16-5.66,1.9-6.78,7-6.19,35.25,4.06,62.1,22.54,84.28,48.95,7.07,8.43,6.89,8.66-3.56,12.92q-39.84,16.27-79.74,32.45c-6.59,2.68-7.87,1.85-7.89-5.13C354.35,158.37,354.37,144.43,354.37,130.49Z"
                                style="fill:#fc6062"></path>
                            <path
                                d="M278.59,99.75a128.87,128.87,0,0,0-20.87,21.59c-1.43,1.83-3.46,1.29-5.29,1.3q-69.78,0-139.55,0c-10.19,0-15.33-4.14-15.52-11.8a11.37,11.37,0,0,1,10.46-12.09,38.68,38.68,0,0,1,4.44-.17q81.18,0,162.37,0C275.8,98.6,277.19,97.94,278.59,99.75Z"></path>
                            <path
                                d="M138.73,290.5q26.29,0,52.59,0c9.43,0,14.59,4.21,14.69,11.86s-5.18,12.2-14.44,12.21q-53.22,0-106.45,0c-8.57,0-14-4.7-14.11-12s5.27-12.09,13.86-12.1Q111.79,290.45,138.73,290.5Z"></path>
                            <path
                                d="M98.82,218.46c-15.84,0-31.67,0-47.51,0-8.46,0-13.48-4.42-13.63-11.61-.15-7.39,5.18-12.44,13.6-12.45q47.19-.1,94.39,0c8.46,0,14.12,5,14.13,12.12s-5.47,11.93-14.1,12c-15.63.08-31.25,0-46.88,0Z"></path>
                            <path
                                d="M196.72,146.37c13.74,0,27.48.18,41.21-.11,4.88-.11,5.21,1.15,3.53,5.3a81.8,81.8,0,0,0-4.24,14.53c-.75,3.69-2.47,4.49-6,4.46-25.36-.17-50.72-.07-76.08-.12-8.25,0-13.73-4.61-14-11.48-.23-7.18,5.3-12.44,13.72-12.53C168.83,146.26,182.78,146.38,196.72,146.37Z"></path>
                            <path
                                d="M258.53,266.47c-29,0-56.55.13-84.13-.09-6.66-.06-11-5.58-10.85-12.29s4.88-11.52,12.29-11.63c11.81-.18,23.62-.05,35.44-.05,9.7,0,19.4,0,29.11,0,2.15,0,4-.06,5.09,2.48A118.07,118.07,0,0,0,258.53,266.47Z"></path>
                            <path
                                d="M353.9,0c8.45,0,16.91,0,25.36,0,5.57,0,8.12,2.69,8.06,8.16-.05,4.22,0,8.45,0,12.67,0,5.52-2.86,8.11-8.25,8.12-16.9,0-33.81.1-50.71,0-5.57,0-8.62-2.83-8.48-8.67.09-4,.05-8,0-12,0-5.82,2.88-8.38,8.64-8.3C337,.13,345.45,0,353.9,0Z"></path>
                            <path
                                d="M169.34,50.59c6.53,0,13.08-.15,19.61,0,7.3.21,12.34,5,12.54,11.57.2,6.7-5.06,12.26-12.45,12.39q-19.93.33-39.87,0c-7.68-.14-12.48-5.24-12.42-12.32.06-6.88,5.1-11.5,13-11.65C156.26,50.5,162.8,50.6,169.34,50.59Z"></path>
                            <path
                                d="M209.87,218.47c-7,0-13.92.13-20.87,0-7.21-.17-12.24-5.07-12.37-11.71a11.93,11.93,0,0,1,11.9-12.22c13.91-.26,27.82-.06,41.74-.17,2.71,0,3.55,1,3.74,3.66.39,5.66,1.09,11.31,1.91,16.93.42,2.85-.51,3.66-3.28,3.61C225.05,218.38,217.46,218.48,209.87,218.47Z"></path>
                            <path
                                d="M115.35,242.44c5.69,0,11.38-.16,17.06,0,7.15.23,12.09,5.16,12.21,11.85a11.72,11.72,0,0,1-11.9,12.13q-18.31.33-36.65,0c-6.77-.13-11.41-5.21-11.53-11.78s4.83-11.92,11.86-12.17C102.71,242.27,109,242.44,115.35,242.44Z"></path>
                            <path
                                d="M98,170.49c-5.06,0-10.13.15-15.18,0-6.67-.25-11.27-4.66-11.74-10.92-.5-6.54,3.58-12.33,10.41-12.74a286.8,286.8,0,0,1,31.58-.11c6.68.34,10.94,6.28,10.46,12.75s-4.92,10.71-11.62,10.95c-4.63.17-9.28,0-13.91,0Z"></path>
                            <path
                                d="M55.58,122.53a99.15,99.15,0,0,1-10.77-.07,11.76,11.76,0,0,1-10.75-12.61c.27-6.25,4.86-10.93,11.47-11.17s13.54-.3,20.29,0,11.28,4.67,11.66,11C77.9,116.39,74,121.35,67,122.3c-3.73.51-7.58.09-11.38.09Z"></path>
                            <path
                                d="M416.2,163.27l-17.06,11.17c-9.36,6.11-18.7,12.26-28.1,18.3-3,1.95-5.64,4-7.43,7.4-2.85,5.43-8.68,7-14.09,4.66a10.86,10.86,0,0,1-6.33-13c1.6-5.73,6.31-9.08,12.45-8.13a14,14,0,0,0,7.89-1.28c14.8-6.1,29.61-12.19,44.47-18.16C410.05,163.44,412,161.75,416.2,163.27Z"></path>
                            <path
                                d="M438.89,48.87a9.39,9.39,0,0,1,4.8-8.49c2.59-1.6,5.24-1.13,7.7.68,6.3,4.63,12.7,9.12,18.91,13.87,3.8,2.9,4.3,6.57,1.47,10.54S465.3,70.91,461,67.8c-6.53-4.66-13-9.47-19.41-14.25A5.73,5.73,0,0,1,438.89,48.87Z"></path>
                            <path
                                d="M43.75,290.51c8.6,0,14.17,4.47,14.36,11.54.19,7.58-5.42,12.59-14.09,12.55s-13.85-4.55-13.92-12S35.27,290.52,43.75,290.51Z"></path>
                            <path
                                d="M24.14,206.65A11.74,11.74,0,0,1,12,218.44,11.92,11.92,0,0,1,0,206.38a12.34,12.34,0,0,1,12.22-12A12.29,12.29,0,0,1,24.14,206.65Z"></path>
                        </svg>
                    </div>

                    <div class="ec_content">
                        <h4>Get Seamless Expedited Filing

                        </h4>
                        <p>Accelerate your business setup with our Expedited Filing service for faster official
                            recognition


                        </p>
                    </div>
                </div>


            </div>

            <div class="text-center mt-4">
                <a href="#step1" style="padding: 10px 12px;" class="btn btn-next">Register Your Company</a>
            </div>
        </div>
    </div>
    <div class="article_f wantHide">
        <div class="container">
            <div class="fc_head" style="text-align: center; padding-bottom: 10px;">
                <h4>Choose Your

                </h4>
                <h2 style="color: #ff5700">Company Structure Wisely

                </h2>
                <p>
                    Decide which company structure is perfect for your business. Different entities are best for
                    different business goals.

                </p>
            </div>
            <div class="fc_items">
                <div class="fc_item">
                    <h3>LLC</h3>
                    <p>
                        Choose an LLC for the ultimate flexibility and protection of your personal assets—streamline
                        your business structure effortlessly.
                    </p>

                    <ul>
                        <li>Unlimited membership opportunities
                        </li>
                        <li>Board of Directors not required
                        </li>
                        <li>Personal asset protection from business liabilities
                        </li>
                        <li>Pass-through taxation; profits taxed once at the owner level
                        </li>
                        <li>Can elect (S Corp, Partnership, Disregarded entity, C Corp, etc.) how it wants to be taxed
                        </li>
                        <li>Perpetual Existence
                        </li>
                        <li>Can’t go Public
                        </li>
                    </ul>
                </div>
                <div class="fc_item">
                    <h3>S Corp
                    </h3>
                    <p>
                        Well known for tax benefits and operational flexibility, maintaining your business’s growth
                        momentum while enjoying certain corporate structures without double taxation.

                    </p>

                    <ul>
                        <li>Limited to 100 Shareholders
                        </li>
                        <li>Functions with LLC flexibility while offering corporate tax benefits.
                        </li>
                        <li>Like LLCs, profits and losses pass directly to the owner’s personal taxes.
                        </li>
                        <li>Profits are taxed only at the shareholder level, not at the corporate level.
                        </li>
                        <li>personal tax reductions under S-corp filing status.
                        </li>
                        <li>Capable of attracting investors through the issuance of stock.
                        </li>
                        <li>Only for SSN holders
                        </li>
                    </ul>
                </div>
                <div class="fc_item">
                    <h3>C Corp
                    </h3>
                    <p>
                        Offers advanced business growth and funding opportunities, ensures strong legal separation
                        between company and personal assets, and simplifies access to investment capital.

                    </p>

                    <ul>
                        <li>Unlimited Ownership
                        </li>
                        <li>Ability to Issue Shares
                        </li>
                        <li>Access to Preferred Stock
                        </li>
                        <li>Ideal for Equity Financing
                        </li>
                        <li>Limited Personal Liability
                        </li>
                        <li>Double Taxation; Corporate and Shareholder Levels
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="article_g wantHide">
        <div class="container">
            <div class="gc_head" style="text-align: center; padding-bottom: 10px;">
                <h4>What Entrepreneurs

                </h4>
                <h2 style="color: #ff5700">Get from Steady Formation?


                </h2>
            </div>
            <div class="gc_items">
                <div class="gc_item">
                    <div class="gc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.12 367.92">
                            <path
                                d="M374.17,161.9c-5-5.94-11.15-10.7-17.31-15.38-1.59-1.2-3.29-2.29-4.76-3.62-10.59-9.51-9.82-6.55-6.64-20.87,2-8.85,5.42-17.35,6.37-26.47C354,75,343.25,61.07,322.81,58a142.44,142.44,0,0,0-21.24-1.47c-3,0-6-.41-8.94-.51-5.74-.19-8.86-3-11-8.16-3.29-8.07-5.5-16.54-9.29-24.41a63.09,63.09,0,0,0-5.76-10C257.58,1.05,244.31-3,230,2.24c-8.28,3-15.32,8.18-22.57,13-16.53,11-15,11-31.64,0-7.26-4.83-14.3-10-22.59-13C138.76-3,125.51,1.07,116.51,13.42,110.93,21.09,108,30,104.82,38.76a59,59,0,0,0-2.09,6c-2.1,8.64-7.84,11.86-16.32,11.74A157.33,157.33,0,0,0,60.3,58C45.09,60.31,34.57,69.09,31.68,82.14c-1.83,8.28-.28,16.37,1.6,24.44,1.79,7.63,4.81,14.92,6,22.74.54,3.55.2,6.29-2.69,8.61-2.33,1.87-4.34,4.15-6.74,5.92C17.4,153,5.05,162.28,0,178v12c2.06,3.89,3.17,8.22,5.75,11.9,4.58,6.54,10.5,11.65,16.66,16.55,5,4,10.25,7.51,14.76,12.07a7.56,7.56,0,0,1,2.27,7c-1,8.23-4.25,15.88-6.15,23.87s-3.43,16.15-1.61,24.43c2.88,13,13.4,21.86,28.62,24.14a143.8,143.8,0,0,0,21.24,1.49c3,0,6,.39,8.94.5,5.73.2,8.86,3,11,8.16,3.29,8.07,5.52,16.53,9.29,24.41a53,53,0,0,0,8.6,13.5c9.32,10.08,22.28,12.64,35.58,7.07,7.75-3.24,14.59-8,21.42-12.81.71-.5,1.36-1.11,2.11-1.55,14.24-8.41,12.18-8.64,26.48.29,6.11,3.82,11.83,8.28,18.23,11.68,9.76,5.17,19.82,7.38,30.44,2.75,7.67-3.35,12.7-9.43,16.59-16.61,3.75-6.93,6-14.45,8.86-21.76,6.12-15.73,4.23-14.65,21.42-15.56,9.71-.51,19.47-.3,28.89-3.09,15.9-4.7,24.49-18,22.69-34.55a123.52,123.52,0,0,0-5.32-23.28c-1.11-3.57-1.8-7.25-2.73-10.86-1.18-4.6.16-7.73,3.58-10.8,6.95-6.27,15-11.22,21.71-17.74,5.92-5.73,11-12,12.95-20.16C384.9,179.85,381.33,170.33,374.17,161.9Zm-112.11-6q-19.92,20-39.91,40-18.92,18.94-37.82,37.88c-8.32,8.32-17.16,8.32-25.46,0-12.79-12.79-25.64-25.53-38.31-38.45-8.68-8.86-5.45-22.89,6-26.67a27,27,0,0,1,4.12-.84,17.14,17.14,0,0,1,12.93,5.37c8.52,8.6,17.15,17.08,25.59,25.76,1.87,1.92,2.78,2.11,4.8.07q32.79-33.12,65.8-66c8.4-8.38,21.4-6.29,26.22,4.07C269,143.43,267.56,150.37,262.06,155.9Z"></path>
                        </svg>

                    </div>

                    <div class="gc_content">
                        <h4>Free Company Name Verification

                        </h4>
                        <p>Get your free company name verification with our team.

                        </p>
                    </div>
                </div>
                <div class="gc_item">
                    <div class="gc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.32 383.06">
                            <path
                                d="M383.32,383c-10.23,0-20.45-.08-30.68.07-2.43,0-3.08-.61-3.06-3.06.07-8.23,0-8.23,8.3-8.23h13.19c-2.93-4.81-5.55-9.12-8.18-13.42-3.39-5.51-6.69-11.07-10.23-16.49a4.14,4.14,0,0,1-.05-5.26c5.54-8.71,10.9-17.54,16.26-26.36.62-1,1.62-1.88,1.65-3.57-12.25,0-24.41.05-36.58,0-2.31,0-1.86,1.41-1.86,2.7,0,11.22-.09,22.44.06,33.66a6.3,6.3,0,0,1-3,5.82c-10,7.33-19.93,14.87-30.71,23h10.73c8.85,0,17.71.05,26.56,0,2,0,2.74.38,2.76,2.6.09,8.68.19,8.68-8.6,8.68-16.83,0-33.67-.07-50.5.06-2.73,0-3.6-.54-3.54-3.43.21-9.22,0-18.45.13-27.67,0-2.15-.6-2.67-2.69-2.67q-81.56.09-163.11,0c-2.18,0-2.65.67-2.63,2.73.11,9.22,0,18.45.1,27.67,0,2.49-.44,3.38-3.19,3.37q-50.7-.15-101.38,0c-2.19,0-2.8-.41-3-2.78A26.39,26.39,0,0,1,5,362.12c4.66-6.58,8.49-13.75,12.83-20.57a3.73,3.73,0,0,0,0-4.67c-5.44-8.63-10.65-17.4-16.1-26-3-4.67-1.15-9.7-1.46-14.55-.11-1.65,1.8-.85,2.73-.86,14.84-.06,29.68-.13,44.51,0,3,0,4-.56,4-3.8-.21-12.58,0-25.18-.16-37.76,0-2.87.77-3.48,3.52-3.46,15.71.14,31.42.07,47.31.07,0-1.55-1.34-2-2.14-2.82C69.18,217.58,55.25,180.91,58.79,138c2.35-28.34,13.42-53.33,32-75,1.66-1.93,2.8-2.88,4.74-.4,1.59,2,5.12,3.21,5.17,5.49,0,1.89-2.76,3.84-4.31,5.77a122.34,122.34,0,0,0,22.3,174.78,8.23,8.23,0,0,0,5.42,1.86c5.82-.13,11.65,0,18.72,0-26.36-13.93-44.83-33.71-55-60.63S78,136,88.58,109.33c16.67-42,59.39-72.71,110.92-69.7,45.48,2.66,86.57,36,99.29,80.73,13.7,48.21-7.1,104.49-57.73,130.16,7.32,0,13.83,0,20.35,0a4.27,4.27,0,0,0,2.59-1.28c27.66-20.74,44.52-48.16,48.9-82.43,8.23-64.25-32.1-121.91-95.43-135.71-39.14-8.53-74.56,1-105.37,26.73-2.4,2-3.45,2-5.47-.33-5.09-5.84-5.22-5.73,1-10.67,69.8-55.49,170.81-30.68,206.82,50.79,22.2,50.21,9.86,111.31-30.14,149.23-1.06,1-2.17,2-4,3.66h6.4c13.71,0,27.43.16,41.14-.11,3.78-.07,4.42,1.09,4.36,4.55-.22,12.34,0,24.68-.15,37,0,2.71.53,3.56,3.43,3.53,16-.15,31.92-.06,47.88,0v13.47c-6.76,9.35-12.17,19.56-18.43,29.23a1.77,1.77,0,0,0,0,2.08c6.25,9.69,11.72,19.87,18.41,29.28ZM291.73,150.47A100,100,0,0,0,191.46,50.74c-55.13.23-99.85,45.08-99.68,99.95.18,55.19,45.16,100,100.27,99.84C247,250.38,291.89,205.31,291.73,150.47Zm-100,111.29q-62.65,0-125.31-.08c-3.15,0-3.85.78-3.83,3.86q.23,34.59,0,69.18c0,2.8.66,3.46,3.45,3.45q125.68-.12,251.37,0c2.82,0,3.46-.68,3.45-3.47q-.19-34.59,0-69.18c0-3.09-.71-3.86-3.84-3.85Q254.42,261.86,191.76,261.76ZM85,371.65c-10.56-7.92-20.36-15.38-30.3-22.65a6.91,6.91,0,0,1-3.31-6.4c.2-11,0-21.92.13-32.88,0-2.34-.45-3.18-3-3.15-11.21.16-22.42.06-33.64.09-.65,0-1.53-.41-1.94.76,5.87,9.55,11.72,19.21,17.75,28.77,1.35,2.13,1.49,3.71.09,5.91-5.67,8.91-11.14,17.95-16.64,27-.47.77-1.51,1.43-1,2.58Zm11.4-5.48c0-5.53,0-10.23,0-14.92,0-1.08,0-1.95-1.53-1.94-6.65,0-13.3,0-20.92,0ZM309.7,349.32c-7.63,0-14.19,0-20.75,0-1.21,0-1.83.32-1.82,1.67,0,4.81,0,9.63,0,15.2Z"></path>
                            <path
                                d="M56.33,0c.6,18.23,13.16,31.78,31.21,33.53,1.81.17,2.66.44,2.51,2.5-.2,2.72.84,6-.34,8.07s-4.73,1-7.2,1.61a33.72,33.72,0,0,0-26,30.08c-.2,2.28-.72,3-3,2.8-2.6-.22-5.73.78-7.7-.36s-1-4.51-1.47-6.88A33.75,33.75,0,0,0,14.12,45.06c-2.41-.2-2.89-.93-2.73-3.06.2-2.6-.78-5.81.43-7.63.95-1.41,4.5-1,6.87-1.51C33.78,29.78,44.56,16.36,45.1,0ZM50.69,21.73A48,48,0,0,1,33.31,39.31a48.42,48.42,0,0,1,17.42,17.4,48.16,48.16,0,0,1,17.5-17.45A47.58,47.58,0,0,1,50.69,21.73Z"></path>
                            <path
                                d="M338.42,0c.59,18.23,13.17,31.8,31.22,33.53,1.8.17,2.66.44,2.51,2.49-.21,2.73.83,6-.34,8.08s-4.73,1-7.2,1.61a33.73,33.73,0,0,0-26,30.08c-.19,2.27-.71,3-3,2.8-2.59-.22-5.72.78-7.69-.36s-1-4.51-1.48-6.88a33.74,33.74,0,0,0-30.23-26.29c-2.4-.2-2.88-.92-2.72-3.06.19-2.6-.79-5.81.43-7.63.94-1.41,4.49-1,6.87-1.51C315.86,29.79,326.64,16.37,327.2,0ZM332.8,21.78a48,48,0,0,1-17.43,17.49,48.16,48.16,0,0,1,17.45,17.5,48,48,0,0,1,17.5-17.53A47.27,47.27,0,0,1,332.8,21.78Z"></path>
                            <path
                                d="M187.17,187.5l-6.9,8.27c-2.23-1.57-4.31-3.14-6.5-4.53a7.11,7.11,0,0,0-4.28-1.07c-1.36.09-3.09.2-3.39,1.72s1.52,1.67,2.57,2.13c2.5,1.09,5.08,2,7.59,3.07,7.06,3,10.43,8.19,9.69,14.68C185.24,218,180,223,172.86,224.21c-7.53,1.28-17.77-3.49-21.67-10-.5-.85-.47-1.28.19-1.85l1.94-1.75c1.67-1.5,3.18-3.93,5-4.23,2-.33,3.07,2.76,4.78,4.1,2.55,2,5.39,3.13,8.66,2.39,1.32-.3,2.72-.89,2.89-2.53s-1.14-2.12-2.26-2.61c-2.72-1.19-5.5-2.28-8.25-3.42-7.73-3.18-10.82-8.34-9.11-15.23,1.61-6.47,8.53-10.89,15.9-10.16C177.1,179.56,181.71,182,187.17,187.5Z"></path>
                            <path
                                d="M197.43,130.9c0,11.09-.08,22.17,0,33.26,0,2.48-.69,3.14-3.15,3.14-8.23,0-8.23.09-8.23-8.09,0-16.57-.06-33.14.06-49.71,0-2.81-.54-3.87-3.64-3.79-7.71.19-7.59,0-7.71-7.76-.05-2.78.68-3.67,3.52-3.54,5.23.24,10.48.26,15.7,0,2.94-.14,3.49.91,3.46,3.6C197.34,109,197.43,119.94,197.43,130.9Z"></path>
                            <path
                                d="M214.07,180.18c4.74,0,9.47.1,14.2-.05,2-.07,2.42.65,2.45,2.53.18,8.66.23,8.8-8.18,8.67-2.79-.05-3.19.9-3.15,3.37.15,8.59,0,17.19.12,25.78.05,2.47-.66,3.1-3.1,3.09-8.18,0-8.19.05-8.19-8,0-7.22-.06-14.45.05-21.67,0-1.94-.5-2.79-2.47-2.46a1.61,1.61,0,0,1-.38,0c-9.09-.16-9-.15-8.47-9.21.1-1.68.61-2.07,2.17-2C204.1,180.23,209.09,180.18,214.07,180.18Z"></path>
                            <path
                                d="M186.21,69.06c0,5.69,0,5.69-6.76,5.69-4.58,0-4.58,0-4.58-6.74,0-4.55,0-4.6,7.13-4.53C186.91,63.53,186.13,62.53,186.21,69.06Z"></path>
                            <path
                                d="M197.32,68.85c0-5.39,0-5.39,6.66-5.39,4.68,0,4.68,0,4.67,6.62,0,4.67,0,4.72-7,4.65C196.6,74.68,197.41,75.7,197.32,68.85Z"></path>
                            <path
                                d="M267.56,304.82c3.16,3.74,6,7.33,9.13,10.73,1.36,1.51,1.06,2.26-.33,3.51-6.51,5.82-6.47,5.86-12.14-.79-2-2.36-4-4.72-6.33-7.41-.84,3.56.21,6.95-.51,10.07-1.13,4.88-5.23,1.37-7.86,2.19-1.44.45-3.37.76-3.34-2.25.15-14.18.11-28.37,0-42.56,0-2,.6-2.53,2.53-2.47,4.36.15,8.72,0,13.07.09,7.17.2,12.81,4.55,14.62,11.12s-.8,12.71-6.92,16.62C269,304,268.44,304.31,267.56,304.82Zm-10-13.59c.3,1-1.36,3.85,2.51,3.52,2.81-.23,5.59-.66,5.56-4,0-3.07-2.66-3.51-5.35-3.76C257.12,286.74,257.32,288.57,257.57,291.23Z"></path>
                            <path
                                d="M213.64,275.94c3.65-.93,5,.85,6.13,4.06,4.47,12.51,9.19,24.93,14.06,37.29,1.07,2.73.41,3.54-2.12,4.44-7.33,2.6-7.4,2.75-9.92-4.51-.87-2.49-2-3.82-4.73-3.29a2.69,2.69,0,0,1-.75,0c-6.83-1.07-12.17.21-13.18,8.34,0,.24-.06.6-.22.7-3.58,2.29-5.92-1.53-9-1.86-1.64-.17-2-1.07-1.39-2.59q7.88-20.52,15.69-41.06C209.36,274.48,212,276.58,213.64,275.94Zm-.12,20.36c-1,2.07-3,3.88-1.9,6.21.23.49,3.44.46,3.71-.08C216.39,300.21,214.25,298.44,213.52,296.3Z"></path>
                            <path
                                d="M154.24,299.34c0-6.85.08-13.7,0-20.54,0-2.16.33-3,2.79-3,7,.19,13.94.15,20.91,0,2.1,0,2.68.53,2.7,2.66.1,8.62.18,8.62-8.32,8.62a15.58,15.58,0,0,1-3,0c-3.58-.72-4,1.1-3.91,4.1.1,2.13.69,2.87,2.79,2.67,1.6-.16,3.23,0,4.85,0,6.41,0,6.19,0,6.49,6.42.18,3.77-.73,5.51-4.78,4.86a32.45,32.45,0,0,0-5.22-.05c-3.78,0-5.26,2.2-4,5.72.51,1.42,1.57.95,2.45,1,3.49.05,7,.08,10.46,0,1.55,0,2.4.33,2.14,2a2.41,2.41,0,0,0,0,.38c.37,8.85.37,8.85-8.4,8.85-4.49,0-9-.33-13.44.1-4,.4-4.7-1.17-4.54-4.73C154.45,312,154.24,305.69,154.24,299.34Z"></path>
                            <path
                                d="M123.72,289.08c3-4.56,5.68-8.56,8.2-12.69,1.12-1.83,2-2.29,4-1,7.18,4.61,7.72,4.91,2.41,11.62-7.17,9.06-10.31,18.82-9.12,30.33.62,6.09.09,6.14-5.88,6.14-5.29,0-5.8-.06-5.16-5.33,1.44-11.9-1.7-22-9.22-31.4-5.13-6.38-4.56-6.71,2.38-11.33,2.08-1.37,3-1.07,4.19,1C118,280.55,120.74,284.52,123.72,289.08Z"></path>
                        </svg>

                    </div>

                    <div class="gc_content">
                        <h4>Free First-Year Annual Compliance


                        </h4>
                        <p>We provide absolutely free annual compliance for the first year.


                        </p>
                    </div>
                </div>
                <div class="gc_item">
                    <div class="gc_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510.94 510.79">
                            <path
                                d="M231.47,0h45.89c1.32,1.68,3.37,1.05,5,1.43,58.05,13,102.25,66.08,105.6,130.5.17,3.23.94,5.35,3.67,7.42,8.88,6.71,14.37,15.73,15.14,26.91.28,4.09,1.77,4.32,5,4.31,31.26-.1,62.51,0,93.76-.18,4.38,0,5.36,1,5.36,5.36q-.21,164.78,0,329.55c0,4.09-.56,5.5-5.21,5.49q-252.85-.23-505.7-.13V170.55q48.89,0,97.77,0c2.78,0,4.42-.1,4.64-3.73.7-11.85,6.57-21,15.89-28.08a6.39,6.39,0,0,0,2.87-5.32,130.39,130.39,0,0,1,2.54-21.75C134.26,63.41,161.1,28.2,206.7,8,214.69,4.41,223.29,2.88,231.47,0ZM21.69,183.18c.84.79,1.61,1.57,2.44,2.29q106.8,93,213.63,186c11,9.58,24.52,9.42,35.69-.23q106.23-91.72,212.43-183.51c1.17-1,2.88-1.65,3.21-3.91-26.86,0-53.57,0-80.28-.06-2.19,0-2.82,1.08-3.37,2.76a38.25,38.25,0,0,1-13.25,18.26,5.63,5.63,0,0,0-2.34,5.06c.1,9,0,17.95,0,26.92,0,18.38-9.59,28-27.92,28q-32.67,0-65.35,0c-2.69,0-4.52.47-6,3.11a14.67,14.67,0,0,1-12.63,7.7,182.93,182.93,0,0,1-18.44,0,17.16,17.16,0,0,1-16-17.26,17.41,17.41,0,0,1,16.85-17c5-.16,10,0,15-.07,6.92-.14,12.22,2.68,15.76,8.59.92,1.55,1.7,2.5,3.73,2.5,23.45-.09,46.9,0,70.34-.14,7.21,0,12.36-4.65,12.65-11.53.41-9.93.1-19.89.1-29.83-4.67-.4-4,2.78-3.79,5.28.26,3-.57,4.06-3.78,4-9.48-.22-19-.25-28.43,0-3.55.1-4-1.27-4-4.32q.14-45.12,0-90.26c0-3,.65-4,3.81-3.88,8.47.24,17,.37,25.43,0,4.42-.2,6,1,5.34,5.41-.21,1.4-.78,3.95,1.85,3.64,2.24-.27.89-2.51.79-3.71C373.09,102,365,79.14,349.72,59.42,319.09,20,279,2.63,229.55,13.31c-42.62,9.21-70.62,36.89-87,76.76a127.84,127.84,0,0,0-8.64,37.18c-.09,1-1.56,3.28,1.11,3.33,2.41,0,1.45-2.09,1.66-3.4a5,5,0,0,0,0-1.49c-.6-3.33.87-4.13,4.06-4.06,9.48.21,19,.17,28.44,0,2.68,0,3.7.53,3.69,3.48q-.16,45.63,0,91.26c0,2.83-.78,3.71-3.64,3.66-9.31-.17-18.63-.24-27.93,0-3.69.11-5.3-.81-4.6-4.63.54-2.91-.59-4.25-3.65-5-13.15-3.33-22.18-11.61-27.12-24.15-1.13-2.88-2.21-4.06-5.5-4-24.94.16-49.88.08-74.82.12C24.39,182.38,23,181.8,21.69,183.18ZM490.21,499.5c-56.86-50.36-113-100-169-149.8-2.22-2-3.5-2.05-5.73,0C304,360,292.31,370.15,280.67,380.32c-14.14,12.36-36.12,12.49-50.32.31-11.48-9.85-23-19.6-34.29-29.69-3-2.67-4.51-2.12-7.16.23Q118.85,413.08,48.65,474.8c-9.13,8-18.23,16.11-27.95,24.7ZM12.14,493c1-.9,1.63-1.39,2.2-1.89q83.46-74.25,167-148.41c3.35-3,1-3.83-.81-5.42L50.86,224.15C38.13,213.06,25.38,202,12.14,190.47ZM498.76,189.88c-1.07.76-1.49,1-1.84,1.32q-83.58,73.26-167.2,146.46c-3,2.63-1.66,3.55.43,5.4q73.19,64.71,146.27,129.51c7.26,6.43,14.55,12.82,22.34,19.68ZM137.59,171.52c0-8.3-.13-16.6.07-24.89.08-3.2-1.09-3.86-3.71-2.72a41.1,41.1,0,0,0-6.61,3.37c-10.58,7.11-14.1,19.4-9.75,33.6a26.31,26.31,0,0,0,16.18,17.64c2.79,1.11,4,1.07,3.91-2.62C137.41,187.78,137.6,179.65,137.59,171.52Zm236.52-.94c0,7.82.23,15.64-.09,23.44-.19,4.41,1.06,5.16,4.86,3.29,10.52-5.18,15.36-13.64,16.57-25.25,1.31-12.6-5.18-24.3-17.14-28.68-3.05-1.12-4.43-1.26-4.28,2.77C374.31,154.29,374.11,162.44,374.11,170.58Zm-213,0q0-14.45,0-28.88c0-8.11,0-7.91-7.91-8.17-3.6-.12-4.72.65-4.67,4.52.22,20.41.1,40.83.1,61.24,0,8.22,0,8.08,8.38,8.2,3.14,0,4.26-.66,4.19-4.05C160.93,192.49,161.07,181.54,161.07,170.58Zm188.68,0v28.88c0,8,0,7.72,8.1,8.07,4,.18,4.48-1.3,4.45-4.76-.15-20.24-.07-40.49-.07-60.74,0-8.54,0-8.34-8.55-8.51-3.43-.06-4.05,1.1-4,4.2C349.85,148.67,349.75,159.63,349.75,170.58Zm-81.23,81.69c-2.81,0-5.62,0-8.43,0-3.41.06-5.28,2.07-5.42,5.24a5,5,0,0,0,5.07,5.61c5.44.26,10.91.25,16.36,0a5,5,0,0,0,5.16-5.52c-.07-3.25-1.94-5.19-5.3-5.33C273.48,252.2,271,252.27,268.52,252.27Z"></path>
                            <path
                                d="M255.91,466.7c42.73,0,85.46.07,128.19-.11,4.24,0,5.56,1.1,5,5.19-.43,3.27,1.47,6.94-4.91,6.92q-128.44-.33-256.89-.05c-4.14,0-4.9-1.33-4.76-5,.26-6.9.06-6.92,7.15-6.92Z"></path>
                            <path
                                d="M183.08,441.9c1.9,6.52-3.07,4.6-6.6,5.17-6,1-4.66-3-5.23-6.47-1-6.3,2.91-5.15,6.72-5.61C184,434.26,183.44,437.84,183.08,441.9Z"></path>
                            <path
                                d="M246.08,441.87c1.47,4.94-1.7,5.42-6.24,5.21-3.57-.16-6.22.23-5.76-5,.6-6.92.14-7,6.76-7C246.07,435.12,246.07,435.12,246.08,441.87Z"></path>
                            <path
                                d="M308.73,441.21c1.78,5.84-1.75,5.62-6.06,5.94-5.21.39-5.53-1.76-5.77-6.12-.3-5.35,1.68-6.08,6.38-6.09C308.18,434.92,310.07,436.32,308.73,441.21Z"></path>
                            <path
                                d="M207.63,447c-5.83,1.76-4.64-2.7-5.11-6.72-.78-6.64,3.62-4.72,7.08-5.2,6.74-.93,4.4,3.89,5,7.13C215.74,448.17,211.65,446.91,207.63,447Z"></path>
                            <path
                                d="M271.25,446.74c-5.37,1.65-5.72-1.17-5.91-5.57-.22-5,1.24-6.32,6.23-6.23,4.58.07,6.2.91,6,5.86C277.44,445.59,276.94,448.6,271.25,446.74Z"></path>
                            <path
                                d="M335,446.82c-4.16.58-7.36.66-6.7-5.06.45-3.82-.6-7.72,5.6-6.73,3.38.55,7.46-1,6.53,5.18C339.81,443.91,341.58,448.87,335,446.82Z"></path>
                        </svg>

                    </div>

                    <div class="gc_content">
                        <h4>Lifetime Email Support

                        </h4>
                        <p>After forming your company, solve your issues with our lifetime email support.


                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="article_h wantHide">
        <div class="container">
            <div class="hc_head" style="text-align: center; padding-bottom: 10px;">
                <h4>How We Process

                </h4>
                <h2 style="color: #ff5700">Your Company Formation
                </h2>
                <p>Streamlining Your Path to Official Business Status—Efficiently and Effortlessly.
                </p>
            </div>
            <div class="hc_items">
                <div class="hc_item">
                    <img src="{{asset('assets/images/Steady_formation.webp')}}" alt="">
                </div>
                <div class="hc_item">
                    <div class="gc_item">
                        <h3>Choose a Company Name and Structure
                        </h3>
                        <p>Which type of company structure do you want to form? LLC, S Corp, or C Corp? Make a decision
                            based on your business goal.
                        </p>
                    </div>
                    <div class="gc_item">
                        <h3>Select US State

                        </h3>
                        <p>
                            Select which is the best US state for your company. Delaware, Wyoming, Florida, or, New
                            York? Choose any state you want.

                        </p>
                    </div>
                    <div class="gc_item">
                        <h3>Easy Peasy Documentation Process
                        </h3>
                        <p>Just provide all the details, and we will make your company forming easy like blink.
                        </p>
                    </div>
                    <div class="gc_item">
                        <h3>Expedited Document Delivery
                        </h3>
                        <p>After forming your company get all your documents fast. Our expert team is here to provide
                            you fastest document delivery.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#step1" style="padding: 10px 12px;" class="btn btn-next">Form Now</a>
            </div>
        </div>
    </div>
    <div class="article_blog wantHide">
        <div class="container">
            <div class="ic_head" style="text-align: center; padding-bottom: 10px;">
                <h2>Recent Article
                </h2>
            </div>

            <div class="blogs_items">
                @foreach($posts as $post)
                    @include('web.blog.item')
                @endforeach


            </div>

        </div>
    </div>
    <div class="article_i wantHide">
        <div class="container">
            <div class="ic_head" style="text-align: center; padding-bottom: 10px;">
                <h2>Frequently Asked Questions

                </h2>
            </div>
            <div class="ic_items">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                As a non-resident, can I register a company in the USA?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you can. Any foreign company or non-resident citizen is welcome to open a business
                                in the USA.

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Can I complete the entire company formation procedures online?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you can. We have a dynamic team to complete your entire company formation procedure
                                virtually.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                How much time does it take to form a company?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Once we receive your basic information, it will take 1-15 working days to complete the
                                formation. However, if you purchase an expedited filing service it takes 1-3 working
                                days only.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Can I form a company in another state where I don’t live?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, it’s very much possible. You can form a company in any state from anywhere around
                                the world.

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Do I need to renew my company every year?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you need to renew your company every year. Here, we can help you renew your company
                                easily with our expert team.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('web.layouts.footer')

@endsection
@push('js')
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>
{{--    <script src="https://js.stripe.com/v3/"></script>--}}

    <script>
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const updateCounter = () => {
                    const target = +counter.getAttribute('data-target');
                    const isPercent = counter.getAttribute('data-percent');

                    const count = +counter.innerText;
                    const increment = target / 100; // Change this value to adjust the speed
                    const lastSymble = isPercent ? "%" : "+"
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment) + lastSymble;
                        setTimeout(updateCounter, 200); // Change this value to adjust the speed
                    } else {
                        counter.innerText = target + lastSymble;
                    }
                };
                updateCounter();
            });
        }

        // Start the animation when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', animateCounters);
    </script>
    <script>
        let stateFees = @json($state_fees);
        let stateNameSelect = document.getElementById('state_name');

        if (stateNameSelect) {
            let option = document.createElement('option');
            option.value = "";
            option.text = "Choose State Name";
            stateNameSelect.appendChild(option);

            // Loop through the stateFees array and create option elements
            for (const [state, fee] of Object.entries(stateFees)) {
                // Create a new option element
                let option = document.createElement('option');
                option.value = state;
                option.text = state;
                option.setAttribute('data-calculate', fee);

                // Append the option to the select element
                stateNameSelect.appendChild(option);
            }
        }


        // $(document).ready(function(){
        //     removeAllDataFromLocalStorage()
        // })


        // var stripe = Stripe('pk_test_51PQ4kzJ4dU3xb4W3E1Fa0XdjKuaSQyn9MqdojNPHhnVfDqgNfg5ZdnHPXvONKwOnM3eWWIMV6Eulhdi3rVswaAj700fiRDDXSU');
        // var elements = stripe.elements();
        // var card = elements.create('card');
        // card.mount('#card-element');

        function onChangePaymentGetway(event) {
            let rush_processing_value = event.target.value;
            let parent = event.target.parentElement;
            let field_name = event.target.getAttribute("id")
            console.log(field_name)
            if (field_name == 'stripe_payment') {
                $('.processing_card_item').removeClass('active');
                $('#stripe').css('display', 'block');
                $('#stripe_payment_submit_btn').css('display', 'block');
                $('#paypal_getway').css('display', 'none')
                parent.classList.add("active")
            } else if (field_name == 'paypal_payment') {
                $('.processing_card_item').removeClass('active');
                $('#stripe').css('display', 'none')
                $('#stripe_payment_submit_btn').css('display', 'none');
                $('#paypal_getway').css('display', 'block');
                parent.classList.add("active")
            }
        }

        // function finalStep(event) {
        //     var form = document.getElementById('stripe-form');
        //     event.preventDefault();
        //     stripe.createToken(card).then(function (result) {
        //         if (result.error) {
        //             console.log("EERRROOR")
        //             // Inform the user if there was an error
        //             console.log(result.error.message);
        //         } else {
        //
        //             let stripeToken = result.token.id;
        //             let localStorageData = retrieveLocalStorageValue();
        //
        //
        //             var form = document.getElementById('stripe-form');
        //
        //             // Append Stripe Token
        //             var hiddenInput = document.createElement('input');
        //             hiddenInput.setAttribute('type', 'hidden');
        //             hiddenInput.setAttribute('name', 'stripeToken');
        //             hiddenInput.setAttribute('value', stripeToken);
        //             form.appendChild(hiddenInput);
        //
        //             // Append Local Storage Data
        //             var hiddenInput2 = document.createElement('input');
        //             hiddenInput2.setAttribute('type', 'hidden');
        //             hiddenInput2.setAttribute('name', 'localStorageData');
        //             hiddenInput2.setAttribute('value', JSON.stringify(localStorageData)); // Make sure it's a string
        //             form.appendChild(hiddenInput2);
        //             removeAllDataFromLocalStorage()
        //             // Submit the form
        //             form.submit();
        //
        //         }
        //     });
        // }
        function finalStep(event) {
            var form = document.getElementById('stripe-form');
            event.preventDefault();
            let localStorageData = retrieveLocalStorageValue();

            // // Append Stripe Token
            // var hiddenInput = document.createElement('input');
            // hiddenInput.setAttribute('type', 'hidden');
            // hiddenInput.setAttribute('name', 'stripeToken');
            // hiddenInput.setAttribute('value', stripeToken);
            // form.appendChild(hiddenInput);

            // Append Local Storage Data
            var hiddenInput2 = document.createElement('input');
            hiddenInput2.setAttribute('type', 'hidden');
            hiddenInput2.setAttribute('name', 'localStorageData');
            hiddenInput2.setAttribute('value', JSON.stringify(localStorageData)); // Make sure it's a string
            form.appendChild(hiddenInput2);
            removeAllDataFromLocalStorage()
            // Submit the form
            form.submit();
        }

        $("#paypalPayment").click(function (event) {
            event.preventDefault();
            let localStorageData = retrieveLocalStorageValue();
            var params = new URLSearchParams();
            params.append('localStorageData', JSON.stringify(localStorageData));

            let route = "{{route('paypal.pay')}}?" + params.toString();
            removeAllDataFromLocalStorage()
            location.href = route
        })


    </script>
@endpush
