@extends('layouts.frontend_app')

@section('content')
    <div class="container mt-3">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>History Point</h4>
                            <table class="table mt-2">
                                <thead>
                                    <th>Date</th>
                                    <th class="text-center">Value</th>
                                    <th class="text-center">Before</th>
                                    <th class="text-center">After</th>
                                    <th>Desc</th>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/dollar.png') }}" alt="" width="20"
                                                    style="max-width: 20px;max-height: 20px">
                                                {{ $item->type == 'plus' ? '+' : '-' }}{{ $item->value }}
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/dollar.png') }}" alt="" width="20"
                                                    style="max-width: 20px;max-height: 20px"> {{ $item->before }}
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/dollar.png') }}" alt="" width="20"
                                                    style="max-width: 20px;max-height: 20px"> {{ $item->after }}
                                            </td>
                                            <td>{{ $item->desc }}</td>
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
