@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow p-4 text-center">

                    <h3 class="text-primary fw-bold">Verify Your Phone Number</h3>

                    <p class="mt-3">
                        Hello <strong>{{ $user->name }}</strong>, an OTP has been sent to your WhatsApp number <strong>{{ $user->phone }}</strong>. Please enter it below to verify.
                    </p>

                    <form method="POST" action="{{ route('verify-otp.post', $user->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" class="form-control text-center" id="otp" name="otp" maxlength="6" required>
                            @error('otp')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Verify OTP</button>
                    </form>

                    <a href="{{ route('home.register') }}" class="btn btn-secondary mt-3">
                        Back to Registration
                    </a>

                </div>

            </div>
        </div>
    </div>
@endsection