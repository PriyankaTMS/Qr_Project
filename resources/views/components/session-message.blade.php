<div class="px-2">
    @if (Session::has('success'))
        <div class="alert alert-dismissible alert-warning fade show decodeme" role="alert">
            <strong>Success!</strong> {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('failed'))
        <div class="alert alert-dismissible alert-danger fade show decodeme" role="alert">
            <strong>Error!</strong> {{ Session::get('failed') }}.
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger decodeme">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
