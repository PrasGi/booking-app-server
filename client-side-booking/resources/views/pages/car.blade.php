@extends('partials.index')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @error('failed')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    <div class="row">
        @foreach ($cars as $car)
            <div class="col-4">
                <div class="card shadow" style="width: 24rem;">
                    <img src="{{ $car['image'] ? env('API_URL_SERVER_FOOD') . '/storage/' . $car['image'] : asset('img/empty.jpg') }}"
                        class="card-img-top" alt="{{ $car['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car['name'] }}</h5>
                        <p class="card-text">{{ $car['description'] }}</p>
                        <div class="row">
                            <div class="col">
                                <button href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#bookModal{{ $car['id'] }}"><i class="bi bi-bag-plus"></i> Book
                                    now</button>
                            </div>
                            <div class="col pt-1">
                                <b>Price</b> : Rp. {{ $car['price'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal book -->
    @foreach ($cars as $data)
        <div class="modal fade" id="bookModal{{ $data['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Book Car</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="bookForm" method="post" action="{{ route('car.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 shadow">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                    required>
                                <input type="hidden" class="form-control" id="quantity" name="car_id"
                                    value="{{ $data['id'] }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="bookButton">Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
