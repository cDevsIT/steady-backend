//Set Timezone In Cookie

async function getRealIp() {
    try {
        const response = await fetch('https://api.ipify.org?format=json');
        const data = await response.json();
        $("#current_ip").val(data.ip); // Set the IP value
        console.log("Your IP address is: ", data.ip);
        return data.ip; // Return the IP address
    } catch (error) {
        console.error('Error fetching IP address:', error);
        return ''; // Return an empty string on error
    }
}

async function getIp(callback) {
    const ip = await getRealIp(); // Await the promise to get the actual IP

    if (ip) {
        const apiUrl = `https://ipapi.co/${ip}/json/`;

        try {
            const response = await fetch(apiUrl); // Use HTTPS
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            const countryCode = data.country ? data.country.toLowerCase() : "af"; // Default to "af"
            callback(countryCode); // Pass the country code to the callback
        } catch (error) {
            console.error('Error fetching country info:', error);
            callback("af"); // Default to "af" in case of error
        }
    } else {
        callback("af"); // Default to "af" if IP is not obtained
    }
}


const phoneInputField = document.querySelector("#phone_number");
const phoneInput = window.intlTelInput(phoneInputField, {
    initialCountry: "auto",
    // initialCountry: "af",
    geoIpLookup: getIp,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",

    // preferredCountries: ["bd", "us", "gb"],
    placeholderNumberType: "MOBILE",
    nationalMode: true,
    // separateDialCode:true,
    // autoHideDialCode:true,
    customContainer: "w-100",
    autoPlaceholder: "polite",
    customPlaceholder: function (selectedCountryPlaceholder, selectedCountryData) {
        return "e.g. " + selectedCountryPlaceholder;
    },
});

//country changed event
phoneInputField.addEventListener("countrychange", function () {
    // do something with iti.getSelectedCountryData()
    // console.log(phoneInput.getSelectedCountryData().iso2);
    // console.log(phoneInput.getSelectedCountryData());
    $("#country").val(phoneInput.getSelectedCountryData().name);
    $("#mobile").val(phoneInput.getNumber());
    $("#calling_code").val(phoneInput.getSelectedCountryData().dialCode);
});

// window.onscroll = function () {
//     addFixedTopOnScroll()
// };

function addFixedTopOnScroll() {
    var navbar = document.querySelector('.navbar');
    var sticky = 50;

    if (window.pageYOffset >= sticky) {
        navbar.classList.add('fixed-top');
    } else {
        navbar.classList.remove('fixed-top');
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    addFixedTopOnScroll();
});
const statesLists = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']

let stateOptions = "";
statesLists.map((item) => {
    stateOptions += `<option value="${item}">${item}</option>`
})

let fullMobile = null;
let numberOfMembership = 1;
let start_fee = 0.00;
let selected_plan_name = "free-plan";
var plan_price = 0.00;
var en_amount = 0.00;
var agreement_amount = 0.00;
var rush_processing = 0.00;
let total_amount_generate = 0.00;
let agentInfo = "free_for_one_year";
let agentInfoTwo = "Individual";
removeAllDataFromLocalStorage()
localStorage.setItem('s3_start_fee', start_fee);
localStorage.setItem('agentInfo', agentInfo);
localStorage.setItem('agentInfoTwo', agentInfoTwo);
// Step 4 Business Plan Pricing
let step_four_data = {
    plan_name: "free-plan",
    plan_price: plan_price,
}
localStorage.setItem('s4_plan', JSON.stringify(step_four_data));

let currentStep = 1;

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validateInput(input, type = null) {
    if (type === 'email') {
        if (validateEmail(input.value)) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            return true;
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            return false;
        }
    } else if (type === 'phone_number') {
        if (phoneInput.isValidNumber()) {
            console.log("valid")
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
            return true;
        } else {
            console.log("Invalid")
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            return false;
        }
    } else {
        if (input.value.trim() === '') {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            return false;
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            return true;
        }
    }
    return false;
}


function stepTwoValidation() {
    let isValid = true;
    let first_name = document.querySelector("#first_name");
    let last_name = document.querySelector("#last_name");
    let email = document.querySelector("#email");
    let phone_number = document.querySelector("#phone_number");
    isValid = validateInput(first_name) && isValid;
    isValid = validateInput(last_name) && isValid;

    isValid = validateInput(email, "email") && isValid;
    if (phone_number.getAttribute("isAuthenticated") == "No") {
        console.log(phone_number.getAttribute("isAuthenticated"))
        isValid = validateInput(phone_number, "phone_number") && isValid;
    }
    return isValid;
}

