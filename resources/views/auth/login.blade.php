<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>{{ $url == 'admin' ? __('messages.admin_login') : __('messages.customer_login') }}</title>
</head>

<body class="container">

    <div class="container p-2 my-5">
        <center>
            <h3 class="my-5">{{ $url == 'admin' ? __('messages.admin_login') : __('messages.customer_login') }}</h3>
        </center>
        <form class="w-75 mx-auto shadow p-5" method="POST"
            action="{{ url($url == 'admin' ? 'admin/login' : 'customer/login') }}">
            @csrf
            <div class="text-end">
                @if ($url == 'admin')
                    <a class="btn btn-secondary" href="{{ route('customer.login') }}">{{ __('messages.customer_login') }}</a>
                @else
                    <a class="btn btn-secondary" href="{{ route('admin.login') }}">{{ __('messages.admin_login') }}</a>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="email">{{ __('messages.email') }}:</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="{{ __('messages.email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="password">{{ __('messages.password') }}:</label>
                <input class="form-control" type="password" id="password" name="password"
                    placeholder="{{ __('messages.password') }}" required>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <button class="btn btn-primary" type="submit">{{ __('messages.login') }}</button>
            </div>
            <div>
                {{ __('messages.new_customer') }} <a href="{{ route('customer.registration') }}">{{ __('messages.customer_registration') }}</a>
            </div>
        </form>
        <div class="text-end mt-3">
            <a href="{{ url('lang/en') }}" class="btn btn-sm btn-outline-primary">English</a>
            <a href="{{ url('lang/es') }}" class="btn btn-sm btn-outline-primary">Español</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
