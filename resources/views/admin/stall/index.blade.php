@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6 text-start">
                            <h5 style="color:#393185">Stalls table</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('stalls.create') }}" class="btn btn-primary btn-sm">Add New Stall</a>
                        </div>
                    </div>


                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('stalls.index') }}" class="d-flex flex-wrap align-items-end gap-3">
                                <div class="flex-fill">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" name="search" placeholder="Search by stall no, name, business, user name, mobile, email, website" value="{{ request('search') }}">
                                </div>
                                <div>
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                    <a href="{{ route('stalls.index') }}" class="btn btn-outline-secondary">Clear</a>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stall No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Stall Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Business</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stall User Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Mobile</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Website</th>
                                    <th class="text-secondary opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stalls as $stall)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ ($stalls->currentPage() - 1) * $stalls->perPage() + $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $stall->stall_no }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $stall->stall_name }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{ $stall->business ?? 'N/A' }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $stall->stall_user_name }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $stall->mobile }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $stall->email }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $stall->website ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle">

                                            {{--  <a href="" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit stall">
                                                <span class="badge badge-sm bg-gradient-success"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-box-arrow-down"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z" />
                                                        <path fill-rule="evenodd"
                                                            d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                                                    </svg>Visitors List</span>
                                            </a>  --}}
                                            {{--  <a href="{{ route('stall.visitors.export', $stall->id) }}"
                                                class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-box-arrow-down"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z" />
                                                        <path fill-rule="evenodd"
                                                            d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                                                    </svg>
                                                    Visitors List
                                                </span>
                                            </a>  --}}
                                            {{--  <a href="javascript:void(0)" class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="modal" data-bs-target="#visitorModal{{ $stall->id }}">

                                                <span class="badge badge-sm bg-gradient-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-box-arrow-down"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z" />
                                                        <path fill-rule="evenodd"
                                                            d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                                                    </svg>
                                                    Visitors List
                                                </span>
                                            </a>  --}}

                                            <a href="javascript:void(0)" class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="modal" data-bs-target="#visitorModal{{ $stall->id }}">
                                                <span class="badge badge-sm bg-gradient-success"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-box-arrow-down"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z" />
                                                        <path fill-rule="evenodd"
                                                            d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                                                    </svg>Visitors List</span>
                                            </a>



                                            <!-- Modal -->
                                            <div class="modal fade" id="visitorModal{{ $stall->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $stall->stall_name }} – Visitors
                                                                Export</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <label>Select Date:</label>
                                                            <select class="form-control"
                                                                id="exportDate{{ $stall->id }}">
                                                                <option value="2025-11-27">27 November</option>
                                                                <option value="2025-11-28">28 November</option>
                                                                <option value="2025-11-29">29 November</option>
                                                                <option value="2025-11-30">30 November</option>
                                                                <option value="2025-12-01">1 December</option>
                                                            </select>
                                                        </div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary"
        data-bs-dismiss="modal">
        Close
    </button>

    <!--<a href="{{ route('stall.visitors.export', $stall->id) }}"-->
    <!--    id="exportBtn{{ $stall->id }}" class="btn btn-success">-->
    <!--    Download Excel-->
    <!--</a>-->
    <a href="javascript:void(0)"
id="exportBtn{{ $stall->id }}"
class="btn btn-success"
onclick="exportVisitors({{ $stall->id }})">
Download Excel
</a>

</div>

</div>
                                                </div>
                                            </div>




                                            <a href="{{ route('stalls.edit', $stall->id) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit stall">
                                                <span class="badge badge-sm bg-gradient-success">Edit</span>
                                            </a>
                                            <form action="{{ route('stalls.destroy', $stall->id) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this stall?')">
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
                                        <td colspan="9" class="text-center">No stalls found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $stalls->links('vendor.pagination.bootstrap-4') }}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
function exportVisitors(stallId) {
    let date = document.getElementById('exportDate' + stallId).value;

    // Generate dynamic URL
    let url = "/stall-visitors-export/" + stallId + "?date=" + date;

    // Redirect to download
    window.location.href = url;
}
</script>

@endsection
