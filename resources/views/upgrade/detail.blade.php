@extends('layouts.template', ['title' => 'User'])

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Upgrade Of {{ $data->user->name }}</h4>
                    <h5 class="mt-2 ">Date : {{ $data->date }}</h5>
                    <h5 class="mt-2 ">Status : <span
                            class="badge badge-{{ $data->status == 'acc' ? 'success' : ($data->status == 'pending' ? 'warning' : 'danger') }}">{{ $data->status }}</span>
                    </h5>
                    <h5 class="mt-2 ">Reason :</h5>
                    <p class="mt-2 mb-2">
                        {{ $data->reason }}
                    </p>

                    <a href="{{ route('upgrade.edit', $data->id) }}" class="btn btn-primary">Download CV</a>
                    @if ($data->status == 'pending')
                        <button type="button" class="btn btn-success mr-2" onclick="accData()">ACC</button>
                        <button type="button" class="btn btn-danger mr-2" onclick="rejectData()">Reject</button>
                    @endif
                    <a href="{{ route('upgrade.index') }}" class="btn btn-light">Back</a>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('upgrade.destroy', $data->id) }}" method="POST" id="form_reject">
        @csrf
        @method('DELETE')
    </form>
    <form action="{{ route('upgrade.acc', $data->id) }}" method="POST" id="form_acc">
        @csrf
    </form>
@endsection
@push('js')
    <script>
        function rejectData() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Your data will be lost!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="ti-thumb-up"></i> Yes!',
                confirmButtonAriaLabel: 'Thumbs up, Yes!',
                cancelButtonText: '<i class="ti-thumb-down"></i> No',
                cancelButtonAriaLabel: 'Thumbs down',
                customClass: 'animated tada',
                showClass: {
                    popup: 'animate__animated animate__tada'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_reject').submit()
                }
            })
        }

        function accData() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Your data will be lost!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="ti-thumb-up"></i> Yes!',
                confirmButtonAriaLabel: 'Thumbs up, Yes!',
                cancelButtonText: '<i class="ti-thumb-down"></i> No',
                cancelButtonAriaLabel: 'Thumbs down',
                customClass: 'animated tada',
                showClass: {
                    popup: 'animate__animated animate__tada'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_acc').submit()
                }
            })
        }
    </script>
@endpush
