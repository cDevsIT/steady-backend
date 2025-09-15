{{--    ============================= Step Two: Primary Contact ============= Figma : Funnel =========================--}}
<div id="step2" class="step mt-4" style="display: none">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="step_caption mb-4">Primary Contact</h4>
            <div class="row">
                <div class="col-12 col-md-6 form-group step_group">
                    <label for="first_name" class="step_label">First Name *</label>
                    <input type="text"
                           {{auth()->check() ? 'readonly' : ''}} value="{{auth()->check() ? auth()->user()->first_name : ''}}"
                           name="first_name" required id="first_name"
                           class="form-control step_form_control">
                </div>
                <div class="col-12 col-md-6 form-group step_group">
                    <label for="last_name" class="step_label">Last Name *</label>
                    <input type="text"
                           {{auth()->check() ? 'readonly' : ''}} value="{{auth()->check() ? auth()->user()->last_name : ''}}"
                           name="last_name" required id="last_name"
                           class="form-control step_form_control">
                </div>
                <div class="col-12 col-md-6 form-group step_group">
                    <label for="email" class="step_label">Email *</label>
                    <input type="email" name="email"
                           {{auth()->check() ? 'readonly' : ''}} value="{{auth()->check() ? auth()->user()->email : ''}}"
                           required id="email" data-route="{{route("help.emailCheck")}}"
                           oninput="validateEmailAjax(event)" class="form-control step_form_control">
                    <span class="text-danger emailError"></span>
                </div>
                <div class="col-12 col-md-6 form-group step_group">
                    <label for="email" class="step_label">Phone Number *</label>

                        <input type="text" class="form-control form-control-lg input-field step_form_control"
                               name="phone_number"
                               isAuthenticated="{{auth()->check() ? 'Yes' : 'No'}}"
                               style="width:100%!important;"
                               {{auth()->check() ? 'readonly' : ''}} value="{{auth()->check() ? auth()->user()->phone : ''}}"
                               id="phone_number">

                    <input type="hidden" name="calling_code" id="calling_code">
                    <input type="hidden" name="country" id="country">
                    <input type="hidden" name="number" id="mobile_number">
                </div>
            </div>
        </div>

    </div>
    <div class="text-center">
        <button onclick="prevStep(event,2,'step_2')" class="btn btn-next"><i
                class="fa-solid fa-chevron-left"></i>
            Back
        </button>
        <button onclick="nextStep(event,2,'step_2')" class="btn btn-next  disablePlease">Next <i
                class="fa-solid fa-chevron-right"></i></button>
    </div>

</div>
