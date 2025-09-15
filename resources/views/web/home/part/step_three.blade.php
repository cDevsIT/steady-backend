
{{--    ============================= Step Three: Business info ============= Figma : Funnel 02 =========================--}}
<div id="step3" class="step mt-4" style="display: none">

    <div class="row mb-5">
        <div class="col-12 col-md-8">
            <h4 class="step_caption mb-4">Business Info</h4>
            <div class="row">
                <div class="col-12 form-group step_group">
                    <label for="propose_business_name" class="step_label">Proposed Business Name *</label>
                    <div class="input-group mb-3" style="border-radius: 20px">
                        <input type="text"  autocomplete="off" name="propose_business_name" readonly id="propose_business_name"
                               class="form-control step_form_control" style="border-right: 1px solid #FF5700;">
                        <span class="input-group-text step_input_group_text" id="basic-addon2">
                                <select name="business_type" style="background: #FF5700; color: #fff" onchange="changeBusinessType(event)" class="form-control step_form_control" required id="business_type">
                                    <option value="">Select One</option>
                                    <option selected value="LLC">LLC</option>
                                    <option value="Corporation">Corporation</option>
                                    <option value="Partnership">Partnership</option>
                                    <option value="Non-Profit">Non-Profit</option>
                                </select>
                            </span>
                    </div>
                    <div class="business_type_error"></div>
                    <p style="font-size: 13px">*The entered name will be validated later. You Don’t have to add
                        “LLC,” “Inc.” “Corp” etc. in this box. If your chosen name is unavailable, together
                        we'll
                        work on an alternative.</p>
                    <p style="font-size: 13px">The 3 entities we provide <a href="#see_less" style="color: #FF5700">see
                            more</a></p>
                </div>
                <div class="col-12 form-group step_group" id="businessTypeOptions">
                    <label for="llc_type">LLC Type <span class="text-danger">*</span></label>
                    <select name="llc_type" class="form-control step_form_control" id="llc_type" required="">
                        <option value="">Select One</option>
                        <option selected value="Single Member LLC">Single Member LLC</option>
                        <option value="Multi-member LLC">Multi-member LLC</option>
                        <option value="S Corp (Owners must be U.S Resident)">S Corp (Owners must be U.S Resident)
                        </option>
                    </select>
                    
{{--                    <label for="llc_type">LLC Type <span class="text-danger">*</span></label>--}}
{{--                    <select name="llc_type"  class="form-control step_form_control" required id="llc_type">--}}
{{--                        <option value="">Select One</option>--}}
{{--                        <option selected value="Single Member LLC">Single Member LLC</option>--}}
{{--                        <option value="Multi-member LLC">Multi-member LLC</option>--}}
{{--                        <option value="S Corp (Owners must be U.S Resident)">S Corp (Owners must be U.S Resident)</option>--}}
{{--                    </select>--}}

