@extends('layouts.app')

@section('content')
    <style>
        .policy-card {
            border-radius: 20px;
            background: #ffffff;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .policy-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .policy-title {
            font-size: 32px;
            font-weight: 700;
            color: #4A148C;
        }

        .policy-section-title {
            font-size: 22px;
            font-weight: 600;
            margin-top: 25px;
            color: #333;
        }

        .policy-text {
            font-size: 16px;
            line-height: 1.7;
            color: #555;
            margin-top: 10px;
        }

        @media (max-width: 576px) {
            .policy-title {
                font-size: 26px;
            }

            .policy-card {
                padding: 25px;
            }
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="policy-card">
                    <h2 class="policy-title text-center mb-4">AIMA INDEX 2025 – Privacy Policy</h2>

                    {{--  <p class="text-muted text-center">Last Updated: 25th Nov 2025</p>  --}}

                    <p class="policy-text">
                        This Privacy Policy describes how <strong>AIMA INDEX 2025</strong> we collects, uses, stores, and
                        protects the personal information of users who interact
                        with our web application developed for the AIMA INDEX 2025 Exhibition. By accessing
                        or using this web application, you agree to the terms of this Privacy Policy.
                    </p>

                    <h4 class="policy-section-title">Privacy Commitment</h4>
                    <p class="policy-text">
                        We ask only for the minimum information required to run the exhibition system
                        efficiently and securely. We do not sell user data or share it for advertising or
                        external marketing purposes. We collect information only to run operational processes
                        for exhibition registration, stall management, entry control, and QR-based visitor
                        tracking. We are committed to transparency and user privacy.
                    </p>

                    <h4 class="policy-section-title">Information We Collect</h4>
                    <p class="policy-text">
                        We collect only basic details such as name, mobile number, email, city, and details
                        required for visitor/exhibitor registration. A unique QR code is generated for event
                        entry. We also store limited system data like IP address, device information, and scan
                        logs to operate the event smoothly.
                    </p>

                    <h4 class="policy-section-title">How We Use Your Data</h4>
                    <p class="policy-text">
                        Your data is used exclusively for event operations such as registration, stall
                        scanning, entry control, security, and communication.
                    </p>

                    <h4 class="policy-section-title">Data Sharing Policy</h4>
                    <p class="policy-text">
                        We do not sell or share your data for marketing purposes. Data is shared only with
                        authorized event organizers and exhibitors when they scan your QR code for valid
                        operational reasons.
                    </p>

                    <h4 class="policy-section-title">Data Retention</h4>
                    <p class="policy-text">
                        All information is stored securely for up to <strong>12 months</strong> and then deleted.
                    </p>

                    <h4 class="policy-section-title">Your Rights</h4>
                    <p class="policy-text">
                        You can request access, update, or removal of your data at any time by contacting us.
                    </p>

                    <h4 class="policy-section-title">Contact Information</h4>
                    <p class="policy-text">
                        For any privacy-related queries, please contact:<br>
                        <strong>AIMA INDEX 2025</strong><br>
                        Email: <strong>[aimaadmin@aimanashik.org]</strong><br>
                        Phone: <strong>[+91 9309491885]</strong><br>
                        Address: <strong>[ Thakkar Dome, Nashik]</strong>
                    </p>

                    <div class="text-center mt-4">
                        <a href="{{ url('/') }}" class="btn  px-4" style="background: #5A3279;color:#ffff;">Back to
                            Home</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
