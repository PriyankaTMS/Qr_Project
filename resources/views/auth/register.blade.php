@extends('layouts.app')

@section('content')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            background: #f5f5f5;
        }

        .register-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.12);
            padding: 25px 30px;
            position: relative;
        }

        .logo-left {
            width: 80px;
            position: absolute;
            top: -28px;
            left: -22px;
        }

        .logo-right {
            width: 80px;
            position: absolute;
            top: -28px;
            right: -22px;
        }

        .form-control {
            border-radius: 8px;
        }

        .card-header {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            border-bottom: none;
            margin-bottom: 10px;
            color: #4C4C4C;
        }

        .btn-primary {
            width: 100%;
            border-radius: 30px;
            padding: 10px;
            background: #5A3279;
            border: none;
            font-size: 16px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #472660;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 2px solid #eee;
            padding: 15px 20px;
            position: relative;
        }

        .header-title {
            font-size: 18px;
            font-weight: 600;
            color: #4C4C4C;
        }

        .header-logo {
            width: 60px;
            height: auto;
            object-fit: contain;
        }

        @media(max-width: 576px) {
            .card-header {
                flex-direction: column;
                text-align: center;
                gap: 6px;
            }

            .header-logo {
                width: 50px;
            }
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="register-card" style="margin-top:-5%;">

                    {{--  <div class="card-header">
                        <div>Exhibition Visitor Registration</div>
                        <!-- Left Logo -->
                        <img src="{{ asset('stallmaillogo.png') }}" class="logo-left" alt="Left Logo">

                        <!-- Right Logo -->
                        <!--<img src="{{ asset('sublogo.png') }}" class="logo-right" alt="Right Logo">-->
                    </div>  --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Left Logo -->
                        <img src="{{ asset('stallmaillogo.png') }}" class="header-logo" alt="Left Logo" style="width:150px;">



                        <!-- Right Logo -->
                        <!--<img src="{{ asset('sublogo.png') }}" class="header-logo" alt="Right Logo" style="width:110px;">-->
                    </div>


                    <form method="POST" action="/register">
                        @csrf
                        <div class="text-center mb-3">
                            <span class="header-title text-center" style="color:#393185;">Exhibition Visitor
                                Registration</span>
                        </div>

                        {{-- Full Name --}}
                        <div class="mb-3">
                            <label class="form-label"> Name*</label>
                            <input type="text" name="name" placeholder="Enter your name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required>
                        </div>

                        {{-- Company Name --}}
                        {{-- <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="comp_name" placeholder="Enter company name"
                                class="form-control @error('comp_name') is-invalid @enderror"
                                value="{{ old('comp_name') }}">
                        </div> --}}

                        {{-- Occupation --}}
                        {{-- <div class="mb-3">
                            <label class="form-label">Occupation</label>
                            <input type="text" name="occupation" placeholder="Enter your occupation"
                                class="form-control @error('occupation') is-invalid @enderror"
                                value="{{ old('occupation') }}">
                        </div> --}}

                        {{-- Mobile --}}
                        <div class="mb-3">
                            <label class="form-label">Mobile No.*</label>
                            <input type="text" name="phone" placeholder="Enter 10 digit mobile number"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                required>
                        </div>

                        {{-- QR Code Selection --}}
                        <div class="mb-3">
                            <label class="form-label">Select QR Code</label>
                            <select name="qr_code_id" id="qr_code_id" class="form-control @error('qr_code_id') is-invalid @enderror">
                                <option value="">Select QR Code (Optional)</option>
                                @foreach($qrCodes as $qrCode)
                                    <option value="{{ $qrCode->id }}" {{ old('qr_code_id') == $qrCode->id ? 'selected' : '' }}>
                                        {{ $qrCode->qr_code_no }}
                                    </option>
                                @endforeach
                            </select>
                            @error('qr_code_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        {{-- <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" placeholder="Enter email address"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                 autocomplete="off">
                        </div> --}}

                        {{-- City --}}
                        <div class="mb-3">
                            <label class="form-label">Property Type</label>
                            <input type="text" name="property_type" placeholder="Enter Property Type"
                                class="form-control @error('property_type') is-invalid @enderror"
                                value="{{ old('property_type') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Budget</label>
                            <input type="text" name="budget" placeholder="Enter Budget"
                                class="form-control @error('budget') is-invalid @enderror" value="{{ old('budget') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prefered Location</label>
                            <input type="text" name="prefered_location" placeholder="Enter Prefered Location"
                                class="form-control @error('prefered_location') is-invalid @enderror"
                                value="{{ old('prefered_location') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Source of Visite</label>
                            <input type="text" name="source_of_visite" placeholder="Enter Source of Visite"
                                class="form-control @error('source_of_visite') is-invalid @enderror"
                                value="{{ old('source_of_visite') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Register Now</button>

                    </form>
                    <!--<div class="text-center mt-4" style="font-size: 13px; color:#6c757d;">-->
                    <!--    © <script>
                        document.write(new Date().getFullYear())
                    </script>,-->
                    <!--    made <i class="fa fa-heart" style="color:red;"></i> by-->
                    <!--    <a href="https://techmetsolutions.com/#/" class="font-weight-bold" target="_blank"-->
                    <!--       style="color:#f97316;">TechMET Solutions</a>-->
                    <!--    And Team.-->
                    <!--</div>-->
                    <div class="text-center mt-4" style="font-size:13px; color:#6c757d;">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        Designed & Developed by
                        <a href="https://techmetsolutions.com/#/" target="_blank"
                            style="font-weight:600; color:#f97316; text-decoration:none;">
                            TechMET Solutions
                        </a>.
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#qr_code_id').select2({
            placeholder: 'Search and select QR Code',
            allowClear: true
        });
    });
    </script>

    <style>
    .select2-selection.select2-selection--single {
        height: 40px !important;
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }
    .select2-selection__rendered {
        line-height: 24px !important;
        padding-left: 12px !important;
    }
    .select2-selection__arrow {
        height: 38px !important;
    }
    </style>
@endsection
