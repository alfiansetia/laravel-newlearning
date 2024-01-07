@extends('layouts.template', ['title' => 'Dashboard'])

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome {{ $user->name }}</h3>
                    @if (empty($user->email_verified_at))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Hello {{ $user->name }}!</strong> Your account is unverified, please check your
                            email !
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    {{-- <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                            class="text-primary">3 unread alerts!</span></h6> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Top Course</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td class="font-weight-bold">{{ $item->price }}</td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Point</p>
                            <p class="fs-30 mb-2">{{ $user->point }}</p>
                            {{-- <p>10.00% (30 days)</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Chat</p>
                            <p class="fs-30 mb-2">{{ $chat }}</p>
                            {{-- <p>22.00% (30 days)</p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Course</p>
                            <p class="fs-30 mb-2">{{ $course }}</p>
                            {{-- <p>2.00% (30 days)</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Keys</p>
                            <p class="fs-30 mb-2">{{ $key }}</p>
                            {{-- <p>0.22% (30 days)</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Transaction</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $item)
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td class="font-weight-bold">{{ $item->total }}</td>
                                        <td class="font-weight-medium">
                                            <div class="badge badge-success">{{ $item->status }}</div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