{{--                    <label for="corporation_type">Corporation Type <span class="text-danger">*</span></label>--}}
{{--                    <select name="corporation_type"  class="form-control step_form_control" required id="corporation_type">--}}
{{--                        <option value="">Select One</option>--}}
{{--                        <option value="C Corporation">C Corporation</option>--}}
{{--                        <option value="S Corporation (Owners must be U.S Resident)">S Corporation (Owners must be U.S Resident)</option>--}}
{{--                    </select>--}}
                </div>

                <div class="col-12 col-md-6 form-group step_group">
                    <label for="state_name" class="step_label">State Name *</label>
                    <select name="state_name" id="state_name" class="form-control step_form_control">
{{--                        <option value="">Choose State Name</option>--}}
{{--                        <option value="Alabama" data-calculate="200">Alabama</option>--}}
{{--                        <option value="Alaska" data-calculate="250">Alaska</option>--}}
{{--                        <option value="Arizona" data-calculate="50">Arizona</option>--}}
{{--                        <option value="Arkansas" data-calculate="45">Arkansas</option>--}}
{{--                        <option value="California" data-calculate="70">California</option>--}}
{{--                        <option value="Colorado" data-calculate="50">Colorado</option>--}}
{{--                        <option value="Connecticut" data-calculate="50">Connecticut</option>--}}
{{--                        <option value="Delaware" data-calculate="90">Delaware</option>--}}
{{--                        <option value="Florida" selected data-calculate="100">Florida</option>--}}
{{--                        <option value="Georgia" data-calculate="100">Georgia</option>--}}
{{--                        <option value="Hawaii" data-calculate="50">Hawaii</option>--}}
{{--                        <option value="Idaho" data-calculate="100">Idaho</option>--}}
{{--                        <option value="Illinois" data-calculate="150">Illinois</option>--}}
{{--                        <option value="Indiana" data-calculate="100">Indiana</option>--}}
{{--                        <option value="Iowa" data-calculate="50">Iowa</option>--}}
{{--                        <option value="Kansas" data-calculate="160">Kansas</option>--}}
{{--                        <option value="Kentucky" data-calculate="40">Kentucky</option>--}}
{{--                        <option value="Louisiana" data-calculate="100">Louisiana</option>--}}
{{--                        <option value="Maine" data-calculate="175">Maine</option>--}}
{{--                        <option value="Maryland" data-calculate="100">Maryland</option>--}}
{{--                        <option value="Massachusetts" data-calculate="500">Massachusetts</option>--}}
{{--                        <option value="Michigan" data-calculate="50">Michigan</option>--}}
{{--                        <option value="Minnesota" data-calculate="155">Minnesota</option>--}}
{{--                        <option value="Mississippi" data-calculate="50">Mississippi</option>--}}
{{--                        <option value="Missouri" data-calculate="50">Missouri</option>--}}
{{--                        <option value="Montana" data-calculate="35">Montana</option>--}}
{{--                        <option value="Nebraska" data-calculate="100">Nebraska</option>--}}
{{--                        <option value="Nevada" data-calculate="75">Nevada</option>--}}
{{--                        <option value="New Hampshire" data-calculate="100">New Hampshire</option>--}}
{{--                        <option value="New Jersey" data-calculate="125">New Jersey</option>--}}
{{--                        <option value="New Mexico" data-calculate="50">New Mexico</option>--}}
{{--                        <option value="New York" data-calculate="200">New York</option>--}}
{{--                        <option value="North Carolina" data-calculate="125">North Carolina</option>--}}
{{--                        <option value="North Dakota" data-calculate="135">North Dakota</option>--}}
{{--                        <option value="Ohio" data-calculate="99">Ohio</option>--}}
{{--                        <option value="Oklahoma" data-calculate="100">Oklahoma</option>--}}
{{--                        <option value="Oregon" data-calculate="100">Oregon</option>--}}
{{--                        <option value="Pennsylvania" data-calculate="125">Pennsylvania</option>--}}
{{--                        <option value="Rhode Island" data-calculate="150">Rhode Island</option>--}}
{{--                        <option value="South Carolina" data-calculate="110">South Carolina</option>--}}
{{--                        <option value="South Dakota" data-calculate="150">South Dakota</option>--}}
{{--                        <option value="Tennessee" data-calculate="300">Tennessee</option>--}}
{{--                        <option value="Texas" data-calculate="300">Texas</option>--}}
{{--                        <option value="Utah" data-calculate="54">Utah</option>--}}
{{--                        <option value="Vermont" data-calculate="125">Vermont</option>--}}
{{--                        <option value="Virginia" data-calculate="100">Virginia</option>--}}
{{--                        <option value="Washington" data-calculate="180">Washington</option>--}}
{{--                        <option value="Washington DC" data-calculate="99">Washington DC</option>--}}
{{--                        <option value="Wisconsin" data-calculate="170">Wisconsin</option>--}}
{{--                        <option value="Wyoming" data-calculate="100">Wyoming</option>--}}
                    </select>
                    {{--                        <input type="text"  autocomplete="off" name="state_name" required id="state_name"--}}
                    {{--                               class="form-control step_form_control">--}}
                </div>

                <div class="col-12 col-md-6 form-group step_group">
                    <label for="type_of_industry" class="step_label">Type of Industry *</label>

                    <select name="type_of_industry" onchange="changeTypeOfIndustry(event)" class="form-control step_form_control" required id="type_of_industry">
                        <option value="">Select a Option</option>
                        <option value="ECommerce">ECommerce</option>
                        <option value="Digital Marketing">Digital Marketing</option>
                        <option value="IT Services">IT Services</option>
                        <option value="SAAS">SAAS</option>
                        <option value="Health">Health</option>
                        <option value="B2B Software">B2B Software</option>
                        <option value="B2C">B2C</option>
                        <option value="Other">Other</option>
                    </select>
{{--                    <input type="text"  autocomplete="off" name="type_of_industry" required id="type_of_industry"--}}
{{--                           class="form-control step_form_control">--}}
                </div>
                <div class="col-12 form-group step_group" id="other_type_of_industry">
{{--                    <label for="other_type_of"> Other Type Of Industry</label>--}}
{{--                    <input type="text"  autocomplete="off" required id="other_type_of" name="other_type_of_industry" class="form-control step_form_control">--}}
                </div>

                <div class="col-12  form-group step_group">
                    <label for="number_of_ownership" class="step_label">No. of <span id="directorOrOwner">Ownership</span> *</label>
                    <select name="number_of_ownership" onchange="onChangeNumberOfMembership(event)"
                            id="number_of_ownership" class="form_control step_form_control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>

            </div>
            <div id="show_multi_member_info">
                <div class="row mb-4 owners_info">
                    <p class="mb-5"><span class="directorOrOwner">Owner</span> info *</p>
                    <div class="col-12 step_three_owners_info">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="name" class="step_label"> Name *</label>
                                <input type="text"  autocomplete="off" name="name[1]" required id="name1"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="email" class="step_label"> Email *</label>
                                <input type="email" name="email[1]" required id="email1"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="phone" class="step_label"> Phone *</label>
                                <input type="text"  autocomplete="off" name="phone[1]" required id="phone1"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="ownership_percentage" class="step_label"> Ownership
                                    Percentage *</label>
                                <select name="ownership_percentage[1]" required
                                        class="form-control step_form_control single_percent" id="ownership_percentage1">
                                    @for ($value = 100; $value >= 1; $value--)
                                        <option value="{{ $value }}">{{ $value }}%</option>
                                    @endfor
                                </select>
                            </div>


                            <div class="col-12  form-group step_group">
                                <label for="street_address" class="step_label">Street Address</label>
                                <input type="text"  autocomplete="off" name="street_address[1]" id="street_address1"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="city" class="step_label">City</label>
                                <input type="text"  autocomplete="off" name="city[1]" id="city1"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="state" class="step_label">State</label>
                                <div class="stateField">
                                    <input type="text"  autocomplete="off" name="state[1]" id="state1"
                                           class="form-control step_form_control stateList">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="zip_code" class="step_label">Zip Code</label>
                                <input type="text"  autocomplete="off" name="zip_code[1]" id="zip_code1"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="country" class="step_label">Country</label>
                                <select name="country[1]" id="country1" required
                                        class="form-control country_list countryListAll step_form_control">

                                </select>
                            </div>

                            <div class="col-12  form-group step_group">
                                <div class="row px-5">
                                    <div class="col-12 ">

                                        <i class="fa-regular fa-lightbulb"></i> &nbsp;

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

        </div>
        <div class="col-12 col-md-4">
            @include('web.part.sticky-sidebar')
        </div>
    </div>
    <div class="text-center">
        <div class="step3Errors mb-3">

        </div>
        
        <button onclick="prevStep(event,3,'step_3')" class="btn btn-next "><i
                class="fa-solid fa-chevron-left"></i>
            Back
        </button>
        <button onclick="nextStep(event,3,'step_3')" class="btn btn-next ">Next <i
                class="fa-solid fa-chevron-right"></i></button>
    </div>

    <div class="business_info text-center mt-4" id="see_less">
        <h5>Business Info</h5>
        <h4 style="color: #FF5700">Company Structure Wisely</h4>
        <p style="font-size: 16px">
            Decide which company structure is perfect for your business. Different entities are best for
            different
            business goals.
        </p>
    </div>
    <div class=" business_details_items mb-4">
        <div class="business_item">
            <h5>LLC</h5>
            <p>
                Choose an LLC for the ultimate flexibility and protection of your personal assets—streamline
                your
                business structure effortlessly.
            </p>
            <ul>
                <li>Unlimited membership opportunities</li>
                <li>Board of Directors not required</li>
                <li>Personal asset protection from business liabilities</li>
                <li>Pass-through taxation; profits taxed once at the owner level</li>
                <li>Can elect (S Corp, Partnership, Disregarded entity, C Corp, etc.) how it wants to be taxed
                </li>
                <li>Perpetual Existence</li>
                <li>Can’t go Public</li>
            </ul>
        </div>
        <div class="business_item">
            <h5>S Corp</h5>
            <p>Well known for tax benefits and operational flexibility, maintaining your business’s growth
                momentum
                while enjoying certain corporate structures without double taxation.</p>
            <ul>
                <li>Limited to 100 Shareholders</li>
                <li>Functions with LLC flexibility while offering corporate tax benefits.</li>
                <li>Like LLCs, profits and losses pass directly to the owner’s personal taxes.</li>
                <li>Profits are taxed only at the shareholder level, not at the corporate level.</li>
                <li>personal tax reductions under S-corp filing status.</li>
                <li>Capable of attracting investors through the issuance of stock.</li>
                <li>Only for SSN holders</li>
            </ul>
        </div>
        <div class="business_item">
            <h5>C Corp</h5>
            <p>Offers advanced business growth and funding opportunities, ensures strong legal separation
                between
                company and personal assets, and simplifies access to investment capital.</p>
            <ul>
                <li>Unlimited Ownership</li>
                <li>Ability to Issue Shares</li>
                <li>Access to Preferred Stock</li>
                <li>Ideal for Equity Financing</li>
                <li>Limited Personal Liability</li>
                <li>Double Taxation; Corporate and Shareholder Levels</li>
            </ul>
        </div>
    </div>

    <div class="text-center">
        <button onclick="backToTopBtn()" id="backToTopBtn" class="btn btn-next" title="Go to top">Back to Top <i class="fas fa-arrow-up"></i></button>
    </div>
</div>
