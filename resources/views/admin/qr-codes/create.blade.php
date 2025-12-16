@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-6 text-start">
                        <h5 style="color:#393185">Generate QR Codes</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('qr-codes.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('qr-codes.store') }}" class="p-4">
                    @csrf
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Number of QR Codes to Generate</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               placeholder="Enter quantity (1-10000)" min="1" max="10000" required
                               value="{{ old('quantity') }}">
                        @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Generate QR Codes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection