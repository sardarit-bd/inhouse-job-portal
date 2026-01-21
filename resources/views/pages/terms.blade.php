@extends('layouts.app')
@section('title', 'Terms and Conditions - ' . config('app.name', 'SardarIT Career Portal'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10 text-center">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">
                Terms & Conditions
            </h1>
            <p class="mt-3 text-sm text-gray-500">
                Last updated: {{ date('F d, Y') }}
            </p>
        </div>

        <div class="space-y-8 text-gray-700 leading-relaxed">
            <!-- Intro -->
            <p>
                Welcome to the <strong>{{ config('app.name') }}</strong>.
                By accessing or using this website, you agree to comply with and be bound
                by the following Terms & Conditions. If you do not agree, please do not
                use this portal.
            </p>

            <!-- Section -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    1. Purpose of the Career Portal
                </h2>
                <p>
                    This portal is designed to share employment opportunities and allow
                    candidates to apply for positions within our organization. Any other
                    use is strictly prohibited.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    2. Eligibility & Accuracy of Information
                </h2>
                <p>
                    By submitting an application, you confirm that all information
                    provided is accurate, complete, and truthful. Providing false or
                    misleading information may result in disqualification or termination
                    of employment if hired.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    3. Application & Hiring Process
                </h2>
                <p>
                    Submitting an application does not guarantee an interview or job
                    offer. We reserve the right to shortlist candidates based on our
                    internal hiring requirements and business needs.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    4. No Employment Guarantee
                </h2>
                <p>
                    Nothing on this portal constitutes an offer of employment or a
                    contract. Any employment relationship will be governed by separate
                    written agreements and company policies.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    5. Data Privacy
                </h2>
                <p>
                    Personal information submitted through this portal will be collected,
                    stored, and processed solely for recruitment purposes, in accordance
                    with our Privacy Policy.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    6. Prohibited Activities
                </h2>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Submitting false or automated applications</li>
                    <li>Uploading malicious code or harmful content</li>
                    <li>Attempting to access restricted areas of the portal</li>
                    <li>Misusing or disrupting the system</li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    7. Limitation of Liability
                </h2>
                <p>
                    We shall not be liable for any technical issues, data loss, or damages
                    arising from the use of this portal. Use of the website is at your own
                    risk.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    8. Changes to These Terms
                </h2>
                <p>
                    We reserve the right to modify these Terms & Conditions at any time.
                    Continued use of the portal indicates acceptance of the updated terms.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    9. Governing Law
                </h2>
                <p>
                    These Terms & Conditions shall be governed and interpreted in
                    accordance with the laws of <strong>The People's Republic of Bangladesh</strong>.
                </p>
            </div>

            <!-- Footer -->
            <div class="pt-6 border-t text-sm text-gray-500">
                For questions, contact us at
                <a href="mailto:careers@yourcompany.com" class="text-blue-600 hover:underline">
                    career@sardarit.com
                </a>
            </div>
        </div>

    </div>
@endsection