function changeBusinessType(event) {
    const value = event.target.value;
    const businessTypeOptions = document.getElementById("businessTypeOptions");
    businessTypeOptions.innerHTML = '';
    if (value == 'LLC') {
        const label = document.createElement('label');
        label.setAttribute('for', 'llc_type');
        label.innerHTML = 'LLC Type <span class="text-danger">*</span>';

        // Create the select element
        const llcSelect = document.createElement('select');
        llcSelect.name = 'llc_type';
        llcSelect.className = 'form-control step_form_control';
        llcSelect.id = 'llc_type';
        llcSelect.required = true;

        // Define options
        const options = [
            {value: '', text: 'Select One'},
            {value: 'Single Member LLC', text: 'Single Member LLC'},
            {value: 'Multi-member LLC', text: 'Multi-member LLC'},
            {value: 'S Corp (Owners must be U.S Resident)', text: 'S Corp (Owners must be U.S Resident)'}
        ];

        // Add options to the select element
        options.forEach(optionData => {
            const option = document.createElement('option');
            option.value = optionData.value;
            option.textContent = optionData.text;
            llcSelect.appendChild(option);
        });

        businessTypeOptions.appendChild(label)
        businessTypeOptions.appendChild(llcSelect)

        //যদি ওনারশঈপ ১ জন হয় তবে সিঙ্গেল-মেম্বার। একের অধিক ওনার থাকলে অটোমেটিক সেটা মাল্টিমেম্বার হয়ে যাবে।
        let numberOfOwnership = parseInt($("#number_of_ownership").val())
        if (numberOfOwnership > 1) {
            $("#llc_type").val('Multi-member LLC');
        } else if (numberOfOwnership == 1) {
            $("#llc_type").val('Single Member LLC');
        }
    }
    if (value == 'Corporation') {
        const coLabel = document.createElement('label');
        coLabel.setAttribute('for', 'corporation_type');
        coLabel.innerHTML = 'Corporation Type <span class="text-danger">*</span>';

        const corpSelect = document.createElement('select');
        corpSelect.name = 'corporation_type';
        corpSelect.className = 'form-control step_form_control';
        corpSelect.id = 'corporation_type';
        corpSelect.onchange = corporateTypeChange;

        corpSelect.required = true;

        // Create options for the corpSelect
        const corpOptions = [
            {value: '', text: 'Select One', selected: false},
            {value: 'C Corporation', text: 'C Corporation', selected: false},
            {
                value: 'S Corporation (Owners must be U.S Resident)',
                text: 'S Corporation (Owners must be U.S Resident)',
                selected: true
            }
        ];

        $('select.countryListAll').val('United States').change().prop('disabled', true);

        corpOptions.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.value;
            opt.textContent = option.text;
            opt.selected = option.selected
            // if (option.value == 'S Corporation (Owners must be U.S Resident)') {
            //     $('select.countryListAll').val('United States');
            // }
            corpSelect.appendChild(opt);
        });
        businessTypeOptions.appendChild(coLabel)
        businessTypeOptions.appendChild(corpSelect)
    } else {
        $('select.countryListAll').prop('disabled', false)
    }

    if (value == "Non-Profit") {
        $("#directorOrOwner").text("Directors")
        $(".directorOrOwner").text("Director")
    } else {
        $("#directorOrOwner").text("Ownership")
        $(".directorOrOwner").text("Owner")
    }

    if (value == "Partnership") {
        // membershipDropdown.disabled = false; // Enable dropdown
        // Set the minimum value to 2 for partnership
        $("#number_of_ownership").html(`
            <option selected value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        `);
        $("#number_of_ownership").val(2).change();
    } else {

        // Reset to default for other types
        $("#number_of_ownership").html(`
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        `);
        $("#number_of_ownership").val(1).change();
        // membershipDropdown.disabled = true; // Disable dropdown again
    }
    //
    // if (value == "Partnership") {
    //     $("#number_of_ownership").val(2).change();
    //     $("#number_of_ownership").attr('disabled',true);
    // }else{
    //     $("#number_of_ownership").attr('disabled',false);
    // }

}


$(document).on("change", '#llc_type', function () {
    let value = $(this).val();
    if (value === 'Single Member LLC') {

        $("#number_of_ownership").html(`
            <option value="1">1</option>
<!--            <option value="2">2</option>-->
<!--            <option value="3">3</option>-->
<!--            <option value="4">4</option>-->
        `);
        $("#number_of_ownership").val(1).change();
    } else if (value === 'Multi-member LLC') {
        $("#number_of_ownership").html(`
            <option selected value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        `);
        $("#number_of_ownership").val(2).change();
    }

})

function checkTotalPercentage(form) {
    const percentageValidate = form.querySelectorAll(".single_percent");
    let totalPercentage = 0;
    percentageValidate.forEach(input => {
        totalPercentage += parseInt(input.value)
    });
    // console.log("TotalPercentage::::> " + totalPercentage)
    if (totalPercentage > 100) {
        alert('Total percentage must be less than or equal to 100%')
        return false;
    }
    return true;

}

//Working with It
function checkinsNonProfitOrganizationAndDoesntHaveAnyUsaDirector(businessType) {
    if (businessType === 'Non-Profit') {
        let allDirectorCountry = $('.countryListAll');
        if (allDirectorCountry.length > 0) {
            let countries = [];
            allDirectorCountry.each(function () {  // Use .each instead of .map
                countries.push($(this).val());   // 'this' refers to the current element
            });
            if (!countries.includes('United States')) {
                alert('Non-Profit Organization Must have a USA Director');
                return false;
            }
        }
        return true;
    }
    return true;
}


function changeTypeOfIndustry(event) {
    const value = event.target.value;
    const otherIndustry = document.querySelector("#other_type_of_industry");
    otherIndustry.innerHTML = '';

    if (value == "Other") {
        const label = document.createElement('label');
        label.setAttribute('for', 'other_type_of');
        label.innerHTML = 'Other Type Of Industry <span class="text-danger">*</span>';

        // Create the input element
        const input = document.createElement('input');
        input.type = 'text';
        input.id = 'other_type_of';
        input.name = 'other_type_of_industry';
        input.className = 'form-control step_form_control';
        input.required = true;

        // Append the label and input to the container
        otherIndustry.appendChild(label);
        otherIndustry.appendChild(input);
    }
}

function toCamelCase(str) {
    const firstWord = str.split('-')[0];
    return firstWord.charAt(0).toUpperCase() + firstWord.slice(1).toLowerCase();
}

