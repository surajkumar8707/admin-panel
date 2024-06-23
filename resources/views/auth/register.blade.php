<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.register') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="container">

    <div class="container p-2 my-5">
        <center>
            <h3 class="my-4">{{ __('messages.register') }}</h3>
        </center>
        <form class="w-75 mx-auto shadow py-4 px-5" id="registration-form" method="POST"
            action="{{ route('customer.registration.post') }}">
            @csrf
            <div class="form-group my-2">
                <label for="name">{{ __('messages.name') }}:</label>
                <input class="form-control" type="text" placeholder="{{ __('messages.name') }}" id="name" name="name"
                    value="{{ old('name') }}" required>
                <span class="text-danger" id="name-error"></span>
            </div>
            <div class="form-group my-2">
                <label for="email">{{ __('messages.email') }}:</label>
                <input class="form-control" type="email" placeholder="{{ __('messages.email') }}" id="email" name="email"
                    value="{{ old('email') }}" required>
                <span class="text-danger" id="email-error"></span>
            </div>
            <div class="form-group my-2">
                <label for="password">{{ __('messages.password') }}:</label>
                <input class="form-control" type="password" placeholder="{{ __('messages.password') }}" id="password" name="password"
                    required>
                <span class="text-danger" id="password-error"></span>
                <input type="checkbox" id="show-password"> {{ __('messages.show_password') }}
            </div>
            <div class="form-group my-2">
                <label for="password_confirmation">{{ __('messages.confirm_password') }}:</label>
                <input class="form-control" type="password" placeholder="{{ __('messages.confirm_password') }}"
                    id="password_confirmation" name="password_confirmation" required>
                <span class="text-danger" id="password_confirmation-error"></span>
                <input type="checkbox" id="show-password-confirmation"> {{ __('messages.show_password') }}
            </div>
            <div class="form-group my-2">
                <button class="btn btn-warning" type="button" id="register-btn">{{ __('messages.register') }}</button>
            </div>
        </form>

        <form id="otp-form" style="display:none;" method="POST" action="{{ route('customer.verify.otp') }}">
            @csrf
            <div class="form-group my-2">
                <label for="otp">{{ __('messages.otp') }}:</label>
                <input class="form-control" type="text" placeholder="{{ __('messages.otp') }}" id="otp" name="otp" required>
                <span class="text-danger" id="otp-error"></span>
            </div>
            <div class="form-group my-2">
                <button class="btn btn-warning" type="button" id="verify-otp-btn">{{ __('messages.verify_otp') }}</button>
            </div>
        </form>
    </div>

    <script>
        $('#register-btn').click(function () {
            $.ajax({
                url: '{{ route('customer.registration.post') }}',
                method: 'POST',
                data: $('#registration-form').serialize(),
                success: function (response) {
                    if (response.success) {
                        $('#registration-form').hide();
                        $('#otp-form').show();
                    } else {
                        // handle validation errors
                        $('.text-danger').text('');
                        for (const [key, value] of Object.entries(response.errors)) {
                            $(`#${key}-error`).text(value[0]);
                        }
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#verify-otp-btn').click(function () {
            $.ajax({
                url: '{{ url('customer/verify-otp') }}',
                method: 'POST',
                data: $('#otp-form').serialize(),
                success: function (response) {
                    if (response.success) {
                        window.location.href = '{{ url('customer/login') }}';
                    } else {
                        $('#otp-error').text(response.message);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#show-password').click(function () {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            if (passwordFieldType == 'password') {
                passwordField.attr('type', 'text');
            } else {
                passwordField.attr('type', 'password');
            }
        });

        $('#show-password-confirmation').click(function () {
            var passwordConfirmationField = $('#password_confirmation');
            var passwordConfirmationFieldType = passwordConfirmationField.attr('type');
            if (passwordConfirmationFieldType == 'password') {
                passwordConfirmationField.attr('type', 'text');
            } else {
                passwordConfirmationField.attr('type', 'password');
            }
        });
    </script>
</body>

</html>
