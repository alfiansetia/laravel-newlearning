@extends('layouts.template', ['title' => 'Transaction'])

@section('content')
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Transaction {{ $data->number }}</h4>
                    <div class="row mb-3">
                        <div class="col-lg-3">Number : </div>
                        <div class="col-lg-9">{{ $data->number }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">Date : </div>
                        <div class="col-lg-9">{{ $data->date }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">User : </div>
                        <div class="col-lg-9">{{ $data->user->name ?? '' }} {{ $data->user->email ?? '' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">Total : </div>
                        <div class="col-lg-9">
                            <img src="{{ asset('images/dollar.png') }}" style="max-width: 20px;max-height: 20px">
                            {{ $data->total }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">Status : </div>
                        <div class="col-lg-9">
                            <span
                                class="badge badge-{{ $data->status === 'success' ? 'success' : 'danger' }}">{{ $data->status }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Item Transaction</h4>
                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->details ?? [] as $key => $item)
                                    <tr>
                                        <td>{{ $item->course->name ?? '' }}</td>
                                        <td>
                                            <img src="{{ asset('images/dollar.png') }}"
                                                style="max-width: 20px;max-height: 20px">
                                            {{ $item->price }}
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
@endsection