async function nextStep(event, step, field) {
    event.preventDefault();
    let formData = new FormData();
    let parent = event.target.parentElement.parentElement;

    if (step == 1) {
        const wantHides = document.querySelectorAll('.wantHide');
        console.log(wantHides)
        wantHides.forEach((element) => {
            element.style.display = 'none';
        })
        $("footer.footer").css('margin-top', '30px')
        $("footer.footer").css('border-top', '1px solid gray')

        let company_value = document.querySelector("#company_name");
        if (!company_value.value.trim()) {
            company_value.classList.add('is-invalid');
            return false;
        } else {
            company_value.classList.remove('is-valid');
            formData.append('company_name', company_value.value.trim());
            localStorage.setItem('s1_company_name', company_value.value.trim());
        }
    }

// ============================= Step One: only Company Name =============   =========================
    if (step == 2) {

        let s1_company_name = localStorage.getItem('s1_company_name')
        $("#propose_business_name").val(s1_company_name)
        stepTwoValidation();

        let phone_number = document.querySelector("#phone_number");
        if (phone_number.getAttribute("isAuthenticated") == "No") {
            if (phoneInput.isValidNumber()) {
                console.log(phoneInput.isValidNumber())
                $("#calling_code").val(phoneInput.getSelectedCountryData().dialCode)
                $("#country").val(phoneInput.getSelectedCountryData().name)
                $("#mobile").val(phoneInput.getNumber())
                fullMobile = phoneInput.getNumber();
            } else {
                alert('Your mobile number is wrong! Try again please.')
                return false;
            }
        }
        let first_name = document.getElementById('first_name')
        let last_name = document.getElementById('last_name')
        let email = document.getElementById('email')
        formData.append('first_name', first_name.value.trim());
        formData.append('last_name', last_name.value.trim());
        formData.append('email', email.value.trim());
        formData.append('phone_number', fullMobile);

        let stepTowData = {
            first_name: first_name.value.trim(),
            last_name: last_name.value.trim(),
            email: email.value.trim(),
            phone_number: fullMobile,
        }
        final_amount_calculation()
        primaryContactStoreInDatabase(stepTowData)
        console.log(step)
        localStorage.setItem('s2_stepTowData', JSON.stringify(stepTowData));
    }


// ============================= Step Three: Business info ============= Figma : Funnel 02 =========================
    if (step == 3) {
        let isValid = true;
        //Validate Global fields
        const propose_business_name = document.querySelector("#propose_business_name");
        const business_type = document.querySelector("#business_type");
        const state_name = document.querySelector("#state_name");
        const type_of_industry = document.querySelector("#type_of_industry");
        const number_of_ownership = document.querySelector("#number_of_ownership");


        // console.log(llc_type ? llc_type.val() : "NULL")
        const corporation_type = $("#corporation_type");

        isValid = validateInput(propose_business_name) && isValid;
        isValid = validateInput(business_type) && isValid;
        isValid = validateInput(state_name) && isValid;
        isValid = validateInput(type_of_industry) && isValid;
        isValid = validateInput(number_of_ownership) && isValid;

        if (business_type.value === '') {
            $(".business_type_error").html('<span class="text-danger">Business Type Required</span>')
            $(".step3Errors").html('<span class="text-danger">Business Type Required</span>')
        } else {
            $(".step3Errors").html('')
            $(".business_type_error").html('')
        }
        var business_type_sub = '';
        var type_of_industry_value = type_of_industry.value;
        if (business_type.value == "LLC") {
            const llc_type = $("#llc_type");
            // isValid = validateInput(llc_type) && isValid;
            if (llc_type.val() == null || llc_type.val() == '') {
                llc_type.removeClass('is-valid')
                llc_type.addClass('is-invalid')
                isValid = false;
            } else {
                llc_type.removeClass('is-invalid')
                business_type_sub = llc_type.val()
            }
        }
        if (business_type.value == "Corporation") {
            if (corporation_type.val() == null || corporation_type.val() == '') {
                corporation_type.removeClass('is-valid')
                corporation_type.addClass('is-invalid')
                isValid = false;
            } else {
                corporation_type.removeClass('is-invalid')
                business_type_sub = corporation_type.val()
            }

        }
        if (type_of_industry.value == "Other") {
            const other_type_of = $("#other_type_of");
            if (other_type_of.val() == null || other_type_of.val() == '') {
                other_type_of.removeClass('is-valid')
                other_type_of.addClass('is-invalid')
                isValid = false;
            } else {
                other_type_of.removeClass('is-invalid')
                type_of_industry_value = other_type_of.val()
            }

        }


        //Validate Membership fields
        const form = document.getElementById('show_multi_member_info');
        const requiredInputs = form.querySelectorAll('input[required], select[required]');

        requiredInputs.forEach(input => {
            if (input.value.trim() === '') {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
                input.classList.remove('is-invalid');

            }
        });

        // If form is valid, you can proceed with form submission
        if (isValid) {
            if (!checkTotalPercentage(form) || !checkinsNonProfitOrganizationAndDoesntHaveAnyUsaDirector(business_type.value)) {
                return false;
            }
        } else {
            if (!checkTotalPercentage(form) || !checkinsNonProfitOrganizationAndDoesntHaveAnyUsaDirector(business_type.value)) {
                return false;
            }
            // Optional: Scroll to the first invalid field
            const firstInvalidInput = form.querySelector('.is-invalid');
            if (firstInvalidInput) {
                firstInvalidInput.focus();
            }
            return false;
        }


        // checkTotalPercentage();
        const show_multi_member_info = [];

        for (let i = 1; i <= numberOfMembership; i++) {
            let name = document.getElementById(`name${i}`).value;
            let ownership_percentage = document.getElementById(`ownership_percentage${i}`).value;
            let email = document.getElementById(`email${i}`).value;
            let phone = document.getElementById(`phone${i}`).value;
            let street_address = document.getElementById(`street_address${i}`).value;
            let city = document.getElementById(`city${i}`).value;
            let state = document.getElementById(`state${i}`).value;
            let zip_code = document.getElementById(`zip_code${i}`).value;
            let country = document.getElementById(`country${i}`).value;

            let row = {
                name: name,
                ownership_percentage: ownership_percentage,
                email: email,
                phone: phone,
                street_address: street_address,
                city: city,
                state: state,
                zip_code: zip_code,
                country: country,
            }
            show_multi_member_info.push(row);
        }
        localStorage.setItem('s3_multi_member_info', JSON.stringify(show_multi_member_info))
        localStorage.setItem('s3_propose_business_name', propose_business_name.value)
        localStorage.setItem('s3_business_type', business_type.value)
        localStorage.setItem('s3_state_name', state_name.value)
        localStorage.setItem('s3_type_of_industry', type_of_industry_value)
        localStorage.setItem('s3_number_of_ownership', number_of_ownership.value)
        localStorage.setItem('s3_business_type_sub', business_type_sub)

        $("#step4_state").val(state_name.value)

        final_amount_calculation()
    }


// ============================= Step Four: Registered Agent & Business Address & Registered Agent and Business Address Package * ============= Figma : Funnel 3 =========================

    if (step == 4) {
        let isValid = true;
        if (selected_plan_name === "free-plan") {
            const form = document.getElementById('free_plan_details');
            const requiredInputfields = form.querySelectorAll('input[required], select[required]');
            requiredInputfields.forEach(input => {
                if (input.value.trim() === '') {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.remove('is-invalid');
                }
            });
            if (isValid) {

            } else {
                const firstInvalidInput = form.querySelector('.is-invalid');
                if (firstInvalidInput) {
                    firstInvalidInput.focus();
                }
                return false;
            }
            let step_4_free_plan_details = {};
            requiredInputfields.forEach(input => {
                step_4_free_plan_details[input.name] = input.value.trim();
            })
            localStorage.setItem('s4_free_plan_details', JSON.stringify(step_4_free_plan_details))


        } else {

        }

        let main_state_name = localStorage.getItem('s3_state_name')
        let ind_state = $("#ind_state")
        let com_state = $("#com_state")

        if (ind_state) {
            ind_state.val(main_state_name)
        }
        if (com_state) {
            com_state.val(main_state_name)
        }
        final_amount_calculation()
    }
    if (step == 5) {
        // en_amount = 69;
        $(".ein_upgrade").text("$" + en_amount)
        $("#ein_upgrade").val(en_amount)
        localStorage.setItem('s5_en_amount', en_amount);
        final_amount_calculation()

        let isValid = true;
        const form = document.getElementById('show_register_agent');
        const requiredInputfields = form.querySelectorAll('input[required], select[required]');
        if (requiredInputfields.length > 0) {
            requiredInputfields.forEach(input => {
                if (input.value.trim() === '') {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.remove('is-invalid');
                }
            });
            if (isValid) {

            } else {
                const firstInvalidInput = form.querySelector('.is-invalid');
                if (firstInvalidInput) {
                    firstInvalidInput.focus();
                }
                return false;
            }
            let step_5_agent_information = {};
            requiredInputfields.forEach(input => {
                step_5_agent_information[input.name] = input.value.trim();
            })
            localStorage.setItem('step_5_agent_information', JSON.stringify(step_5_agent_information))
        }


        final_amount_calculation()
    }


// ============================= Step Five: EIN (Employer Identification Number) * ============= Figma : Funnel 4 =========================
    if (step == 6) {
        // agreement_amount = 99;
        $(".agreements").text("$" + agreement_amount)
        $("#agreements").val(agreement_amount)
        //
        localStorage.setItem('s6_agreement_amount', agreement_amount);
        final_amount_calculation()
    }

    //  ============================= Step Six:Operating Agreement / Corporate Bylaws * ============= Figma : Funnel 5 ========================= =========================
    if (step == 7) {

        $(".rush_processing").text("$" + rush_processing)
        $("#rush_processing").val(rush_processing)


        if (selected_plan_name == "free-plan") {
            $(".business_fee").text("Free")
        } else {
            $(".business_fee").text("$" + plan_price)
        }
        $(".agent_package_name").text(toCamelCase(selected_plan_name))


        $(".ein_fee").text("$" + en_amount)
        if (en_amount > 0) {
            $(".is_yen_active").text("Yes")
        } else {
            $(".is_yen_active").text("No")
        }

        $(".agreement_fee").text("$" + agreement_amount)
        if (agreement_amount > 0) {
            $(".is_agreement_active").text("Yes")
        } else {
            $(".is_agreement_active").text("No")
        }


        localStorage.setItem('s7_rush_processing_amount', rush_processing);
        final_amount_calculation()
    }

    if (step == 8) {
        let s3_number_of_ownership = localStorage.getItem('s3_number_of_ownership')
        let s3_propose_business_name = localStorage.getItem('s3_propose_business_name')
        let s3_state_name = localStorage.getItem('s3_state_name')
        let s3_state_fee = localStorage.getItem('s3_start_fee')
        let s3_type_of_industry = localStorage.getItem('s3_type_of_industry')

        $(".processing_fee").text(`$${rush_processing.toFixed(2)}`)
        if (rush_processing > 0) {
            $(".is_processing_active").text("Yes")
        } else {
            $(".is_processing_active").text("No")
        }

        // document.getElementById('o_business_name').innerHTML = s3_propose_business_name;
        // document.getElementById('o_location').innerHTML = s3_state_name;
        // document.getElementById('o_business_type').innerHTML = s3_type_of_industry;
        // document.getElementById('o_number_of_person').innerHTML = s3_number_of_ownership;

        $('.o_business_name').text(s3_propose_business_name)
        $('.o_location').text(s3_state_name)
        $('.o_business_type').text(s3_type_of_industry)
        $('.o_number_of_person').text(s3_number_of_ownership)

        let s2_stepTowData = JSON.parse(localStorage.getItem('s2_stepTowData'))
        if (s2_stepTowData) {
            $('.o_name').text(s2_stepTowData.first_name + ' ' + s2_stepTowData.last_name)
            $('.o_email').text(s2_stepTowData.email)
            $('.o_phone').text(s2_stepTowData.phone_number)
        }


        $('.state__name').text(s3_state_name)
        $('.state_fee_price').text('$' + s3_state_fee)

        // showOwnerInfos
        let ownersInfos = JSON.parse(localStorage.getItem('s3_multi_member_info'))
        let owners = '';
        ownersInfos.forEach(ownerInfo => {
            owners += `    <div class="mb-5">
                <p><i class="fa-regular fa-user"></i> &nbsp; &nbsp; <span
        class="owner_name">${ownerInfo.name}</span>
            </p>
            <p><i class="fa-regular fa-envelope"></i> &nbsp; &nbsp; <span
        class="owner_email">${ownerInfo.email}</span></p>
            <p><i class="fa-solid fa-phone"></i> &nbsp; &nbsp; <span
        class="owner_phone">${ownerInfo.phone}</span>
                </p>
                <p><i class="fa-solid fa-percent"></i> &nbsp; &nbsp; <span class="owner_phone">${ownerInfo.ownership_percentage}</span></p>
            <p><i class="fa-solid fa-location-dot"></i> &nbsp; &nbsp; <span class="owner_location">${ownerInfo.country}</span>
            </p>
            </div>
        `
        })
        $("#showOwnerInfos").html(owners)


    }
    // console.log(`Sep Number: ${step}`)
    document.getElementById(`step${step}`).style.display = 'none';
    let nextStep = step + 1;

    document.getElementById(`step${nextStep}`).style.display = 'block';
    currentStep = step;
}

