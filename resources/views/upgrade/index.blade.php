@extends('layouts.template', ['title' => 'User'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @include('components.card_header', [
                        'title' => 'User',
                        'route' => 'user.create',
                    ])
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-{{ $item->status == 'acc' ? 'success' : ($item->status == 'pending' ? 'warning' : 'danger') }}">{{ $item->status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                                    id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                    <a class="dropdown-item"
                                                        href="{{ route('upgrade.show', $item->id) }}">Detail</a>
                                                    @if ($item->status == 'pending')
                                                        <button type="button"
                                                            onclick="deleteData('{{ route('upgrade.destroy', $item->id) }}')"
                                                            class="dropdown-item">Reject</button>
                                                    @endif
                                                    @if ($item->status != 'acc')
                                                        <button type="button"
                                                            onclick="accData('{{ route('upgrade.acc', $item->id) }}')"
                                                            class="dropdown-item">ACC</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        No Data!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center pb-5">
        {{ $data->links() }}
    </div>

    <form action="" method="POST" id="form_delete">
        @csrf
        @method('DELETE')
    </form>
    <form action="" method="POST" id="form_acc">
        @csrf
    </form>
@endsection

@push('js')
    <script>
        function deleteData(action) {
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
                    $('#form_delete').attr('action', action)
                    $('#form_delete').submit()
                }
            })
        }

        function accData(action) {
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
                    $('#form_acc').attr('action', action)
                    $('#form_acc').submit()
                }
            })
        }
    </script>
@endpush
