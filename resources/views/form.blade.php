<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form login</title>
</head>

<body>
    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ route('form-login-post') }}" method="post">
        @csrf
        <label for="">Username : <input type="text" name="username" value="{{ old('username') }}"></label>
        @error('username')
        {{ $message }}
        @enderror
        <label for="">Password : <input id="input-password" type="password" name="password"
                value="{{ old('password') }}"></label>
        @error('password')
        {{ $message }}
        @enderror
        <button id="btn-show-password" type="button">show password</button>
        <button type="submit">Login</button>
    </form>

    <script>
        const btnShow = document.getElementById('btn-show-password');
        const inputPassword = document.getElementById('input-password');
        btnShow.addEventListener("click", () => {
            const typeInput = inputPassword.getAttribute("type");

            typeInput == "password" ? inputPassword.setAttribute("type", "text") : inputPassword.setAttribute("type", "password");
        });
    </script>
</body>

</html>