async function prevStep(event, step, field) {
    event.preventDefault();
    let formData = new FormData();
    let parent = event.target.parentElement.parentElement;
    if (step == 2) {
        const wantHides = document.querySelectorAll('.wantHide');
        wantHides.forEach((element) => {
            element.style.display = 'block';
        })
        $("footer.footer").css('margin-top', '0px')
        $("footer.footer").css('border-top', '0px')
    }


    document.getElementById(`step${step}`).style.display = 'none';
    // Show next step
    let prevStep = step - 1;
    document.getElementById(`step${prevStep}`).style.display = 'block';
    currentStep = prevStep;
    formData.append('field', field);
}


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

// localStorage.setItem('s3_business_type', "LLC");
// const businessTypeDom = document.querySelector("#business_type");
// businessTypeDom.addEventListener('change', function (event) {
//     let state_name = event.target.value;
//     localStorage.setItem('s3_business_type', "LLC");
//
// })

function validateEmailAjax(event) {
    let email = event.target.value;
    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(email)) {
        event.target.classList.add('is-invalid');
        event.target.classList.remove('is-valid');
        $('.emailError').text("emails not valid")
        $(".disablePlease").attr('disabled', true);
        return false;
    } else {
        event.target.classList.remove('is-invalid');
        event.target.classList.add('is-valid');
        $('.emailError').text(" ")
        $(".disablePlease").attr('disabled', false);
    }


    let route = event.target.getAttribute('data-route');
    $.ajax({
        url: route,
        method: 'GET',
        data: {
            email: email
        },
        success: function (response) {
            if (response.success) {
                event.target.classList.remove('is-invalid');
                event.target.classList.add('is-valid');
                $('.emailError').text("")
                $(".disablePlease").attr('disabled', false);
            } else {
                event.target.classList.add('is-invalid');
                event.target.classList.remove('is-valid');
                $('.emailError').text("emails already Exist")
                $(".disablePlease").attr('disabled', true);
            }
        }
    })
}


