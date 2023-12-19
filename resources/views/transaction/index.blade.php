@extends('layouts.template', ['title' => 'Transaction'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @include('components.card_header', [
                        'title' => 'Transaction',
                        'route' => 'transaction.index',
                    ])
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>
                                            <img src="{{ asset('images/dollar.png') }}"
                                                style="max-width: 20px;max-height: 20px"> {{ $item->total }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-{{ $item->status === 'success' ? 'success' : 'danger' }}">{{ $item->status }}</span>
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
                                                        href="{{ route('transaction.show', $item->id) }}">Detail</a>
                                                    <button type="button"
                                                        onclick="deleteData('{{ route('transaction.destroy', $item->id) }}')"
                                                        class="dropdown-item">Cancel</button>
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
@endsection

@push('jslib')
    <script src="{{ asset('backend/js/custom.js') }}"></script>
@endpush
