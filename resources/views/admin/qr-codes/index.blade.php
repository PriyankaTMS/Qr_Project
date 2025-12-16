@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-6 text-start">
                        <h5 style="color:#393185">QR Codes List</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('qr-codes.create') }}" class="btn btn-primary btn-sm">Generate New QR Codes</a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">QR Code No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">QR Image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($qrCodes as $qrCode)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $qrCode->id }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $qrCode->qr_code_no }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $qrCode->created_at->format('d-m-Y H:i') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <img src="{{ asset('Qr_images/' . $qrCode->qr_code_image) }}" alt="QR Code" style="width:50px; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#qrModal" data-bs-image="{{ asset('Qr_images/' . $qrCode->qr_code_image) }}" data-bs-code="{{ $qrCode->qr_code_no }}">
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('qr-codes.show', $qrCode->id) }}" class="text-secondary font-weight-bold text-xs">
                                            <span class="badge badge-sm bg-gradient-info">View</span>
                                        </a>
                                        <form action="{{ route('qr-codes.destroy', $qrCode->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this QR code?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent">
                                                <span class="badge badge-sm bg-gradient-danger">Delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No QR codes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $qrCodes->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5 id="modalQrCode" class="mb-3"></h5>
                <img id="modalQrImage" src="" alt="QR Code" style="max-width:100%; height:auto;">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var qrModal = document.getElementById('qrModal');
    qrModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var imageSrc = button.getAttribute('data-bs-image');
        var qrCode = button.getAttribute('data-bs-code');

        var modalImage = qrModal.querySelector('#modalQrImage');
        var modalCode = qrModal.querySelector('#modalQrCode');

        modalImage.src = imageSrc;
        modalCode.textContent = qrCode;
    });
});
</script>
@endsection