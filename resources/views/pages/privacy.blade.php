@extends('layouts.app')
@section('title', 'Privacy Policy - ' . config('app.name', 'SardarIT Career Portal'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10 text-center">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">
                Privacy Policy
            </h1>
            <p class="mt-3 text-sm text-gray-500">
                Last updated: {{ date('F d, Y') }}
            </p>
        </div>

        <div class="space-y-8 text-gray-700 leading-relaxed">
            <!-- Intro -->
            <p>
                At <strong>{{ config('app.name') }}</strong>, we value your privacy and are committed
                to protecting your personal information. This Privacy Policy explains how we collect,
                use, store, and safeguard your data when you use our career portal.
            </p>

            <!-- Section 1 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    1. Information We Collect
                </h2>
                <p class="mb-3">
                    When you apply for a position through our portal, we may collect the following information:
                </p>
                <ul class="list-disc pl-6 space-y-1">
                    <li><strong>Personal Information:</strong> Name, email address, phone number, date of birth,
                        nationality, and address</li>
                    <li><strong>Professional Information:</strong> Resume/CV, educational qualifications, work experience,
                        skills, and references</li>
                    <li><strong>Application Data:</strong> Job preferences, cover letters, and portfolio materials</li>
                    <li><strong>Technical Information:</strong> IP address, browser type, device information, and usage
                        patterns</li>
                </ul>
            </div>

            <!-- Section 2 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    2. How We Use Your Information
                </h2>
                <p class="mb-3">
                    We use the collected information for the following purposes:
                </p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>To process and evaluate your job application</li>
                    <li>To communicate with you regarding your application status</li>
                    <li>To verify your credentials and conduct background checks if required</li>
                    <li>To maintain our applicant database for future opportunities</li>
                    <li>To improve our recruitment process and portal functionality</li>
                    <li>To comply with legal and regulatory requirements</li>
                </ul>
            </div>

            <!-- Section 3 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    3. Data Storage and Security
                </h2>
                <p>
                    We implement appropriate technical and organizational measures to protect your
                    personal information against unauthorized access, alteration, disclosure, or
                    destruction. Your data is stored on secure servers with encryption and access
                    controls. However, no method of transmission over the internet is 100% secure,
                    and we cannot guarantee absolute security.
                </p>
            </div>

            <!-- Section 4 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    4. Data Retention
                </h2>
                <p>
                    We retain your application data for as long as necessary to fulfill recruitment
                    purposes and comply with legal obligations. Typically, application records are
                    kept for up to 2 years after the recruitment process concludes, unless you
                    request earlier deletion or we are required by law to retain them longer.
                </p>
            </div>

            <!-- Section 5 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    5. Sharing of Information
                </h2>
                <p class="mb-3">
                    We do not sell, rent, or trade your personal information. However, we may share
                    your data in the following circumstances:
                </p>
                <ul class="list-disc pl-6 space-y-1">
                    <li><strong>Internal Sharing:</strong> With hiring managers and HR personnel involved in the recruitment
                        process</li>
                    <li><strong>Third-Party Services:</strong> With trusted service providers who assist with background
                        verification, assessment tools, or portal maintenance</li>
                    <li><strong>Legal Requirements:</strong> When required by law, court order, or government authorities
                    </li>
                    <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets</li>
                </ul>
            </div>

            <!-- Section 6 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    6. Your Rights
                </h2>
                <p class="mb-3">
                    You have the following rights regarding your personal data:
                </p>
                <ul class="list-disc pl-6 space-y-1">
                    <li><strong>Access:</strong> Request a copy of the personal information we hold about you</li>
                    <li><strong>Correction:</strong> Request correction of inaccurate or incomplete information</li>
                    <li><strong>Deletion:</strong> Request deletion of your data, subject to legal retention requirements
                    </li>
                    <li><strong>Withdrawal:</strong> Withdraw your application and consent to data processing at any time
                    </li>
                    <li><strong>Objection:</strong> Object to certain types of data processing</li>
                </ul>
                <p class="mt-3">
                    To exercise these rights, please contact us at
                    <a href="mailto:privacy@sardarit.com" class="text-blue-600 hover:underline">privacy@sardarit.com</a>
                </p>
            </div>

            <!-- Section 7 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    7. Cookies and Tracking Technologies
                </h2>
                <p>
                    Our portal uses cookies and similar tracking technologies to enhance user
                    experience, analyze portal usage, and maintain session information. You can
                    control cookie preferences through your browser settings, but disabling cookies
                    may affect portal functionality.
                </p>
            </div>

            <!-- Section 8 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    8. Children's Privacy
                </h2>
                <p>
                    Our career portal is not intended for individuals under the age of 18. We do
                    not knowingly collect personal information from minors. If we become aware that
                    we have inadvertently collected data from a minor, we will take steps to delete
                    such information promptly.
                </p>
            </div>

            <!-- Section 9 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    9. International Data Transfers
                </h2>
                <p>
                    Your information may be transferred to and processed in countries other than
                    your country of residence. We ensure appropriate safeguards are in place to
                    protect your data in accordance with this Privacy Policy and applicable laws.
                </p>
            </div>

            <!-- Section 10 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    10. Changes to This Privacy Policy
                </h2>
                <p>
                    We may update this Privacy Policy from time to time to reflect changes in our
                    practices or legal requirements. We will notify you of significant changes by
                    posting the updated policy on this page with a new "Last updated" date.
                    Continued use of the portal after changes indicates your acceptance of the
                    updated policy.
                </p>
            </div>

            <!-- Section 11 -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    11. Contact Us
                </h2>
                <p>
                    If you have any questions, concerns, or requests regarding this Privacy Policy
                    or our data practices, please contact us at:
                </p>
                <div class="mt-3 pl-4">
                    <p><strong>{{ config('app.name') }}</strong></p>
                    <p>Email: <a href="mailto:privacy@sardarit.com"
                            class="text-blue-600 hover:underline">privacy@sardarit.com</a></p>
                    <p>Career Portal: <a href="mailto:career@sardarit.com"
                            class="text-blue-600 hover:underline">career@sardarit.com</a></p>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-6 border-t text-sm text-gray-500">
                <p>
                    This Privacy Policy is governed by the laws of
                    <strong>The People's Republic of Bangladesh</strong>.
                    By using our career portal, you acknowledge that you have read and understood
                    this Privacy Policy.
                </p>
            </div>
        </div>

    </div>
@endsection
