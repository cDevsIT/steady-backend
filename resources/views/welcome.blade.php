@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    <div class="container">

        @include('web.home.part.step_one')
        @include('web.home.part.step_two')
        @include('web.home.part.step_three')
        @include('web.home.part.step_four')
        @include('web.home.part.step_five')
        @include('web.home.part.step_six')
        @include('web.home.part.step_seven')
        @include('web.home.part.step_eight')
        @include('web.home.part.step_final')
    </div>
@endsection
@push('js')
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        function onChangePaymentGetway(event) {
            console.log(localStorage.getItem("final_amount"))
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

        function finalStep(event) {
            var form = document.getElementById('stripe-form');
            event.preventDefault();
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error
                    console.log(result.error.message);
                } else {

                    let stripeToken = result.token.id;
                    let localStorageData = retrieveLocalStorageValue();
                    $.ajax({
                        url: "{{route('pay.stripe')}}",
                        type: 'POST',
                        data: {
                            stripeToken: stripeToken,
                            localStorageData: localStorageData,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (data) {
                            console.log(data)
                        },
                        error: function (data) {
                            console.log(data)
                        }
                    })
                }
            });
        }

        $("#paypalPayment").click(function (event) {
            event.preventDefault();
            let localStorageData = retrieveLocalStorageValue();
            let route = "{{route('paypal.pay')}}?localStorageData=" + encodeURIComponent(localStorageData);
            location.href = route;

        })


    </script>
@endpush
