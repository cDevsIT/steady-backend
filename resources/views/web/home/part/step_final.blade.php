
{{--    ============================= Step Nine: Check Out * ============= Figma : Check Out =========================--}}



<div id="step10" class="step" style="display: none">
    <div class="row mb-5">
        <div class="col-12 col-md-8">
            <div class="processing_card-container">
                <div class="processing_card_item active">
                    <input type="radio" id="stripe_payment"
                           onchange="onChangePaymentGetway(event)" name="payment" checked>
                    <label for="stripe_payment" class="card-content">
                        <div class="radio-circle"></div>
                        <span class="d-flex justify-content-between">
                                    <h3>Pay with card</h3>
                                </span>
                    </label>
                </div>
     <div class="processing_card_item">
                    <input type="radio" id="paypal_payment"
                           onchange="onChangePaymentGetway(event)" name="payment">
                    <label for="paypal_payment" class="card-content ">
                        <div class="radio-circle"></div>
                        <span class="d-flex justify-content-between">
                                    <h3>Paypal</h3>
                                </span>
                    </label>
                </div>

            </div>
            <div id="stripe" style="display: block" class="pay_item card card-body shadow">
                <form action="{{ route('pay.stripe') }}" method="post" id="stripe-form">
                    @csrf
                    <h4>Check Out</h4>
{{--                    <label for="card-element">Credit or debit card</label>--}}
{{--                    <div id="card-element" class="mt-2"></div>--}}
                    <div class="btn text-right mt-5 mb-2" style="width: 100%;">
                        <button type="submit" onclick="finalStep(event)" class="btn btn-next">Pay <span class="final_amount">$0.00</span> Now</button>
                    </div>
                    {{--                       <div class="text-right pb-4" id="stripe_payment_submit_btn" style="text-align: center; display: block">--}}
                    {{--                           <button onclick="finalStep(event)" class="btn btn-next ">--}}
                    {{--                               Pay $ 100--}}
                    {{--                           </button>--}}
                    {{--                       </div>--}}
                </form>
            </div>
            <div id="paypal_getway" style="display: none" class="pay_item">
                <a href="{{route('paypal.pay')}}" id="paypalPayment" class="card card-body shadow"
                   style="display: flex; align-items: center">
                    <img src="{{asset('assets/images/paypal.png')}}" title="Paypal with  USD"
                         style="width: 100px;align-items: center;" alt="">
                    <span class="amount final_amount">$0.00</span>
                    <button class="btn btn-next">Pay Now</button>
                </a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            @include('web.part.sticky-sidebar')
        </div>
    </div>

    {{--        <div class="text-right pb-4" style="text-align: center">--}}
    {{--            <button onclick="prevStep(event,9,'step_9')" class="btn btn-next "><i class="fa-solid fa-chevron-left"></i>--}}
    {{--                Back--}}
    {{--            </button>--}}
    {{--            <button onclick="nextStep(event,9,'step_9')" class="btn btn-next ">Next <i--}}
    {{--                    class="fa-solid fa-chevron-right"></i></button>--}}
    {{--        </div>--}}
    {{--        --}}

</div>
