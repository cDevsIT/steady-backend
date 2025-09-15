
{{--    ============================= Step Seven:Expedited Filing * ============= Figma : Funnel 6 =========================--}}
<div id="step8" class="step" style="display: none">
    <div class="row mb-5">
        <div class="col-12 col-md-8">
            <h4>Expedited Filing</h4>
            <p>Get the fastest filing with our Expedited Filing service when you need it urgently. Standard
                processing may require more days or weeks. </p>
            <p>Jumpstart your business with our Expedited Filing! Get legal fast, skip the wait, and dive into
                the
                market. Quick, easy, and ready for success. Let's go! </p>
            <div class="step_5_note">
                *Note: Expedited filing service includes company formation, operating agreement, and registered
                agent within 1-3 business days. EIN form submission will be done within this timeframe;
                processing
                depends on the IRS. 
            </div>

            <p>Expedited Filing *</p>

            <div class="py-4">
                <div class="processing_card-container">
                    <div class="processing_card_item">
                        <input type="radio" id="add_expedited_processing" class="add_expedited_processing"
                               onchange="expeditedChange(event)" name="expedited_processing" >
                        <label for="add_expedited_processing" class="card-content">
                            <div class="radio-circle"></div>
                            <span class="d-flex justify-content-between">
                                    <h3>Expedited Processing</h3>
                                    <h3>$25</h3>
                                </span>
                            <ul class="features">
                                <li>1-3 business days</li>
                                <li>Company formation only</li>
                            </ul>
                            <p><strong>Note: </strong>Service Provider Expedited Service. State level Expedited service is not included here.
                            </p>
                        </label>
                    </div>
                    <div class="processing_card_item active">
                        <input type="radio" id="no_expedited_processing" class="no_expedited_processing"
                               onchange="expeditedChange(event)" name="expedited_processing" checked>
                        <label for="no_expedited_processing" class="card-content ">
                            <div class="radio-circle"></div>
                            <span class="d-flex justify-content-between">
                                    <h3>No, I'll wait for the standard Processing</h3>
                                </span>
                            <ul class="features">
                                <li>1-15 business days</li>
                            </ul>
                        </label>
                    </div>

                </div>

                <p class="mt-3">
                    *The processing times will be determined based on the current state turnaround times and are
                    subject to change based on state processing.
                </p>

            </div>
        </div>

        <div class="col-12 col-md-4">
            @include('web.part.sticky-sidebar')
        </div>
    </div>
    <div class="text-right pb-4" style="text-align: center">
        <button onclick="prevStep(event,8,'step_8')" class="btn btn-next "><i
                class="fa-solid fa-chevron-left"></i>
            Back
        </button>
        <button onclick="nextStep(event,8,'step_8')" class="btn btn-next ">Next <i
                class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>
