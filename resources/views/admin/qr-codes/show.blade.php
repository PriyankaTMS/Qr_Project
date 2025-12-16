@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-6 text-start">
                        <h5 style="color:#393185">QR Code Details</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('qr-codes.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>ID:</strong> {{ $qrCode->id }}</h6>
                            <h6><strong>QR Code No:</strong> {{ $qrCode->qr_code_no }}</h6>
                            <h6><strong>Created At:</strong> {{ $qrCode->created_at->format('d-m-Y H:i:s') }}</h6>
                        </div>
                        <div class="col-md-6 text-center">
                            <h6><strong>QR Code Image:</strong></h6>
                            <img src="{{ asset('Qr_images/' . $qrCode->qr_code_image) }}" alt="QR Code" style="max-width:300px; height:auto;">
                            <br><br>
                            <p class="text-muted">Scan this QR code to see: <strong>{{ $qrCode->qr_code_no }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection