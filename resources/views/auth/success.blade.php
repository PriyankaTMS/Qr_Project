@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow p-4 text-center">

                    <h3 class="text-success fw-bold">🎉 Registration Successful!</h3>

                    <p class="mt-3">
                        Thank you for registering. Your ID Card is ready for download.
                    </p>

                    @if (session('user_id'))
                        {{-- <a href="{{ route('user.id-card', session('user_id')) }}" class="btn btn-primary mt-3">
                            Download ID Card
                        </a> --}}
                        <a href="{{ route('users.print', session('user_id')) }}" class="btn btn-primary mt-3">
                            Download QR
                        </a>
                    @endif

                    <a href="{{ route('register') }}" class="btn btn-secondary mt-3">
                        Back to Registration
                    </a>

                </div>

            </div>
        </div>
    </div>
@endsection