function corporateTypeChange(event) {
    if (event.target.value == 'S Corporation (Owners must be U.S Resident)') {
        $('select.countryListAll').val('United States').prop('disabled', true);
    } else {
        $('select.countryListAll').prop('disabled', false)
    }
}

function onChangeNumberOfMembership(event) {
    let ownership_percentage_options = '';
    for (let i = 100; i >= 1; i--) {
        ownership_percentage_options += `<option value="${i}">${i}%</option>`;
    }

    const numberOfOwnership = parseInt(event.target.value);
    numberOfMembership = numberOfOwnership;
    let selectedMemberList = ``;

    let business_type = $("#business_type").val()
    let business_sub_type = $("#corporation_type")
    let selectUS = false;
    if (business_type === "Corporation" && (business_sub_type && business_sub_type.val() === "S Corporation (Owners must be U.S Resident)")) {
        selectUS = true;
    }


    let directorOwner = "Owner";
    if (business_type == "Non-Profit") {
        directorOwner = "Director";
    } else {
        directorOwner = "Owner";
    }
    console.log("FOREAC")
    for (let i = 1; i <= numberOfOwnership; i++) {
        selectedMemberList += `<div class="row mb-4 owners_info">
                        <p class="mb-5"> <span class="directorOrOwner">${directorOwner}</span>  info *</p>
                            <div class="col-12 step_three_owners_info">
                                <div class="row">
                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="name" class="step_label"> Name *</label>
                                        <input type="text" name="name[${i}]" required id="name${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="email" class="step_label"> Email *</label>
                                        <input type="email" name="email[${i}]" required id="email${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="phone" class="step_label"> Phone *</label>
                                        <input type="text" name="phone[${i}]" required id="phone${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="ownership_percentage" class="step_label"> Ownership Percentage *</label>
                                        <select name="ownership_percentage[${i}]" class="form-control step_form_control single_percent" required id="ownership_percentage${i}">
                                        ${ownership_percentage_options}
                                        </select>
                                    </div>



                                    <div class="col-12  form-group step_group">
                                        <label for="street_address" class="step_label">Street Address</label>
                                        <input type="text" name="street_address[${i}]"  id="street_address${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="city" class="step_label">City</label>
                                        <input type="text" name="city[${i}]"  id="city${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group ">
                                        <label for="state" class="step_label">State</label>
                                            <div class="stateField">

                                               <select name="state[${i}]" id="state${i}" data-track-id="${i}" required class="form-control stateList step_form_control">
                                                    ${stateOptions}
                                                </select>
                                            </div>
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="zip_code" class="step_label">Zip Code</label>
                                        <input type="text" name="zip_code[${i}]"  id="zip_code${i}"
                                               class="form-control step_form_control">
                                    </div>

                                    <div class="col-12 col-md-6 form-group step_group">
                                        <label for="country" class="step_label">Country</label>
                                        <select name="country[${i}]" id="country${i}" required class="form-control countryListAll step_form_control">
                                           ${countryListApply(selectUS)}

                                        </select>
                                    </div>

                                    <div class="col-12  form-group step_group">
                                        <div class="row px-5">
                                            <div class="col-12 ">
                                            <i class="fa-regular fa-lightbulb"></i> &nbsp;
                                                This address is used for internal purposes only and will not be shared with any third parties or other outside agencies unless provided in any subsequent pages of the order process which require the intake of an address.
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                    </div>`
    }

    //যদি ওনারশঈপ ১ জন হয় তবে সিঙ্গেল-মেম্বার। একের অধিক ওনার থাকলে অটোমেটিক সেটা মাল্টিমেম্বার হয়ে যাবে।
    if (numberOfOwnership > 1 && business_type == "LLC") {
        $("#llc_type").val('Multi-member LLC');
    } else if (numberOfOwnership == 1 && business_type == "LLC") {
        $("#llc_type").val('Single Member LLC');
    }

    let a = document.getElementById("#show_multi_member_info")
    $("#show_multi_member_info").innerHTML = "";
    $("#show_multi_member_info").html(selectedMemberList);
    console.log(selectUS ? "HAS USA" : "NO USA")
    if (selectUS) {
        $('select.countryListAll').val('United States').prop('disabled', true)
    } else {
        $('select.countryListAll').prop('disabled', false)
    }


}


