{{--    ============================= Step Four: Registered Agent & Business Address & Registered Agent and Business Address Package * ============= Figma : Funnel 3 =========================--}}
<div id="step4" class="step mt-4" style="display: none">
    <div class="row mb-5">
        <div class="col-12 col-md-8">
{{--            <div class="reg_agent_area">--}}
{{--                <h5>Registered Agent & Business Address</h5>--}}
{{--                <h6>Registered Agent</h6>--}}
{{--                <p>A registered agent is a legal  requirement and designated individual or entity responsible for--}}
{{--                    receiving legal and government documents on behalf of a business.</p>--}}
{{--                <ul>--}}
{{--                    <li>Legal requirement</li>--}}
{{--                    <li>Protects your privacy, and acts as your business's public contact.</li>--}}
{{--                    <li>Receives legal documents for your business.</li>--}}
{{--                    <li>Handles state notices</li>--}}
{{--                    <li>Handles government correspondence confidentially.</li>--}}
{{--                </ul>--}}
{{--            </div>--}}
            <div class="business_address_area">
                <h6>Business Address</h6>
                <p>A business address provides a remote physical address for receiving mail and packages,
                    enhancing
                    privacy and professionalism.</p>
                <ul>
                    <li>Establishes Professional Appearance</li>
                    <li>Provides Privacy Protection</li>
                    <li>Mail Management</li>
                    <li>Handles state notices</li>
                    <li>Business Presence</li>
                </ul>
            </div>
            <h6 class="p-3">
                Business Address Package *
            </h6>

            <div class="card-container">
                <div class="card_item">
                    <input type="radio" id="free-plan" class="plan" onchange="planChange(event)" name="plan"
                           checked>
                    <label for="free-plan" class="card-content">
                        <div class="radio-circle"></div>
                        <h2>FREE</h2>
                        <p class="tagline">Use My Own Address</p>
                        <ul class="features">
{{--                            <li>Use My Own Address</li>--}}
                            <li>Use my address as the primary business address.</li>
                            <li>Provided Residential addresses will be publicly listed.</li>
                        </ul>
                        <div class="radio-button"></div>
                    </label>
                </div>
                <div class="card_item">
                    <input type="radio" id="monthly-plan" class="plan" onchange="planChange(event)" name="plan">
                    <label for="monthly-plan" class="card-content">
                        <div class="radio-circle"></div>
                        <h2>$10</h2>
                        <p class="tagline">Monthly</p>
                        <ul class="features">
{{--                            <li>Registered Agent for One Month</li>--}}
                            <li>Professional Business Address for One Month</li>
                            <li>Mail Forwarding for One Month</li>
                        </ul>
                        <div class="radio-button"></div>
                    </label>
                </div>
                <div class="card_item">
                    <input type="radio" id="yearly-plan" class="plan" onchange="planChange(event)" name="plan">
                    <label for="yearly-plan" class="card-content">
                        <div class="radio-circle"></div>
                        <h2>$99</h2>
                        <p class="tagline">Yearly</p>
                        <ul class="features">
{{--                            <li>Registered Agent for One Year</li>--}}
                            <li>Professional Business Address for One Year</li>
                            <li>Mail Forwarding for One Year</li>
                        </ul>
                        <div class="radio-button"></div>
                    </label>
                </div>
            </div>

            <div id="free_plan_details">
                <ul class="mb-3">
                    <li>Are you sure you can meet this state requirement?</li>
                    <li>You must provide a physical address for your Registered Agent in the state where your
                        business operates (no PO Boxes or PMBs allowed).
                    </li>
                    <li>In some states, this address (business address) may appear on public
                        records along with your name, phone number, and email address.
                    </li>
                    <li>If You Don’t Have One, Choose a Monthly/Yearly Package for Registered Agent Address.
                    </li>
                </ul>
                <div class="form_of_register_agenet" id="free_plan_form">
                    <h4>Your Registered Business Address *</h4>
                    <div class="row">
                        <div class="col-12 form-group step_group">
                            <label for="step4_street_address" class="step_label">Street Address *</label>
                            <input type="text" autocomplete="off" name="street_address" required id="street_address"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="step4_city" class="step_label">City *</label>
                            <input type="text" autocomplete="off" name="step4_city" required id="step4_city"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="step4_state" class="step_label">State *</label>
                            <input type="text" required name="step4_state" id="step4_state" class="form-control step_form_control" readonly>
                            <!--<select name="step4_state" required id="step4_state"-->
                            <!--        class="form-control step_form_control">-->

                            <!--    @foreach($states as $state)-->
                            <!--        <option value="{{$state}}">{{$state}}</option>-->
                            <!--    @endforeach-->
                            <!--</select>-->
{{--                            <input type="text" autocomplete="off" name="step4_state" required id="step4_state"--}}
{{--                                   class="form-control step_form_control">--}}
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="step4_zip_code" class="step_label">Zip Code *</label>
                            <input type="text" autocomplete="off" name="step4_zip_code" required id="step4_zip_code"
                                   class="form-control step_form_control">
                        </div>

                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="step4_country" class="step_label">Country</label>
                            <select name="step4_country" autocomplete="off" disabled required="" id="step4_country"
                                    class="form-control step_form_control ">
                                <option selected disabled value="United States">United States</option>

                            </select>
                            {{--                            <select name="step4_country" required id="step4_country"--}}
                            {{--                                    class="form-control step_form_control">--}}
                            {{--                                <option value="Countries">Countries</option>--}}
                            {{--                            </select>--}}
                        </div>
                        <div class="col-12">
                            <p style="font-weight: bold">“Must be a valid US Address” and country will be default United
                                States.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            @include('web.part.sticky-sidebar')
        </div>
    </div>
    <div class="text-center pb-4" style="text-align: center">
        <button onclick="prevStep(event,4,'step_4')" class="btn btn-next "><i
                class="fa-solid fa-chevron-left"></i>
            Back
        </button>
        <button onclick="nextStep(event,4,'step_4')" class="btn btn-next ">Next <i
                class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>

