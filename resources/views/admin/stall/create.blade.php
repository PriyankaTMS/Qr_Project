@extends('admin.layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Create New Stall</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('stalls.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stall_no">Stall No</label>
                                        <input type="text" class="form-control" id="stall_no" name="stall_no"
                                            value="{{ old('stall_no') }}" required>
                                        @error('stall_no')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stall_name">Stall Name</label>
                                        <input type="text" class="form-control" id="stall_name" name="stall_name"
                                            value="{{ old('stall_name') }}" required>
                                        @error('stall_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business">Business</label>
                                        <input type="text" class="form-control" id="business" name="business"
                                            value="{{ old('business') }}">
                                        @error('business')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stall_user_name">Stall User Name</label>
                                        <input type="text" class="form-control" id="stall_user_name"
                                            name="stall_user_name" value="" required>
                                        @error('stall_user_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            value="{{ old('mobile') }}" required>
                                        @error('mobile')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website">Website(Optional)</label>
                                        <input type="text" class="form-control" id="website" name="website"
                                            value="{{ old('website') }}">

                                        @error('website')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            autocomplete="off" value="" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{--  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            autocomplete="new-password" required>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>  --}}
                            

                                <div class="col-md-6">
                                    <div class="form-group" style="position: relative;">
                                        <label for="password">Password</label>

                                        <input type="password" class="form-control pe-5" id="password" name="password"
                                            autocomplete="new-password" required>

                                        <!-- Eye icon -->
                                        <i class="fa-solid fa-eye" id="toggleIcon" onclick="togglePassword()"
                                            style="position:absolute; right:12px; top:40px; cursor:pointer; font-size:18px; color:#555;">
                                        </i>

                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>



                            </div>
                            <button type="submit" class="btn btn-primary">Create Stall</button>
                            <a href="{{ route('stalls.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            var icon = document.getElementById("toggleIcon");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
