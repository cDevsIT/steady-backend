{{--    ============================= Step Five: EIN (Employer Identification Number) * ============= Figma : Funnel 4 =========================--}}
<div id="step6" class="step mt-4" style="display: none">
    <div class="row mb-5">
        <div class="col-12 col-md-8">
            <h4>EIN (Employer Identification Number)</h4>
            <p>An EIN is a nine-digit number the IRS assigns to identify a business entity for tax purposes.</p>
            <ul class="px-5">
                <li>Required for filing business taxes.</li>
                <li>Essential for opening bank accounts.</li>
                <li>Necessary to hire and pay employees.</li>
                <li>Helps establish a business credit history.</li>
                <li>Ensures compliance with IRS regulations.</li>
            </ul>
            <div class="step_5_note">
                *Note 1: EIN delivery time is typically 10-25 days, but it can extend to 30-120 days during the
                IRS's taxation season. Our Expedited service ensures EIN form submission within 1-3 days, with
                issuance dependent on the IRS. We will provide continuous updates.
            </div>
            <div class="step_5_note">
                *Note 2: Without an EIN, a company risks IRS penalties, banking and payroll issues, potentially
                facing fines and operational disruptions.
            </div>

            <div class="py-4">
                <div class="radio-option mb-4">
                    <input type="radio" onchange="enAmountChange(event)" id="add_en" name="en_amount"
                           class="radio-input">
                    <label for="add_en" class="radio-label">Add an EIN to Only $69</label>
                </div>

                <div class="radio-option">
                    <input type="radio" id="no_skip" onchange="enAmountChange(event)" name="en_amount"
                           class="radio-input" checked>
                    <label for="no_skip" class="radio-label">No, Skip</label>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            @include('web.part.sticky-sidebar')
        </div>
    </div>
    <div class="text-center pb-4" style="text-align: center">
        <button onclick="prevStep(event,6,'step_6')" class="btn btn-next "><i
                class="fa-solid fa-chevron-left"></i>
            Back
        </button>
        <button onclick="nextStep(event,6,'step_6')" class="btn btn-next ">Next <i
                class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>
