@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6 text-start">
                            <h5 style="color:#393185">Users table</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add New User</a>
                        </div>
                    </div>


                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif



                    <!-- Register Date Count Filter -->
                    <div class="d-flex justify-content-end mb-3">

                        <form method="GET" action="{{ route('users.index') }}"
                            class="d-inline-flex align-items-center gap-2 flex-wrap">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if (request('payment_status'))
                                <input type="hidden" name="payment_status" value="{{ request('payment_status') }}">
                            @endif
                            @if (request('register_date'))
                                <input type="hidden" name="register_date" value="{{ request('register_date') }}">
                            @endif
                            <label for="register_date_count" class="form-label mb-0 me-1 fw-bold text-secondary"
                                style="font-size: 0.875rem;">Register Date (Count Only):</label>
                            <input type="date" class="form-control form-control-sm" name="register_date_count"
                                value="{{ request('register_date_count') }}" style="width: auto; min-width: 150px;">
                            <button class="btn btn-sm btn-primary" type="submit">Get Count</button>
                            <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="location.href='{{ route('users.index') }}'">Clear</button>
                        </form>
                        @if (request('register_date_count'))
                            @if ($register_date_count > 0)
                                <div class="alert alert-info d-inline-flex align-items-center gap-1 p-2 me-2"
                                    style="margin-left: 15px;">
                                    <strong>Count:</strong> {{ $register_date_count }}
                                </div>
                            @else
                                <div class="alert alert-warning d-inline-flex align-items-center gap-1 p-2 me-2"
                                    style="margin-left: 15px;">
                                    <strong>No users found.</strong>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Filters Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('users.index') }}"
                                class="d-flex flex-wrap align-items-end gap-3">
                                @if (request('register_date_count'))
                                    <input type="hidden" name="register_date_count"
                                        value="{{ request('register_date_count') }}">
                                @endif
                                <div class="flex-fill">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search by name, email, etc." value="{{ request('search') }}">
                                </div>
                                <div class="flex-fill">
                                    <label for="payment_status" class="form-label">Payment Status</label>
                                    <select class="form-control" name="payment_status">
                                        <option value="">All</option>
                                        <option value="free" {{ request('payment_status') == 'free' ? 'selected' : '' }}>
                                            Free</option>
                                        <option value="cash" {{ request('payment_status') == 'cash' ? 'selected' : '' }}>
                                            Cash</option>
                                        <option value="upi" {{ request('payment_status') == 'upi' ? 'selected' : '' }}>
                                            UPI</option>
                                    </select>
                                </div>

                                <div class="flex-fill">
                                    <label for="register_date" class="form-label">Register Date</label>
                                    <input type="date" class="form-control" name="register_date"
                                        value="{{ request('register_date') }}">
                                </div>
                                <div>
                                    <button class="btn btn-outline-primary" type="submit">Filter</button>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="location.href='{{ route('users.index') }}'">Clear</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sr.No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Register
                                        Date
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mobile
                                        NO.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Property
                                        Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Budget
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Preferred Location</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Source
                                        of Visit</th>
                                    {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pay Status</th> --}}
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        QR Image</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $user->phone ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $user->property_type ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $user->budget ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $user->prefered_location ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $user->source_of_visite ?? 'N/A' }}</span>
                                        </td>
                                        {{-- <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $user->payment_status ?? 'N/A' }}</span>
                                        </td> --}}
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <img src="{{ asset('users_qr_images/' . $user->qr_image) }}"
                                                    alt="QR Code" style="width:40px; cursor:pointer;"
                                                    data-bs-toggle="modal" data-bs-target="#qrModal"
                                                    data-bs-image="{{ asset('users_qr_images/' . $user->qr_image) }}"
                                                    data-bs-name="{{ $user->name }}">
                                            </span>
                                        </td>


                                        <td class="align-middle">
                                            {{--  <a href="{{ route('user.id-card', $user->id) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Download ID Card">
                                                <span class="badge badge-sm bg-gradient-success"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-file-earmark-arrow-down-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0" />
                                                    </svg>Id_Card</span>

                                            </a>  --}}

                                            {{--  <a href="" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Download ID Card">
                                                <span class="badge badge-sm bg-gradient-success"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-file-earmark-arrow-down-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0" />
                                                    </svg>Id_Card</span>

                                            </a>  --}}
                                            {{-- <a href="{{ route('download.idcard', $user->id) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Download ID Card">
                                                <span class="badge badge-sm bg-gradient-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-file-earmark-arrow-down-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0" />
                                                    </svg>
                                                    ID Card
                                                </span>
                                            </a> --}}



                                            <a href="{{ route('users.print', $user->id) }}"
                                                class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-success">Print</span>
                                            </a>

                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit user">
                                                <span class="badge badge-sm bg-gradient-success">Edit</span>


                                            </a>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf

                                                <button type="submit"
                                                    class="text-danger font-weight-bold text-xs border-0 bg-transparent"
                                                    style="cursor: pointer;">
                                                    <span class="badge badge-sm bg-gradient-danger">Delete</span>

                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-3">
                            {{--  {{ $users->links() }}  --}}
                            {{ $users->links('vendor.pagination.bootstrap-4') }}

                        </div>

                        {{--  <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h5 id="modalUserName" class="mb-3"></h5>
                                        <img id="modalQrImage" src="" alt="QR Code"
                                            style="max-width:100%; height:auto;">
                                    </div>
                                </div>
                            </div>
                        </div>  --}}
                        <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                                        <!-- Close button -->
                                        {{--  <button type="button" class="btn-close btn-dark" data-bs-dismiss="modal"
                                            aria-label="Close" style="color:darkblue"></button>  --}}
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" style="filter: invert(1);"></button>

                                    </div>
                                    <div class="modal-body text-center">
                                        <h5 id="modalUserName" class="mb-3" style="color:darkblue;"></h5>
                                        <img id="modalQrImage" src="" alt="QR Code"
                                            style="max-width:100%; height:auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                var userName = button.getAttribute('data-bs-name');

                var modalImage = qrModal.querySelector('#modalQrImage');
                var modalName = qrModal.querySelector('#modalUserName');

                modalImage.src = imageSrc;
                modalName.textContent = userName;
            });
        });
    </script>
@endsection
