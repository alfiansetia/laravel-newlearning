@extends('layouts.frontend_app')

@section('content')
    <div class="container mt-3">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('index.topup.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="amount">Amount Point</label>
                                    <input type="number" name="amount"
                                        class="form-control @error('amount') is-invalid @enderror" id="amount"
                                        placeholder="Amount" value="{{ old('amount', 50) }}" min="50" required
                                        autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="rp">Amount Rupiah</label>
                                    <input type="text" name="rp" class="form-control" id="rp"
                                        placeholder="rp" value="0" disabled readonly>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4>History Topup</h4>
                            <table class="table mt-2">
                                <thead>
                                    <th>Date</th>
                                    <th>Code</th>
                                    <th>Point</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->point }}</td>
                                            <td>
                                                {{ $item->status }}
                                                @if ($item->status == 'pending')
                                                    <a class="btn btn-primary" href="{{ $item->snap_url ?? '#' }}">Pay</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#amount').change(function() {
            let amount = $(this).val() ?? 0
            $('#rp').val(amount * 100)
        })

        $('#amount').change()
    </script>
@endpush
