<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        section.vh-100 {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .h-custom {
            height: calc(100% - 72px);
        }
    </style>
</head>

<body>
    <section class="vh-100 w-100 h-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <img src="{{ asset('img/login.jpg') }}" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4">
                    @error('failed')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div
                            class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4">
                            <p class="lead fw-normal mb-0 me-3">Register</p>
                        </div>

                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            @error('name')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <input type="text" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Enter a valid username" name="name" required />
                            <label class="form-label" for="form3Example3">Name</label>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            @error('email')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <input type="email" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Enter a valid username" name="email" required />
                            <label class="form-label" for="form3Example3">Email</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            @error('password')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <input type="password" id="form3Example4" class="form-control form-control-lg"
                                placeholder="Enter password" name="password" required />
                            <label class="form-label" for="form3Example4">Password</label>
                        </div>
                        <div>
                            <p>Already have account? <a href="{{ route('login.form') }}">Register</a></p>
                        </div>
                        <div class="text-center text-lg-start">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
