@extends('admin.layouts.master')
@push('title')
    Create Customer
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Create Customer</h1>
                    <p class="page-subtitle-modern">Add a new customer with complete business information</p>
                </div>
                <a href="{{route('admin.customers')}}" class="btn btn-outline-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>Back to Customers
                </a>
            </div>
        </div>

        <form action="{{route("admin.createCustomer")}}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name" class="col-form-label">First Name:</label>
                                        <input type="text" required class="form-control" id="first_name" name="p_first_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" class="col-form-label">Last Name:</label>
                                        <input type="text" required class="form-control" id="last_name" name="p_last_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email:</label>
                                        <input type="email" required class="form-control" id="email" name="p_email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="col-form-label">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="p_phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="col-form-label">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="col-form-label">Confirm Password:</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Business Info</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_name" class="col-form-label">Business Name:</label>
                                        <div class="input-group  " style="border-radius: 20px">
                                            <input type="text" name="business_name"  id="business_name"
                                                   class="form-control step_form_control"
                                                   style="border-right: 1px solid #FF5700;">
                                            <span class="input-group-text " id="basic-addon2">
                                <select name="business_type" id="business_type">
                                    <option value="LLC">LLC</option>
                                    <option value="S Corp">S Corp</option>
                                    <option value="C Corp">C Corp</option>
                                </select>
                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type_of_industry" class="step_label">Type Of Industry*</label>
                                        <input type="text" name="type_of_industry" class="form-control">
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state_name" class="col-form-label">State Name:</label>
                                        <select name="state_name" id="state_name" class="form-control step_form_control">
                                            <option> Choose State Name</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id }}"
                                                        data-calculate="{{$state->fees}}">{{ $state->state_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number_of_ownership" class="step_label">No. of Ownership *</label>
                                        <select name="number_of_ownership" onchange="onChangeNumberOfMembership(event)"
                                                id="number_of_ownership" class="form_control step_form_control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <div class="my-3 h3">Owners Info *</div>
                            <div class="step_three_owners_info card card-body shadow" id="show_multi_member_info">
                                <div class="row">
                                    <div class="col-md-6 form-group step_group">
                                        <label for="name" class="step_label"> Name *</label>
                                        <input type="text" name="name[]" required id="name1"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-md-6 form-group step_group">
                                        <label for="email" class="step_label"> Email *</label>
                                        <input type="email" name="email[]" required id="email1"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-md-6 form-group step_group">
                                        <label for="phone" class="step_label"> Phone *</label>
                                        <input type="text" name="phone[]" required id="phone1"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-md-6 form-group step_group">
                                        <label for="ownership_percentage" class="step_label"> Ownership
                                            Percentage *</label>
                                        <select name="ownership_percentage[]" required
                                                class="form-control step_form_control" id="ownership_percentage1">
                                            @for ($value = 100; $value >= 1; $value--)
                                                <option value="{{ $value }}">{{ $value }}%</option>
                                            @endfor
                                        </select>
                                    </div>


                                    <div class="col-md-12  form-group step_group">
                                        <label for="street_address" class="step_label">Street Address</label>
                                        <input type="text" name="street_address[]" id="street_address1"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-md-6 form-group step_group">
                                        <label for="city" class="step_label">City</label>
                                        <input type="text" name="city[]" id="city1"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-md-6 form-group step_group">
                                        <label for="state" class="step_label">State</label>
                                        <input type="text" name="state[]" id="state1"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-md-6 form-group step_group">
                                        <label for="zip_code" class="step_label">Zip Code</label>
                                        <input type="text" name="zip_code[]" id="zip_code1"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-md-6 form-group step_group">
                                        <label for="country" class="step_label">Country</label>
                                        <select name="country[]" id="country1" required
                                                class="form-control country_list step_form_control">

                                        </select>
                                    </div>

                                    <div class="col-md-12  form-group step_group">
                                        <div class="row px-5">
                                            <div class="col-2"><i class="fa-regular fa-lightbulb"></i></div>
                                            <div class="col-10 ">
                                                This address is used for internal purposes only and will not be shared
                                                with
                                                any third parties or other outside agencies unless provided in any
                                                subsequent pages of the order process which require the intake of an
                                                address.
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Registered Agent & Business Address</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="free-plan">
                                            <input type="radio" id="free-plan" class="plan" onchange="planChange(event)"
                                                   name="plan"
                                                   checked> Free Plan (FREE)
                                        </label>

                                        <label for="monthly-plan">
                                            <input type="radio" id="monthly-plan" class="plan" onchange="planChange(event)"
                                                   name="plan"> Monthly Plan ($25)
                                        </label>

                                        <label for="yearly-plan">
                                            <input type="radio" id="yearly-plan" class="plan" onchange="planChange(event)"
                                                   name="plan"> Yearly Plan ($259)
                                        </label>
                                    </div>
                                    <input type="hidden" name="package_name" value="free-plan" id="package_name" >

                                    <div class="form-group col-12 ">
                                        <div class="form_of_register_agenet" id="free_plan_form">
                                            <h4>Your Registered Agent Address *</h4>
                                            <div class="row">
                                                <div class="col-12 form-group step_group">
                                                    <label for="step4_street_address" class="step_label">Street Address
                                                        *</label>
                                                    <input type="text" name="step4_street_address" required id="street_address"
                                                           class="form-control step_form_control">
                                                </div>
                                                <div class="col-12 col-md-6 form-group step_group">
                                                    <label for="step4_city" class="step_label">City *</label>
                                                    <input type="text" name="step4_city" required id="step4_city"
                                                           class="form-control step_form_control">
                                                </div>
                                                <div class="col-12 col-md-6 form-group step_group">
                                                    <label for="step4_state" class="step_label">State *</label>
                                                    <input type="text" name="step4_state" required id="step4_state"
                                                           class="form-control step_form_control">
                                                </div>
                                                <div class="col-12 col-md-6 form-group step_group">
                                                    <label for="step4_zip_code" class="step_label">Zip Code *</label>
                                                    <input type="text" name="step4_zip_code" required id="step4_zip_code"
                                                           class="form-control step_form_control">
                                                </div>

                                                <div class="col-12 col-md-6 form-group step_group">
                                                    <label for="step4_country" class="step_label">Country</label>
                                                    <select name="step4_country" required id="step4_country"
                                                            class="form-control step_form_control country_list">
                                                        <option value="Countries">Countries</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <p style="font-weight: bold">Note: Must be a valid and USA Registered Agent
                                                        Address.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>EIN (Employer Identification Number)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="add_en">
                                            <input type="radio" onchange="enAmountChange(event)" id="add_en" value="Yes"
                                                   name="has_en"
                                                   class="radio-input" checked> Add an EIN to Only $69
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_en">
                                                <input type="radio" id="no_en" onchange="enAmountChange(event)" value="No"
                                                       name="has_en"
                                                       class="radio-input"> No, Skip
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Operating Agreement / Corporate Bylaws</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="agreement">
                                            <input type="radio" id="agreement" onchange="agreementChange(event)" value="Yes"
                                                   name="en_agreement"
                                                   class="radio-input" checked> Operating Agreement / Bylaws $99
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_agreement">
                                                <input type="radio" onchange="agreementChange(event)" id="no_agreement" value="No"
                                                       name="en_agreement"
                                                       class="radio-input"> No, Skip
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Expedited Filing</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="yes_expedited_filing">
                                            <input type="radio" onchange="expeditedChange(event)" id="yes_expedited_filing"
                                                   value="Yes"
                                                   name="expedited_processing"
                                                   class="radio-input" checked> Expedited Processing ($25)
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_skip_e">
                                                <input type="radio" onchange="expeditedChange(event)" id="no_skip_e" value="No"
                                                       name="expedited_processing"
                                                       class="radio-input"> No, I'll wait for the standard Processing
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Payment Method *</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_method"></label>
                                        <input type="text" required name="payment_method" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="right-sidebar">
                        <h4 class="step_caption mb-4 px-3">Order Summary</h4>
                        <p style="color: #959595" class="px-3">Choice & Summary Provided here</p>
                        <div class="d-flex justify-content-between align-items-center px-3">
                            <div>State Filing Fee:</div>
                            <div class="state_filing_fee"> $0.00</div>
                            <input type="hidden" name="state_filing_fee" id="state_filing_fee">
                        </div>

                        <div class="d-flex justify-content-between align-items-center px-3">
                            <div>Business Address Fee:</div>
                            <div class="business_address_fee"> $0.00</div>
                            <input type="hidden" name="business_address_fee" id="business_address_fee">
                        </div>

                        <div class="d-flex justify-content-between align-items-center px-3">
                            <div>EIN Upgrade:</div>
                            <div class="ein_upgrade"> $69.00</div>
                            <input type="hidden" name="ein_upgrade" value="69" id="ein_upgrade">
                        </div>

                        <div class="d-flex justify-content-between align-items-center px-3">
                            <div>Agreements:</div>
                            <div class="agreements"> $99.00</div>
                            <input type="hidden" name="agreements" value="99" id="agreements">
                        </div>

                        <div class="d-flex justify-content-between align-items-center px-3">
                            <div>Rush Processing:</div>
                            <div class="rush_processing"> $25.00</div>
                            <input type="hidden" name="rush_processing" value="25" id="rush_processing">
                        </div>

                        <div class="total_order_amount">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <div>Total Order:</div>
                                <div class="total_order"> $0.00</div>
                                <input type="hidden" name="total_order" id="total_order">
                            </div>
                        </div>

                    </div>

                </div>


                <div class="form-group">
                    <input type="submit" class="btn btn-success">
                </div>


            </form>
        </div>
    </div>



@endsection


@push('js')
    <script>
        let start_fee = 0.00;
        let plan_price = 0.00;
        let selected_plan_name = 'free-plan'
        let numberOfMembership = 1;
        let en_amount = 69;
        let agreement_amount = 99;
        let rush_processing = 25;


        const stateDOM = document.querySelector("#state_name");
        stateDOM.addEventListener('change', function (event) {
            let state_name = event.target.value;
            let selectedOption = event.target.options[event.target.selectedIndex];
            let calculateValue = parseInt(selectedOption.getAttribute("data-calculate"));

            localStorage.setItem('s3_state_name', state_name);

            start_fee = calculateValue;
            $(".state_filing_fee").text("$" + start_fee.toFixed(2))
            $("#state_filing_fee").val(start_fee)
            localStorage.setItem('s3_start_fee', start_fee);

            final_amount_calculation()
        })

        function enAmountChange(event) {
            let en_amount_value = event.target.value;
            if (en_amount_value == 'Yes') {
                en_amount = 69.00;
            } else {
                en_amount = 0.00;
            }
            $(".ein_upgrade").text(`$${en_amount.toFixed(2)}`)
            $("#ein_upgrade").val(en_amount.toFixed(2))

            final_amount_calculation()
            localStorage.setItem('s5_en_amount', en_amount);

        }

        function onChangeNumberOfMembership(event) {
            console.log("yes")
            let ownership_percentage_options = '';
            for (let i = 100; i >= 1; i--) {
                ownership_percentage_options += `<option value="${i}">${i}%</option>`;
            }

            const numberOfOwnership = parseInt(event.target.value);
            numberOfMembership = numberOfOwnership;
            let selectedMemberList = ``;
            for (let i = 1; i <= numberOfOwnership; i++) {
                selectedMemberList += `<div class="row mb-4 owners_info card card-body shadow">
                            <div class="col-12 step_three_owners_info">
                                <div class="row">
                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="name${i}" class="step_label"> Name *</label>
                                        <input type="text" name="name[]" required id="name${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="email${i}" class="step_label"> Email *</label>
                                        <input type="email" name="email[]" required id="email${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="phone${i}" class="step_label"> Phone *</label>
                                        <input type="text" name="phone[]" required id="phone${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="ownership_percentage${i}" class="step_label"> Ownership Percentage *</label>
                                        <select name="ownership_percentage[]" class="form-control step_form_control" required id="ownership_percentage${i}">
                                        ${ownership_percentage_options}
                                        </select>
                                    </div>



                                    <div class="col-12  form-group step_group">
                                        <label for="street_address${i}" class="step_label">Street Address</label>
                                        <input type="text" name="street_address[]"  id="street_address${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="city${i}" class="step_label">City</label>
                                        <input type="text" name="city[]"  id="city${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="state${i}" class="step_label">State</label>
                                        <input type="text" name="state[]"  id="state${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="zip_code${i}" class="step_label">Zip Code</label>
                                        <input type="text" name="zip_code[]"  id="zip_code${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="country${i}" class="step_label">Country</label>
                                        <select name="country[]" id="country${i}" required class="form-control step_form_control">
                                           ${countryListApply()}
                                        </select>
                                    </div>

                                    <div class="col-12  form-group step_group">
                                        <div class="row px-5">
                                            <div class="col-2"><i class="fa-regular fa-lightbulb"></i></div>
                                            <div class="col-10 ">
                                                This address is used for internal purposes only and will not be shared with any third parties or other outside agencies unless provided in any subsequent pages of the order process which require the intake of an address.
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                    </div>`
            }
            let a = document.getElementById("#show_multi_member_info")
            $("#show_multi_member_info").innerHTML = "";
            $("#show_multi_member_info").html(selectedMemberList);
        }

        function planChange(event) {
            let plan = event.target.value;
            let plan_name = event.target.getAttribute("id")
            console.log(plan_name)
            selected_plan_name = plan_name;
            $("#package_name").val(plan_name)
            let free_plan_details = `<ul class="mb-3">
                    <li>Are you sure you can meet this state requirement?</li>
                    <li>You must provide a physical address for your Registered Agent in the state where your business operates (no PO Boxes or PMBs allowed).</li>
                    <li>In some states, this address (registered agent/business address) may appear on public records along with your name, phone number, and email address.</li>
                    <li>If You Don’t Have One, Choose a Monthly/Yearly Package for Registered Agent Address.</li>
                    </ul>
                    <div class="form_of_register_agenet">
                        <h4>Your Registered Agent Address *</h4>
                        <div class="row">
                            <div class="col-12 form-group step_group">
                                <label for="step4_street_address" class="step_label">Street Address *</label>
                                <input type="text" name="street_address" required id="street_address"
                                       class="form-control step_form_control">
                            </div>
                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="step4_city" class="step_label">City *</label>
                                <input type="text" name="step4_city" required id="step4_city"
                                       class="form-control step_form_control">
                            </div>
                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="step4_state" class="step_label">State *</label>
                                <input type="text" name="step4_state" required id="step4_state"
                                       class="form-control step_form_control">
                            </div>
                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="step4_zip_code" class="step_label">Zip Code *</label>
                                <input type="text" name="step4_zip_code" required id="step4_zip_code"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="step4_country" class="step_label">Country</label>
                                <select name="step4_country" id="step4_country" class="form-control step_form_control">
                                   ${countryListApply()}
                                </select>
                            </div>
                            <div class="col-12">
                                <p style="font-weight: bold">Note: Must be a valid and USA Registered Agent Address.</p>
                            </div>
                        </div>
                    </div>`
            if (plan_name == 'free-plan') {
                plan_price = 0.00;
                $("#free_plan_form").html(free_plan_details);
            } else if (plan_name == 'monthly-plan') {
                plan_price = 25.00;
                $("#free_plan_form").html('');
            } else if (plan_name == 'yearly-plan') {
                plan_price = 259.00;
                $("#free_plan_form").html('');
            }
            let step_four_data = {
                plan_name: plan_name,
                plan_price: plan_price,
            }
            $(".business_address_fee").text(`$${plan_price.toFixed(2)}`)
            $("#business_address_fee").val(plan_price.toFixed(2))

            // final_amount_calculation()
        }

        function expeditedChange(event) {
            let rush_processing_value = event.target.value;
            if (rush_processing_value == 'Yes') {
                rush_processing = 25.00;
            } else if (rush_processing_value == 'No') {
                rush_processing = 0.00;
            }
            console.log(rush_processing_value)
            console.log(rush_processing)
            $(".rush_processing").text(`$${rush_processing.toFixed(2)}`)
            $("#rush_processing").val(rush_processing.toFixed(2))

            final_amount_calculation()

        }

        function agreementChange(event) {
            let agreement_amount_value = event.target.value;
            if (agreement_amount_value == 'Yes') {
                agreement_amount = 99.00;
            } else {
                agreement_amount = 0.00;
            }
            $(".agreements").text(`$${agreement_amount.toFixed(2)}`)
            $("#agreements").val(agreement_amount.toFixed(2))

            final_amount_calculation()

        }


        $(document).ready(function () {
            // sendDataToBackend();
            $(".country_list").html(countryListApply());
        });

        function final_amount_calculation() {
            total_amount_generate = start_fee + plan_price + en_amount + agreement_amount + rush_processing;
            console.log(total_amount_generate)
            let total_amount = parseInt(total_amount_generate);
            $(".total_order").text(`$${total_amount.toFixed(2)}`)
            $("#total_order").val(total_amount)

            $(".final_amount").text(`$${total_amount.toFixed(2)}`)
            localStorage.setItem("final_amount", total_amount)
        }

        final_amount_calculation()

        function countryListApply() {
            let countryArray = [
                {name: 'Afghanistan', code: 'AF'},
                {name: 'Åland Islands', code: 'AX'},
                {name: 'Albania', code: 'AL'},
                {name: 'Algeria', code: 'DZ'},
                {name: 'American Samoa', code: 'AS'},
                {name: 'AndorrA', code: 'AD'},
                {name: 'Angola', code: 'AO'},
                {name: 'Anguilla', code: 'AI'},
                {name: 'Antarctica', code: 'AQ'},
                {name: 'Antigua and Barbuda', code: 'AG'},
                {name: 'Argentina', code: 'AR'},
                {name: 'Armenia', code: 'AM'},
                {name: 'Aruba', code: 'AW'},
                {name: 'Australia', code: 'AU'},
                {name: 'Austria', code: 'AT'},
                {name: 'Azerbaijan', code: 'AZ'},
                {name: 'Bahamas', code: 'BS'},
                {name: 'Bahrain', code: 'BH'},
                {name: 'Bangladesh', code: 'BD'},
                {name: 'Barbados', code: 'BB'},
                {name: 'Belarus', code: 'BY'},
                {name: 'Belgium', code: 'BE'},
                {name: 'Belize', code: 'BZ'},
                {name: 'Benin', code: 'BJ'},
                {name: 'Bermuda', code: 'BM'},
                {name: 'Bhutan', code: 'BT'},
                {name: 'Bolivia', code: 'BO'},
                {name: 'Bosnia and Herzegovina', code: 'BA'},
                {name: 'Botswana', code: 'BW'},
                {name: 'Bouvet Island', code: 'BV'},
                {name: 'Brazil', code: 'BR'},
                {name: 'British Indian Ocean Territory', code: 'IO'},
                {name: 'Brunei Darussalam', code: 'BN'},
                {name: 'Bulgaria', code: 'BG'},
                {name: 'Burkina Faso', code: 'BF'},
                {name: 'Burundi', code: 'BI'},
                {name: 'Cambodia', code: 'KH'},
                {name: 'Cameroon', code: 'CM'},
                {name: 'Canada', code: 'CA'},
                {name: 'Cape Verde', code: 'CV'},
                {name: 'Cayman Islands', code: 'KY'},
                {name: 'Central African Republic', code: 'CF'},
                {name: 'Chad', code: 'TD'},
                {name: 'Chile', code: 'CL'},
                {name: 'China', code: 'CN'},
                {name: 'Christmas Island', code: 'CX'},
                {name: 'Cocos (Keeling) Islands', code: 'CC'},
                {name: 'Colombia', code: 'CO'},
                {name: 'Comoros', code: 'KM'},
                {name: 'Congo', code: 'CG'},
                {name: 'Congo, The Democratic Republic of the', code: 'CD'},
                {name: 'Cook Islands', code: 'CK'},
                {name: 'Costa Rica', code: 'CR'},
                {name: 'Cote D\'Ivoire', code: 'CI'},
                {name: 'Croatia', code: 'HR'},
                {name: 'Cuba', code: 'CU'},
                {name: 'Cyprus', code: 'CY'},
                {name: 'Czech Republic', code: 'CZ'},
                {name: 'Denmark', code: 'DK'},
                {name: 'Djibouti', code: 'DJ'},
                {name: 'Dominica', code: 'DM'},
                {name: 'Dominican Republic', code: 'DO'},
                {name: 'Ecuador', code: 'EC'},
                {name: 'Egypt', code: 'EG'},
                {name: 'El Salvador', code: 'SV'},
                {name: 'Equatorial Guinea', code: 'GQ'},
                {name: 'Eritrea', code: 'ER'},
                {name: 'Estonia', code: 'EE'},
                {name: 'Ethiopia', code: 'ET'},
                {name: 'Falkland Islands (Malvinas)', code: 'FK'},
                {name: 'Faroe Islands', code: 'FO'},
                {name: 'Fiji', code: 'FJ'},
                {name: 'Finland', code: 'FI'},
                {name: 'France', code: 'FR'},
                {name: 'French Guiana', code: 'GF'},
                {name: 'French Polynesia', code: 'PF'},
                {name: 'French Southern Territories', code: 'TF'},
                {name: 'Gabon', code: 'GA'},
                {name: 'Gambia', code: 'GM'},
                {name: 'Georgia', code: 'GE'},
                {name: 'Germany', code: 'DE'},
                {name: 'Ghana', code: 'GH'},
                {name: 'Gibraltar', code: 'GI'},
                {name: 'Greece', code: 'GR'},
                {name: 'Greenland', code: 'GL'},
                {name: 'Grenada', code: 'GD'},
                {name: 'Guadeloupe', code: 'GP'},
                {name: 'Guam', code: 'GU'},
                {name: 'Guatemala', code: 'GT'},
                {name: 'Guernsey', code: 'GG'},
                {name: 'Guinea', code: 'GN'},
                {name: 'Guinea-Bissau', code: 'GW'},
                {name: 'Guyana', code: 'GY'},
                {name: 'Haiti', code: 'HT'},
                {name: 'Heard Island and Mcdonald Islands', code: 'HM'},
                {name: 'Holy See (Vatican City State)', code: 'VA'},
                {name: 'Honduras', code: 'HN'},
                {name: 'Hong Kong', code: 'HK'},
                {name: 'Hungary', code: 'HU'},
                {name: 'Iceland', code: 'IS'},
                {name: 'India', code: 'IN'},
                {name: 'Indonesia', code: 'ID'},
                {name: 'Iran, Islamic Republic Of', code: 'IR'},
                {name: 'Iraq', code: 'IQ'},
                {name: 'Ireland', code: 'IE'},
                {name: 'Isle of Man', code: 'IM'},
                {name: 'Israel', code: 'IL'},
                {name: 'Italy', code: 'IT'},
                {name: 'Jamaica', code: 'JM'},
                {name: 'Japan', code: 'JP'},
                {name: 'Jersey', code: 'JE'},
                {name: 'Jordan', code: 'JO'},
                {name: 'Kazakhstan', code: 'KZ'},
                {name: 'Kenya', code: 'KE'},
                {name: 'Kiribati', code: 'KI'},
                {name: 'Korea, Democratic People\'S Republic of', code: 'KP'},
                {name: 'Korea, Republic of', code: 'KR'},
                {name: 'Kuwait', code: 'KW'},
                {name: 'Kyrgyzstan', code: 'KG'},
                {name: 'Lao People\'S Democratic Republic', code: 'LA'},
                {name: 'Latvia', code: 'LV'},
                {name: 'Lebanon', code: 'LB'},
                {name: 'Lesotho', code: 'LS'},
                {name: 'Liberia', code: 'LR'},
                {name: 'Libyan Arab Jamahiriya', code: 'LY'},
                {name: 'Liechtenstein', code: 'LI'},
                {name: 'Lithuania', code: 'LT'},
                {name: 'Luxembourg', code: 'LU'},
                {name: 'Macao', code: 'MO'},
                {name: 'Macedonia, The Former Yugoslav Republic of', code: 'MK'},
                {name: 'Madagascar', code: 'MG'},
                {name: 'Malawi', code: 'MW'},
                {name: 'Malaysia', code: 'MY'},
                {name: 'Maldives', code: 'MV'},
                {name: 'Mali', code: 'ML'},
                {name: 'Malta', code: 'MT'},
                {name: 'Marshall Islands', code: 'MH'},
                {name: 'Martinique', code: 'MQ'},
                {name: 'Mauritania', code: 'MR'},
                {name: 'Mauritius', code: 'MU'},
                {name: 'Mayotte', code: 'YT'},
                {name: 'Mexico', code: 'MX'},
                {name: 'Micronesia, Federated States of', code: 'FM'},
                {name: 'Moldova, Republic of', code: 'MD'},
                {name: 'Monaco', code: 'MC'},
                {name: 'Mongolia', code: 'MN'},
                {name: 'Montserrat', code: 'MS'},
                {name: 'Morocco', code: 'MA'},
                {name: 'Mozambique', code: 'MZ'},
                {name: 'Myanmar', code: 'MM'},
                {name: 'Namibia', code: 'NA'},
                {name: 'Nauru', code: 'NR'},
                {name: 'Nepal', code: 'NP'},
                {name: 'Netherlands', code: 'NL'},
                {name: 'Netherlands Antilles', code: 'AN'},
                {name: 'New Caledonia', code: 'NC'},
                {name: 'New Zealand', code: 'NZ'},
                {name: 'Nicaragua', code: 'NI'},
                {name: 'Niger', code: 'NE'},
                {name: 'Nigeria', code: 'NG'},
                {name: 'Niue', code: 'NU'},
                {name: 'Norfolk Island', code: 'NF'},
                {name: 'Northern Mariana Islands', code: 'MP'},
                {name: 'Norway', code: 'NO'},
                {name: 'Oman', code: 'OM'},
                {name: 'Pakistan', code: 'PK'},
                {name: 'Palau', code: 'PW'},
                {name: 'Palestinian Territory, Occupied', code: 'PS'},
                {name: 'Panama', code: 'PA'},
                {name: 'Papua New Guinea', code: 'PG'},
                {name: 'Paraguay', code: 'PY'},
                {name: 'Peru', code: 'PE'},
                {name: 'Philippines', code: 'PH'},
                {name: 'Pitcairn', code: 'PN'},
                {name: 'Poland', code: 'PL'},
                {name: 'Portugal', code: 'PT'},
                {name: 'Puerto Rico', code: 'PR'},
                {name: 'Qatar', code: 'QA'},
                {name: 'Reunion', code: 'RE'},
                {name: 'Romania', code: 'RO'},
                {name: 'Russian Federation', code: 'RU'},
                {name: 'RWANDA', code: 'RW'},
                {name: 'Saint Helena', code: 'SH'},
                {name: 'Saint Kitts and Nevis', code: 'KN'},
                {name: 'Saint Lucia', code: 'LC'},
                {name: 'Saint Pierre and Miquelon', code: 'PM'},
                {name: 'Saint Vincent and the Grenadines', code: 'VC'},
                {name: 'Samoa', code: 'WS'},
                {name: 'San Marino', code: 'SM'},
                {name: 'Sao Tome and Principe', code: 'ST'},
                {name: 'Saudi Arabia', code: 'SA'},
                {name: 'Senegal', code: 'SN'},
                {name: 'Serbia and Montenegro', code: 'CS'},
                {name: 'Seychelles', code: 'SC'},
                {name: 'Sierra Leone', code: 'SL'},
                {name: 'Singapore', code: 'SG'},
                {name: 'Slovakia', code: 'SK'},
                {name: 'Slovenia', code: 'SI'},
                {name: 'Solomon Islands', code: 'SB'},
                {name: 'Somalia', code: 'SO'},
                {name: 'South Africa', code: 'ZA'},
                {name: 'South Georgia and the South Sandwich Islands', code: 'GS'},
                {name: 'Spain', code: 'ES'},
                {name: 'Sri Lanka', code: 'LK'},
                {name: 'Sudan', code: 'SD'},
                {name: 'Suriname', code: 'SR'},
                {name: 'Svalbard and Jan Mayen', code: 'SJ'},
                {name: 'Swaziland', code: 'SZ'},
                {name: 'Sweden', code: 'SE'},
                {name: 'Switzerland', code: 'CH'},
                {name: 'Syrian Arab Republic', code: 'SY'},
                {name: 'Taiwan, Province of China', code: 'TW'},
                {name: 'Tajikistan', code: 'TJ'},
                {name: 'Tanzania, United Republic of', code: 'TZ'},
                {name: 'Thailand', code: 'TH'},
                {name: 'Timor-Leste', code: 'TL'},
                {name: 'Togo', code: 'TG'},
                {name: 'Tokelau', code: 'TK'},
                {name: 'Tonga', code: 'TO'},
                {name: 'Trinidad and Tobago', code: 'TT'},
                {name: 'Tunisia', code: 'TN'},
                {name: 'Turkey', code: 'TR'},
                {name: 'Turkmenistan', code: 'TM'},
                {name: 'Turks and Caicos Islands', code: 'TC'},
                {name: 'Tuvalu', code: 'TV'},
                {name: 'Uganda', code: 'UG'},
                {name: 'Ukraine', code: 'UA'},
                {name: 'United Arab Emirates', code: 'AE'},
                {name: 'United Kingdom', code: 'GB'},
                {name: 'United States', code: 'US'},
                {name: 'United States Minor Outlying Islands', code: 'UM'},
                {name: 'Uruguay', code: 'UY'},
                {name: 'Uzbekistan', code: 'UZ'},
                {name: 'Vanuatu', code: 'VU'},
                {name: 'Venezuela', code: 'VE'},
                {name: 'Viet Nam', code: 'VN'},
                {name: 'Virgin Islands, British', code: 'VG'},
                {name: 'Virgin Islands, U.S.', code: 'VI'},
                {name: 'Wallis and Futuna', code: 'WF'},
                {name: 'Western Sahara', code: 'EH'},
                {name: 'Yemen', code: 'YE'},
                {name: 'Zambia', code: 'ZM'},
                {name: 'Zimbabwe', code: 'ZW'}
            ];
            // let countrylist = document.querySelector(".country_list")

            let countrylist = '';
            countryArray.map((item) => {
                countrylist += `<option ${item.code === 'US' ? 'selected' : ''} value="${item.name}">${item.name}</option>`;
                // let option = document.createElement("option");
                // option.text = item.name;
                // option.value = item.name;
            })
            return countrylist;

            // $(".country_list").html(countrylist);
        }
    </script>
@endpush
