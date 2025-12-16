@extends('admin.layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Create New User</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_number">Mobile Number *</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                            value="{{ old('mobile_number') }}" required>
                                        @error('mobile_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="property_type">Property Type</label>
                                        <select class="form-control" id="property_type" name="property_type">
                                            <option value="">Select Property Type</option>
                                            <option value="apartment" {{ old('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                            <option value="house" {{ old('property_type') == 'house' ? 'selected' : '' }}>House</option>
                                            <option value="villa" {{ old('property_type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                            <option value="plot" {{ old('property_type') == 'plot' ? 'selected' : '' }}>Plot</option>
                                            <option value="commercial" {{ old('property_type') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                                        </select>
                                        @error('property_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="budget">Budget</label>
                                        <input type="text" class="form-control" id="budget" name="budget"
                                            value="{{ old('budget') }}">
                                        @error('budget')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="preferred_location">Preferred Location</label>
                                        <input type="text" class="form-control" id="preferred_location" name="preferred_location"
                                            value="{{ old('preferred_location') }}">
                                        @error('preferred_location')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="source_of_visit">Source of Visit</label>
                                        <select class="form-control" id="source_of_visit" name="source_of_visit">
                                            <option value="">Select Source</option>
                                            <option value="social_media" {{ old('source_of_visit') == 'social_media' ? 'selected' : '' }}>Social Media</option>
                                            <option value="website" {{ old('source_of_visit') == 'website' ? 'selected' : '' }}>Website</option>
                                            <option value="referral" {{ old('source_of_visit') == 'referral' ? 'selected' : '' }}>Referral</option>
                                            <option value="advertisement" {{ old('source_of_visit') == 'advertisement' ? 'selected' : '' }}>Advertisement</option>
                                            <option value="walk_in" {{ old('source_of_visit') == 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                                        </select>
                                        @error('source_of_visit')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="qr_code_id">Select QR Code</label>
                                        <select class="form-control" id="qr_code_id" name="qr_code_id">
                                            <option value="">Select QR Code (Optional)</option>
                                            @foreach($qrCodes as $qrCode)
                                                <option value="{{ $qrCode->id }}" {{ old('qr_code_id') == $qrCode->id ? 'selected' : '' }}>
                                                    {{ $qrCode->qr_code_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('qr_code_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_status">Payment Status *</label>
                                        <select id="payment_status" name="payment_status" class="form-control" >
                                            <option value="">Select Payment Status</option>
                                            <option value="cash">Cash</option>
                                            <option value="upi">UPI</option>
                                            <option value="free">Free</option>
                                        </select>
                                        @error('payment_status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div> --}}
                            </div>
                            <button type="submit" class="btn btn-primary">Create User</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
