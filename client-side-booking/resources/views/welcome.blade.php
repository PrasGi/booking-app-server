@extends('partials.index')

@section('content')
    @if ($datas == null)
        <div class="text-center">
            Empty histories
        </div>
    @else
        @foreach ($datas as $data)
            <div class="card shadow">
                <div class="card-header">
                    History booking
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data['name'] }}</h5>
                    <p class="card-text">{{ $data['description'] }}</p>
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ $data['image'] ? $data['image'] : asset('img/empty.jpg') }}" style="width: 200px">
                        </div>
                        <div class="col-8 pt-3">
                            <p> <b>Total</b>: Rp. {{ $data['total'] }}</p>
                            <p> <b>Date</b>: {{ $data['date'] }}</p>
                            @if ($data['conrimed_at'] == 'confirmed')
                                <span class="badge text-bg-success">{{ $data['conrimed_at'] }}</span>
                            @else
                                <span class="badge text-bg-warning">{{ $data['conrimed_at'] }}</span>
                            @endif
                            {{-- <span class="badge text-bg-warning">Waiting</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
