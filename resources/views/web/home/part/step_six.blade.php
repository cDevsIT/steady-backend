
{{--    ============================= Step Six:Operating Agreement / Corporate Bylaws * ============= Figma : Funnel 5 =========================--}}

<div id="step7" class="step" style="display: none">
    <div class="row mb-5">
        <div class="col-12 col-md-8">
            <h4>Operating Agreement / Corporate Bylaws</h4>
            <p>An operating agreement (for LLC) or Corporate By-Laws (for Incorporation) is a legal document
                outlining the ownership and operating procedures of a company among its members. </p>
            <ul class="px-5">
                <li>Defines business structure and member roles.</li>
                <li>Clarifies financial and management decisions.</li>
                <li>Prevents misunderstandings among members.</li>
                <li>Enhances business credibility and professionalism.</li>
            </ul>
            <div class="step_5_note">
                *Note: If you choose our Expedited service, the agreement and company formation will be
                processed
                within 1-3 days.
            </div>


            <p>Operating Agreement *</p>

            <div class="py-4">
                <div class="radio-option mb-4">
                    <input type="radio" onchange="agreementChange(event)" id="add_agreement"
                           name="en_agreement_amount" class="radio-input" >
                    <label for="add_agreement" class="radio-label">Operating Agreement / Bylaws $99</label>
                </div>

                <div class="radio-option">
                    <input type="radio" id="no_skip_step_6" onchange="agreementChange(event)"
                           name="en_agreement_amount" class="radio-input" checked>
                    <label for="no_skip_step_6" class="radio-label">No, Skip</label>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            @include('web.part.sticky-sidebar')
        </div>
    </div>
    <div class="text-right pb-4" style="text-align: center">
        <button onclick="prevStep(event,7,'step_7')" class="btn btn-next "><i
                class="fa-solid fa-chevron-left"></i>
            Back
        </button>
        <button onclick="nextStep(event,7,'step_7')" class="btn btn-next ">Next <i
                class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>
