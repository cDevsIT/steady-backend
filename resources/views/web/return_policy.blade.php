@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>
        nav#navbar_sticky {
            margin-bottom: 0px !important;
        }

        #about_hero {
            background-image: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url({{asset('assets/images/Breadcome.webp')}});
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

        .privacy_policy {
            padding: 30px;
        }

        .fw-400 {
            font-weight: 400;
        }

    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endpush
@section('content')
    <div class="about_hero">
        <div class="bg-dark text-secondary px-4 py-5 text-center" id="about_hero">
            <div class="py-5">
                <h1 class="display-5 fw-bold text-white">Refund Policy
                </h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="privacy_policy">

            <p><strong>Returns</strong><span class="fw-400"><br></span></p>
            <p><span class="fw-400">Purchasing digital services &amp; products, including PDF downloads and online
        material, is subject to the following terms and conditions. Consumers are advised to review carefully before
        making any purchase.</span></p>
            <p><span class="fw-400">Since your purchase is a digital product, it is deemed “used” after download or
        opening, and all purchases made on </span><strong>https://steadyformation.com/</strong><span class="fw-400">
        are
        non-refundable or exchangeable. Since the products available here are intangible, there is a strict no-refund
        policy.</span></p>
            <p><strong>Steady Formation</strong><span class="fw-400"> reserves the right to amend any information, including
        but
        not limited to prices, technical specifications, terms of purchase, and product or service offerings, without
        prior notice.</span></p>
            <h5><strong>Delivery of Goods and Services</strong></h5>
            <p><span class="fw-400">If you do not receive the digital product link upon purchasing (Within the
        required
        timeframe), you can immediately email </span><strong>support@steadyformation.com</strong><span class="fw-400">
        with your transaction/payment details to ensure your product is delivered as soon as possible.</span></p>
            <h5><strong>Refunds (if applicable)</strong></h5>
            <p><span class="fw-400">If you are approved, your refund will be processed, and a credit will
        automatically
        be applied to your credit card or original payment method within a few days. you’ll get a full refund, minus
        state
        and third-party fees, within 7 days of purchase.</span></p>
            <p><span class="fw-400">The client can cancel the contract anytime; a refund will not be provided if the
        contract is canceled in between the ongoing months. No prorated refunds will be given in this case, while future
        billing will be discontinued.</span></p>
            <p><span class="fw-400">We will not entertain any cancellations for services our sales team has offered
        you
        on special occasions.&nbsp;</span></p>
            <p><span class="fw-400">Digital service packages are not refundable. </span><strong>Steady Formation</strong><span
                    class="fw-400"> reserves the right to decide by its own capacity to decide the legitimacy of a refund
        claim.</span></p>
            <h5><strong>Late or missing refunds (if applicable)</strong></h5>
            <p><span class="fw-400">If you haven’t received a refund, re-cross your preferred payment method or
        account.</span></p>
            <p><span class="fw-400">Then contact your preferred payment method or account company; it may take some
        time before your refund is officially posted.</span></p>
            <p><span class="fw-400">There is often some processing time before a refund is posted.</span></p>
            <p><span class="fw-400">If you’ve done all this and still have not received your refund, please contact
        us
        at&nbsp; </span><strong>support@steadyformation.com</strong><span class="fw-400">.</span></p>
            <p><strong>Note: The preferred method will be the same as the means or account you used to pay us.</strong></p>
            <h5><strong>Sale items (if applicable)</strong></h5>
            <p><span class="fw-400">Only regular-priced items may be refunded. Unfortunately, sale items cannot be
        refunded. As we provide digital service, refunding those is impossible in most scenarios.</span><br><br></p>
            <p><span class="fw-400">For any kind of query, please email us at
      </span><strong>support@steadyformation.com</strong><span class="fw-400">.</span></p>
            <h5><br><br><br><br><br><br></h5>
        </div>
    </div>

    @include('web.layouts.footer')
@endsection
@push('js')
@endpush