function planChange(event) {
    let plan = event.target.value;
    let plan_name = event.target.getAttribute("id")
    selected_plan_name = plan_name;
    let state_name = localStorage.getItem('s3_state_name')

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
                               <input type="text" required name="step4_state" id="step4_state" value="${state_name}" class="form-control step_form_control" readonly>
<!--                            -->
<!--                                <input type="text" name="step4_state" required id="step4_state"-->
<!--                                       class="form-control step_form_control">-->
                            </div>
                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="step4_zip_code" class="step_label">Zip Code *</label>
                                <input type="text" name="step4_zip_code" required id="step4_zip_code"
                                       class="form-control step_form_control">
                            </div>

                            <div class="col-12 col-md-6 form-group step_group">
                                <label for="step4_country" class="step_label">Country</label>
                                <select name="step4_country" disabled id="step4_country" class="form-control step_form_control">
                                <option selected  value="United States">United States</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <p style="font-weight: bold">Note: Must be a valid and USA Registered Agent Address.</p>
                            </div>
                        </div>
                    </div>`
    if (plan_name == 'free-plan') {
        plan_price = 0.00;
        $("#free_plan_details").html(free_plan_details);
    } else if (plan_name == 'monthly-plan') {
        plan_price = 10.00;
        $("#free_plan_details").html('');
    } else if (plan_name == 'yearly-plan') {
        plan_price = 99.00;
        $("#free_plan_details").html('');
    }
    let step_four_data = {
        plan_name: plan_name,
        plan_price: plan_price,
    }
    $(".business_address_fee").text(`$${plan_price.toFixed(2)}`)
    $("#business_address_fee").val(plan_price.toFixed(2))

    final_amount_calculation()
    localStorage.setItem('s4_plan', JSON.stringify(step_four_data));

}

function enAmountChange(event) {
    let en_amount_value = event.target.value;
    en_amount = en_amount_value;
    let field_name = event.target.getAttribute("id")
    if (field_name == 'add_en') {
        en_amount = 69.00;
    } else if (field_name == 'no_skip') {
        en_amount = 0.00;
    }
    $(".ein_upgrade").text(`$${en_amount.toFixed(2)}`)
    $("#ein_upgrade").val(en_amount.toFixed(2))

    final_amount_calculation()
    localStorage.setItem('s5_en_amount', en_amount);

}

function agreementChange(event) {
    let agreement_amount_value = event.target.value;
    agreement_amount = agreement_amount_value;
    let field_name = event.target.getAttribute("id")
    if (field_name == 'add_agreement') {
        agreement_amount = 99.00;
    } else if (field_name == 'no_skip_step_6') {
        agreement_amount = 0.00;
    }
    $(".agreements").text(`$${agreement_amount.toFixed(2)}`)
    $("#agreements").val(agreement_amount.toFixed(2))

    final_amount_calculation()
    localStorage.setItem('s6_agreement_amount', agreement_amount);

}

function expeditedChange(event) {
    let rush_processing_value = event.target.value;
    let parent = event.target.parentElement;
    rush_processing = rush_processing_value;


    let field_name = event.target.getAttribute("id")
    if (field_name == 'add_expedited_processing') {
        rush_processing = 25.00;
        $('.processing_card_item').removeClass('active');
        parent.classList.add("active")
    } else if (field_name == 'no_expedited_processing') {
        rush_processing = 0.00;

        $('.processing_card_item').removeClass('active');
        parent.classList.add("active")
    }
    $(".rush_processing").text(`$${rush_processing.toFixed(2)}`)
    $("#rush_processing").val(rush_processing.toFixed(2))

    $(".processing_fee").text(`$${rush_processing.toFixed(2)}`)
    if (rush_processing > 0) {
        $(".is_processing_active").text("Yes")
    } else {
        $(".is_processing_active").text("No")
    }
    final_amount_calculation()
    localStorage.setItem('s7_rush_processing_amount', rush_processing);

}

function agentInfoChange(event) {
    let agent_info_value = event.target.value;
    let parent = event.target.parentElement;
    agentInfo = agent_info_value;
    let main_state_name = localStorage.getItem('s3_state_name')

    let field_name = event.target.getAttribute("id")
    if (field_name == 'own_register_agent') {
        agentInfo = "own registered agent";
        $('.agent_item').removeClass('active');
        parent.classList.add("active")
        $('.agent_condition').hide();
        $('.agent').hide();
        const show_register_agent_html = ` <div class="register_agent">
                <h6>Agent Information</h6>
                <p>You may serve as your own Registered Agent as long as you possess a physical street address <strong>(PO
                        Box not allowed)</strong> in the state of formation.</p>

                <div class="register_agent_address">
                    <div class="agent_item item_2 active col-12 col-md-6">
                        <input checked type="radio" id="Individual" class="add_expedited_processing"
                               onchange="agentInfoTwoChange(event)" name="expedited_processing">
                        <label for="Individual" style="margin-left:0px;" class="card-content">

                            <div class="agent_info_2_title">Individual</div>
                            <div class="d-flex justify-content-between">
                                <div class="radio-circle"></div>

                            </div>


                            <div class=" p-10" style="margin-top: 2.5rem;">
                                The registered agent will be an individual.
                            </div>

                        </label>
                    </div>
                    <div class="agent_item item_2 col-12 col-md-6">
                        <input type="radio" id="Company" class="no_expedited_processing"
                               onchange="agentInfoTwoChange(event)" name="expedited_processing">

                        <label for="Company" class="card-content ">
                            <div class="agent_info_2_title">Company</div>
                            <div class="d-flex justify-content-between">
                                <div class="radio-circle"></div>

                            </div>

                            <div class=" p-10" style="margin-top: 2.5rem;">
                                The registered agent will be a company.
                            </div>
                        </label>
                    </div>
                </div>
                <div class="showIndividualOrCompany mt-5">
                    <div class="row">
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_first_name" class="step_label">First Name</label>
                            <input type="text" name="ind_first_name" required id="ind_first_name"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_last_name" class="step_label">Last Name </label>
                            <input type="text" name="ind_last_name" required id="ind_last_name"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_street_address" class="step_label">Street Address</label>
                            <input type="text" name="ind_street_address" required id="ind_street_address"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_address_cont" class="step_label">Address (Cont)</label>
                            <input type="text" name="ind_address_cont" required id="ind_address_cont"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6  form-group step_group">
                            <label for="ind_city" class="step_label">City</label>
                            <input type="text" name="ind_city" required id="ind_city"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_state" class="step_label">State</label>
                            <input type="text" name="ind_state" required readonly value="${main_state_name}" id="ind_state"
                                   class="form-control step_form_control ind_state">
                        </div>

                         <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_country" class="step_label">Country</label>
                            <input type="text" name="ind_country" value="United States" required readonly id="ind_country"
                                   class="form-control step_form_control">
                        </div>

                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_zip_code" class="step_label">Zip Code</label>
                            <input type="text" name="ind_zip_code" required id="ind_zip_code"
                                   class="form-control step_form_control">
                        </div>

                    </div>

                </div>

            </div>`
        $('.show_register_agent').html(show_register_agent_html);
    } else {
        $('.agent_condition').show();
        $('.agent').show();

        agentInfo = 'FREE For 1 year';
        $('.agent_item').removeClass('active');
        parent.classList.add("active")
        $('.show_register_agent').html("");
    }

    localStorage.setItem('agentInfo', agentInfo);

}

function agentInfoTwoChange(event) {
    let agent_info_two_value = event.target.value;
    let parent = event.target.parentElement;
    agentInfoTwo = agent_info_two_value;
    let main_state_name = localStorage.getItem('s3_state_name')

    let field_name = event.target.getAttribute("id")
    console.log(field_name)
    if (field_name == 'Individual') {
        agentInfoTwo = "Individual";
        $('.agent_item.item_2').removeClass('active');
        parent.classList.add("active")
        const individual_html = `<div class="row">
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_first_name" class="step_label">First Name</label>
                            <input type="text" name="ind_first_name" required id="ind_first_name"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_last_name" class="step_label">Last Name </label>
                            <input type="text" name="ind_last_name" required id="ind_last_name"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_street_address" class="step_label">Street Address</label>
                            <input type="text" name="ind_street_address" required id="ind_street_address"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_address_cont" class="step_label">Address (Cont)</label>
                            <input type="text" name="ind_address_cont" required id="ind_address_cont"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6  form-group step_group">
                            <label for="ind_city" class="step_label">City</label>
                            <input type="text" name="ind_city" required id="ind_city"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_state" class="step_label">State</label>
                            <input type="text" name="ind_state" required readonly value="${main_state_name}" id="ind_state"
                                   class="form-control step_form_control ind_state">
                        </div>
                          <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_country" class="step_label">Country</label>
                            <input type="text" name="ind_country" value="United States" required readonly id="ind_country"
                                   class="form-control step_form_control">
                        </div>

                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="ind_zip_code" class="step_label">Zip Code</label>
                            <input type="text" name="ind_zip_code" required id="ind_zip_code"
                                   class="form-control step_form_control ind_state">
                        </div>

                    </div>`
        $(".showIndividualOrCompany").html(individual_html);

    } else {
        $(".showIndividualOrCompany").html();
        agentInfoTwo = 'Company';
        $('.agent_item.item_2').removeClass('active');
        parent.classList.add("active")
        const company_html = ` <div class="row">
                        <div class="col-12  form-group step_group">
                            <label for="com_company_name" class="step_label">Company Name</label>
                            <input type="text" name="com_company_name" required id="com_company_name"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="com_street_address" class="step_label">Street Address</label>
                            <input type="text" name="com_street_address" required id="com_street_address"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="com_address_cont" class="step_label">Address (Cont)</label>
                            <input type="text" name="com_address_cont" required id="com_address_cont"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6  form-group step_group">
                            <label for="com_city" class="step_label">City</label>
                            <input type="text" name="com_city" required id="com_city"
                                   class="form-control step_form_control">
                        </div>
                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="com_state" class="step_label">State</label>
                            <input type="text" name="com_state" readonly required value="${main_state_name}" id="com_state"
                                   class="form-control step_form_control ind_state">
                        </div>
                         <div class="col-12 col-md-6 form-group step_group">
                            <label for="com_country" class="step_label">Country</label>
                            <input type="text" name="com_country" value="United States" required readonly id="com_country"
                                   class="form-control step_form_control">
                        </div>

                        <div class="col-12 col-md-6 form-group step_group">
                            <label for="com_zip_code" class="step_label">Zip Code</label>
                            <input type="text" name="com_zip_code" required id="com_zip_code"
                                   class="form-control step_form_control">
                        </div>

                    </div>`
        $(".showIndividualOrCompany").html(company_html);
    }

    localStorage.setItem('agentInfoTwo', agentInfoTwo);

}

function toggleView(event) {
    event.preventDefault();
    $(".view_terms").toggleClass('show');
}

function final_amount_calculation() {
    // console.log(`finale: ${currentStep}: en ${en_amount}`)
    // if (currentStep == 2) {
    //     total_amount_generate = start_fee;
    // } else if (currentStep == 3) {
    //     total_amount_generate = start_fee + plan_price;
    // } else if (currentStep == 4) {
    //     total_amount_generate = start_fee + plan_price + en_amount;
    // } else if (currentStep == 5) {
    //     total_amount_generate = start_fee + plan_price + en_amount + agreement_amount;
    // } else if (currentStep == 6) {
    //     total_amount_generate = start_fee + plan_price + en_amount + agreement_amount + rush_processing;
    // } else {
    //     total_amount_generate = start_fee + plan_price + en_amount + agreement_amount + rush_processing;
    // }


    // if (currentStep == 2) {
    //     total_amount_generate = start_fee;
    // } else if (currentStep == 3) {
    //     total_amount_generate = start_fee + plan_price;
    // } else if (currentStep == 4) {
    //     total_amount_generate = start_fee + plan_price;
    // } else if (currentStep == 5) {
    //     console.log(en_amount + "EEEENNNN ___CCAAALLEEDD" + currentStep)
    //     total_amount_generate = start_fee + plan_price + en_amount;
    // } else if (currentStep == 6) {
    //     total_amount_generate = start_fee + plan_price + en_amount + agreement_amount;
    // } else if (currentStep == 7) {
    //     total_amount_generate = start_fee + plan_price + en_amount + agreement_amount + rush_processing;
    // }
    total_amount_generate = start_fee + plan_price + en_amount + agreement_amount + rush_processing;
    // console.log(total_amount_generate)
    let total_amount = parseInt(total_amount_generate);
    $(".total_order").text(`$${total_amount.toFixed(2)}`)
    $("#total_order").val(total_amount)

    $(".final_amount").text(`$${total_amount.toFixed(2)}`)
    localStorage.setItem("final_amount", total_amount)
}

function getParsedLocalStorageItem(key) {
    const value = localStorage.getItem(key);
    try {
        return JSON.parse(value);
    } catch (e) {
        // If parsing fails, return the original value
        return value;
    }
}


function retrieveLocalStorageValue() {
    const localStorageArray = {};
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        const value = getParsedLocalStorageItem(key);
        localStorageArray[key] = value;
    }
    console.log(localStorageArray);
    return localStorageArray;
}

function sendDataToBackend() {
    const localStorageData = retrieveLocalStorageValue();
    const route = document.getElementById("store_route").value;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        url: route,
        method: 'POST',
        data: {
            _token: csrfToken, // Include CSRF token for security
            localStorageData: localStorageData
        },
        success: function (response) {
            console.log('Data sent successfully:', response);
        },
        error: function (xhr, status, error) {
            console.error('Error sending data:', error);
        }
    });
}

//TODO
async function storeUserData() {
    const localStorageData = retrieveLocalStorageValue();
    const route = document.getElementById("store_route").value;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    await $.ajax({
        url: "/help//store-new-user",
        method: 'POST',
        data: {
            _token: csrfToken, // Include CSRF token for security
            localStorageData: localStorageData
        },
        success: function (response) {
            console.log('Data sent successfully:', response);
        },
        error: function (xhr, status, error) {
            console.error('Error sending data:', error);
        }
    });
}

// Assuming you call these functions after the DOM is fully loaded
$(document).ready(function () {
    // sendDataToBackend();
    $(".country_list").html(countryListApply());
    console.log("Working")
    $("#step4_country").html(countryListApply());
});


final_amount_calculation()

function removeAllDataFromLocalStorage() {
    localStorage.removeItem('s3_propose_business_name');
    localStorage.removeItem('s3_business_type');
    localStorage.removeItem('s4_plan');
    localStorage.removeItem('company_name');
    localStorage.removeItem('s2_stepTowData');
    localStorage.removeItem('s5_en_amount');
    localStorage.removeItem('s3_number_of_ownership');
    localStorage.removeItem('s7_rush_processing_amount');
    localStorage.removeItem('s1_company_name');
    localStorage.removeItem('s3_multi_member_info');
    localStorage.removeItem('s4_free_plan_details');
    localStorage.removeItem('s3_start_fee');
    localStorage.removeItem('s3_type_of_industry');
    localStorage.removeItem('s6_agreement_amount');
    localStorage.removeItem('final_amount');
    localStorage.removeItem('stepTowData');
    localStorage.removeItem('s3_state_name');
    localStorage.removeItem('s3_business_type_sub');
    localStorage.removeItem('agentInfo');
    localStorage.removeItem('agentInfoTwo');
    localStorage.removeItem('step_5_agent_information');

}

function countryListApply(selectUSA = false) {
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
        countrylist += `<option ${item.name === 'United States' ? 'selected' : ''} ${(selectUSA && item.name) === 'United States' ? 'selected' : ''}  value="${item.name}">${item.name}</option>`;

    })

    return countrylist;
    // console.log("Returning country list")
    // if (selectUSA) {
    //     $('select.countryListAll').val('United States').prop('disabled', true)
    // }else{
    //     $('select.countryListAll').val('United States').prop('disabled', false)
    // }

    // $(".country_list").html(countrylist);
}

function applyUsaSelected(selectUSA) {
    if (selectUSA) {
        $('select.countryListAll').val('United States').prop('disabled', true)
    } else {
        $('select.countryListAll').val('United States').prop('disabled', false)
    }
}


// const number_of_ownership = document.querySelector("#number_of_ownership");
// number_of_ownership.addEventListener("change", (event) => {
//
//
//
// })
function primaryContactStoreInDatabase(stepTowData) {

    // let stepTowData = {
    //     first_name: first_name.value.trim(),
    //     last_name: last_name.value.trim(),
    //     email: email.value.trim(),
    //     phone_number: fullMobile,
    // }
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: '/help/store-primary-data-to_database',
        type: 'POST',
        data: {
            _token: csrfToken, // Include CSRF token for security
            stepTowData: stepTowData
        },
        success: function (response) {
            console.log("Success storing data in database", response);
            // window.location.href = "/step-three";
        },
        error: function (xhr, status, error) {
            console.error("Error storing data in database", xhr, status, error);
        }
    })
}

$(document).on('change', '.countryListAll', function (event) {
    let that = $(this);
    let mainSection = that.closest('.step_three_owners_info').find('.stateField')
    let track_id = that.attr('data-track-id');
    if (!track_id) {
        track_id = 1;
    }

    if (that.val() === 'United States') {
        let html = `<select name="state[${track_id}]" id="state${track_id}" data-track-id="${track_id}" required class="form-control stateList step_form_control">
        ${stateOptions}
        </select>`
        mainSection.html(html)
    } else {
        let html = `
        <input type="text" name="state[${track_id}]"  id="state${track_id}"
            class="form-control step_form_control">`

        mainSection.html(html)
    }


})

function backToTopBtn() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
}
