@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>
        nav#navbar_sticky {
            margin-bottom: 0px !important;
        }

        #about_hero {
            background-image: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url({{asset('assets/images/Breadcome.webp')}});
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .about_hero {
            position: relative;
        }


        #about_hero:before {
            content: "";
            display: block;
            position: absolute;
            mix-blend-mode: initial;
            opacity: .65;
            transition: .03s;
            border-radius: 0;
            border-style: initial;
            border-color: initial;
            border-block-start-width: 0px;
            border-inline-end-width: 0px;
            border-block-end-width: 0px;
            border-inline-start-width: 0px;
            top: calc(0px - 0px);
            left: calc(0px - 0px);
            width: max(100% +0px+0px, 100%);
            height: max(100% +0px+0px, 100%);
            background-color: #000;
        }


        .grids {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 30px;
        }

        .image img {
            width: 100%;
            border-radius: 20px;
        }

        .privacy_policy {
            padding: 30px;
        }

        .fw-400 {
            font-weight: 400;
        }

    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endpush
@section('content')
    <div class="about_hero">
        <div class="bg-dark text-secondary px-4 py-5 text-center" id="about_hero">
            <div class="py-5">
                <h1 class="display-5 fw-bold text-white">Terms & Conditions
                </h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="privacy_policy">
            <h4><strong>Introduction</strong></h4>
            <p>Welcome to ‘<strong>Steady Formation</strong>’ (“Company,” “we”, “our”, “us”)!</p>
            <p>These Terms of Service (“Terms,” “Terms of Service”) govern your use of our website located at
                <strong>https://steadyformation.com</strong> (together or individually “Service”) operated by <strong>Steady
                    Formation</strong>.
            </p>
            <p>Our Privacy Policy also governs your use of our service and explains how we collect, safeguard, and disclose
                information resulting from your web page use.</p>
            <p>Your agreement includes these ‘<strong>Terms</strong>’ and our ‘<strong>Privacy Policy</strong>’ (“Agreements”).
                You acknowledge that you have read and understood the Agreements and agree to be bound by them.</p>
            <p>If you do not agree with (or cannot comply with) Agreements, you may not use the service, but please let us know
                by
                emailing ‘<strong>support@steadyformation.com</strong>’ to find a solution. These Terms apply to all visitors,
                users, and others who wish to access or use <strong>Steady Formation</strong> Service.</p>
            <h4><strong>Communications</strong></h4>
            <p>Using our service, you agree to subscribe to newsletters, marketing or promotional materials, and other
                information
                we may send. However, you may opt out of receiving any communications from us by following the unsubscribe link or
                emailing <strong>support@steadyformation.com</strong>.</p>
            <h4><strong>Purchases</strong></h4>
            <p>Suppose you wish to purchase any product or service made available through service (“Purchase”). In that case,
                you
                may be asked to supply certain information relevant to your Purchase, including but not limited to your credit or
                debit card number, the expiration date of your card, your billing address, and your shipping information.</p>
            <p><strong>You represent and warrant that</strong> (i) You have the legal right to use any card(s) or other payment
                methods (s) in connection with any Purchase; and that (ii) the information you supply to us is true, correct, and
                complete.</p>
            <p>We may employ the use of third-party services to facilitate payment and the completion of Purchases. By
                submitting
                your information, you grant us the right to provide the information to these third parties subject to our Privacy
                Policy.</p>
            <p>We reserve the right to refuse or cancel your order at any time for reasons including but not limited to product
                or
                service availability, errors in the description or price of the product or service, errors in your order, or other
                reasons.</p>
            <p>We reserve the right to refuse or cancel your order if fraud or an unauthorized or illegal transaction is
                suspected.</p>
            <h4><strong>Contests, Sweepstakes, and Promotions</strong></h4>
            <p>Any contests, sweepstakes, or other promotions (collectively, “Promotions”) made available through service may be
                governed by rules separate from these Terms of Service. If you participate in any Promotions, please review the
                applicable rules as well as our Privacy Policy. If the rules for a Promotion conflict with these Terms of Service,
                Promotion rules will apply.</p>
            <h4><strong>Subscriptions</strong></h4>
            <p>Some parts of the service are billed on a subscription basis (“Subscription(s)”). In addition, you will be billed
                in advance on a recurring and periodic basis (“Billing Cycle”). Billing cycles will be set depending on the type
                of
                subscription plan you select when purchasing a Subscription.</p>
            <p>At the end of each Billing Cycle, your subscription will automatically renew under the same conditions unless you
                cancel it or <strong>Steady Formation</strong> cancels it. You may cancel your Subscription renewal either through
                your online account management page or by contacting the customer support team at
                <strong>support@steadyformation.com</strong>.
            </p>
            <p>A valid payment method is required to process the payment for your subscription. Therefore, you shall provide
                <strong>Steady Formation</strong> with accurate and complete billing information that may include but is limited
                to
                full name, address, state, postal or zip code, telephone number, and valid payment method information. By
                submitting
                such payment information, you automatically authorize <strong>Steady Formation</strong> to charge all Subscription
                fees incurred through your account to any such payment instruments.
            </p>
            <p>Should automatic billing fail to occur for any reason, <strong>Steady Formation</strong> reserves the right to
                terminate your access to the service immediately.</p>
            <h4><strong>Fee Changes</strong></h4>
            <p><strong>Steady Formation</strong>, in its sole discretion and at any time, may modify any Service fee and
                Subscription fees. Any fee change will become effective at the end of the then-current Billing Cycle.</p>
            <p><strong>Steady Formation</strong> will provide you with reasonable prior notice of any change in Subscription
                fees
                to allow you to terminate your Subscription before such change becomes effective.</p>
            <p>Your continued use of the service after the Subscription fee change comes into effect constitutes your agreement
                to
                pay the modified Subscription fee amount.</p>
            <h4><strong>Refunds</strong></h4>
            <p>Due to the nature of our business, Payment is for service, Which is non-refundable. In special cases, You may
                contact customer support at <strong>support@steadyformation.com</strong>.</p>
            <h4><strong>Content</strong></h4>
            <p><strong>Steady Formation</strong> has the right but not the obligation to monitor and edit all content users
                provide.</p>
            <p>In addition, content found on or through this service is the property of <strong>Steady Formation</strong> or
                used
                with permission. You may not distribute, modify, transmit, reuse, download, repost, copy, or use said content,
                whether in whole or in part, for commercial purposes or personal gain, without express advance written permission
                from us.</p>
            <h4><strong>No Use By Minors</strong></h4>
            <p>Service is intended only for access and use by individuals at least eighteen (18) years old. By accessing or
                using
                this service, you warrant and represent that you are at least eighteen (18) years of age and with the full
                authority, right, and capacity to enter into this agreement and abide by all of the terms and conditions of the
                Terms. If you are not at least eighteen (18) years old, you are prohibited from accessing and using the service.
            </p>
            <h4><strong>Accounts</strong></h4>
            <p>When you create an account with us, you guarantee that you are above 18 and that the information you provide us
                is
                accurate, complete, and current at all times. Inaccurate, incomplete, or obsolete information may result in the
                immediate termination of your account on service.</p>
            <p>You are responsible for maintaining the confidentiality of your account and password, including but not limited
                to
                restricting access to your computer and account. You agree to accept responsibility for any activities or actions
                under your account and password, whether your password is with our service or a third-party service. You must
                notify
                us immediately upon becoming aware of any security breach or unauthorized use of your account.</p>
            <p>You may not use as a username the name of another person or entity or that is not lawfully available for use, a
                name or trademark that is subject to any rights of another person or entity other than you, without appropriate
                authorization. In addition, you may not use any name that is offensive, vulgar, or obscene as a username.</p>
            <p>We reserve the right to refuse service, terminate accounts, remove or edit content, or cancel orders at our sole
                discretion.</p>
            <h4><strong>Intellectual Property</strong></h4>
            <p>Service and its original content (excluding content provided by users), features, and functionality are the
                exclusive property of <strong>Steady Formation</strong> and its licensors. Service is protected by copyright,
                trademark, and other laws of foreign countries. Our trademarks may not be used in connection with any product or
                service without the prior written consent of <strong>Steady Formation</strong>.</p>
            <h4><strong>Copyright Policy</strong></h4>
            <p>We respect the intellectual property rights of others. Accordingly, our policy is to respond to any claim that
                content posted on a service infringes on any person or entity’s copyright or other intellectual property rights
                (“Infringement”).</p>
            <p>If you are a copyright owner or authorized on behalf of one, and you believe that the copyrighted work has been
                copied in a way that constitutes copyright infringement, please submit your claim via email to
                <strong>support@steadyformation.com</strong>, with the subject line: “Copyright Infringement” and include in your
                claim a detailed description of the alleged infringement as detailed below, under “DMCA Notice and Procedure for
                Copyright Infringement Claims”
            </p>
            <p>You may be held accountable for damages (including costs and attorneys’ fees) for misrepresentation or bad-faith
                claims on the infringement of any Content found on and through service on your copyright.</p>
            <h4><strong>DMCA Notice and Procedure for Copyright Infringement Claims</strong></h4>
            <p>You may submit a notification according to the Digital Millennium Copyright Act (DMCA) by providing our Copyright
                Agent with the following information in writing (see 17 U.S.C 512(c)(3) for further detail):</p>
            <p>0.1. an electronic or physical signature of the person authorized to act on behalf of the owner of the
                copyright’s
                interest;<br>0.2. a description of the copyrighted work that you claim has been infringed, including the URL
                (i.e.,
                web page address) of the location where the copyrighted work exists or a copy of the copyrighted work;<br>0.3.
                identification of the URL or other specific location on service where the material that you claim is infringing is
                located;<br>0.4. your address, telephone number, and email address;<br>0.5. a statement by you that you have a
                good
                faith belief that the disputed use is not authorized by the copyright owner, its agent, or the law;<br>0.6. a
                statement by you, made under penalty of perjury, that the above information in your notice is accurate and that
                you
                are the copyright owner or authorized to act on the copyright owner’s behalf.<br>You can contact our Copyright
                Agent
                via email at <strong>support@steadyformation.com</strong>.</p>
            <h4><strong>Error Reporting and Feedback</strong></h4>
            <p>You may provide us directly at <strong>support@steadyformation.com</strong> or via third-party sites and tools
                with
                information and Feedback concerning errors, suggestions for improvements, ideas, problems, complaints, and other
                matters related to our service (“Feedback”). You acknowledge and agree that:</p>
            <ol>
                <li>You shall not retain, acquire, or assert any intellectual property right or another right, title, or interest
                    in
                    or to the Feedback.</li>
                <li>The Company may have developed ideas similar to those in the Feedback.</li>
                <li>Feedback does not contain confidential or proprietary information from you or any third party.</li>
                <li>The Company is not under any obligation of confidentiality concerning the Feedback.</li>
            </ol>
            <p>In the event the transfer of ownership to the feedback is not possible due to applicable mandatory laws, you
                grant
                the Company and its affiliates an exclusive, transferable, irrevocable, free-of-charge, sub-licensable, unlimited,
                and perpetual right to use (including copy, modify, create derivative works, publish, distribute, and
                commercialize)
                the feedback in any manner and for any purpose.</p>
            <p>If you experience a delay or disruption in service caused by a third-party provider, please contact us
                immediately.
                We may help you to find a resolution as quickly as possible.</p>
            <h4><strong>Links to Other Websites and Third-Party</strong></h4>
            <p>Our Service may contain links to third-party websites or services that are not owned or controlled by Steady
                Formation.</p>
            <p>Steady Formation has no control over and assumes no responsibility for any third-party websites or services’
                content, privacy policies, or practices. Accordingly, we do not warrant the offerings of any of these
                entities/individuals or their websites.</p>
            <p>You acknowledge and agree that the Company shall not be responsible or liable, directly or indirectly, for any
                damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content,
                goods, or services available on or through any such third-party web sites or services.</p>
            <p>We strongly advise you to read the terms of service and privacy policies of any third-party websites or services
                you visit.</p>
            <h4><strong>Disclaimer of Warranty</strong></h4>
            <p>The Company provides these services on an “as is” and “as available” basis. The Company makes no representations
                or
                warranties of any kind, express or implied, regarding the operation of its services or the information, content,
                or
                materials included therein. You expressly agree that using these services, their content, and any services or
                items
                obtained from us is at your sole risk.</p>
            <p>Neither the Company nor anyone associated with the Company makes any warranty or representation concerning the
                services’ completeness, security, reliability, quality, accuracy, or availability. Without limiting the preceding,
                neither the Company nor anyone associated with the Company represents or warrants that the services, their
                content,
                or any services or items obtained through the services will be accurate, reliable, error-free, or uninterrupted,
                that defects will be corrected, that the services or the server that makes it available are free of viruses or
                other
                harmful components or that the services or any services or items obtained through the services will otherwise meet
                your needs or expectations.</p>
            <p>With the services associated with third parties, as they are the ultimate decision-makers, we cannot fully assure
                you of the services connected to them.</p>
            <p>The Company hereby disclaims all warranties of any kind, whether express or implied, statutory or otherwise,
                including but not limited to any warranties of merchantability, non-infringement, and fitness for a particular
                purpose.</p>
            <p>The preceding does not affect any warranties, which cannot be excluded or limited under applicable law.</p>
            <p>We provide access to financial services through third-party providers, such as PayPal, Stripe, and business bank
                accounts. However, we do not directly provide these financial services and cannot be held responsible for any
                delays, disruptions, or other issues caused by these third-party providers.</p>
            <h4><strong>Limitation of Liability</strong></h4>
            <p>Unless the law prohibits it, you will hold us and our officers, directors, employees, and agents harmless for any
                indirect, punitive, special, incidental, or consequential damage. However, it arises (including attorneys’ fees
                and
                all related costs and expenses of litigation and arbitration, or at trial or on appeal, if any, whether or not
                litigation or arbitration is instituted), whether in an action of contract, negligence, or other tortious action,
                or
                arising out of or in connection with this agreement, including without limitation any claim for personal injury or
                property damage, arising from this agreement and any violation by you of any federal, state, or local laws,
                statutes, rules, or regulations, even if Company has been previously advised of the possibility of such damage.
            </p>
            <p>Except as prohibited by law, if there is liability found on the part of the Company, it will be limited to the
                amount paid for the products and services. Under no circumstances will there be consequential or punitive damages.
                Some states do not allow the exclusion or limitation of punitive, incidental, or consequential damages, so the
                prior
                limitation or exclusion may not apply to you.</p>
            <p>We won’t take liability for any service failure that has not directly occurred due to us. We are not liable for
                any
                delays or disruptions in service associated with third-party providers. This includes, but is not limited to,
                delays
                in delivery of goods or services, technical problems, or other unforeseen circumstances.</p>
            <p>Once we have delivered any service related to third parties, we won’t be liable for any circumstances you may
                face,
                though we may help to resolve the issue.</p>
            <h4><strong>Termination</strong></h4>
            <p>We may terminate or suspend your account and bar access to service immediately, without prior notice or
                liability,
                under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach
                of Terms.</p>
            <p>You may discontinue using the service if you wish to terminate your account.</p>
            <p>All provisions of Terms that by their nature should survive termination shall survive termination, including,
                without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>
            <h4><strong>Governing Law</strong></h4>
            <p>These Terms shall be governed and construed following the laws of the USA and England &amp; Wales, which
                governing
                law applies to an agreement without regard to its conflict of law provisions.</p>
            <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If
                any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these
                Terms will remain in effect. These Terms constitute our entire agreement regarding our service and supersede and
                replace any prior service agreements.</p>
            <p>&nbsp;</p>
            <h4><strong>Changes to Service</strong></h4>
            <p>We reserve the right to withdraw or amend our service and any service or material we provide via service, in our
                sole discretion, without notice. We will not be liable if for any reason all or any part of the service is
                unavailable at any time or for any period. From time to time, we may restrict access to some parts of the service,
                or the entire service, to users, including registered users.</p>
            <h4><strong>Amendments to Terms</strong></h4>
            <p>We may amend the Terms at any time by posting the amended terms on this site. Therefore, it is your
                responsibility
                to review these Terms periodically.</p>
            <p>Your continued use of the Platform following the posting of revised Terms means that you accept and agree to the
                changes. You are expected to check this page frequently to be aware of any changes, as they are binding on you.
            </p>
            <p>By continuing to access or use our Service after any revisions become effective, you agree to be bound by the
                revised terms. You are no longer authorized to use the service if you do not agree to the new terms.</p>
            <p>&nbsp;</p>
            <h4><strong>Waiver and Severability</strong></h4>
            <p>No waiver by the Company of any term or condition outlined in Terms shall be deemed a further or continuing
                waiver
                of such term or condition or a waiver of any other term or condition, and any failure of the Company to assert a
                right or provision under Terms shall not constitute a waiver of such right or provision.</p>
            <p>Suppose a court or other tribunal of competent jurisdiction holds any provision of Terms as invalid, illegal, or
                unenforceable for any reason. In that case, such provision shall be eliminated or limited to the minimum extent
                such
                that the remaining provisions of the Terms will continue in full force and effect.</p>
            <h4><strong>Acknowledgment</strong></h4>
            <p>By using our services, you acknowledge that you have read these terms of service and agree to be bound by them.
            </p>
            <h4><strong>Contact Us</strong></h4>
            <p>Please send your feedback, comments, and requests for technical support by email: at
                <strong>support@steadyformation.com</strong>.
            </p>
        </div>
    </div>

    @include('web.layouts.footer')
@endsection
@push('js')
@endpush
