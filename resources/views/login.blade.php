<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <link rel="icon" href="cobra.png" type="image/png">
    <title>Cobrapparel Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #700101;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .shop-name {
            font-size: 32px;
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #700101;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #700101;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #700101;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.8;
        }
        .toggle-btn {
            background: none;
            border: none;
            color: #700101;
            cursor: pointer;
            text-decoration: underline;
        }
        .notif-bar {
            display: none;
            padding: 10px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="shop-name">Cobrapparel</div>
    <div class="container">
        <div id="notif-bar" class="notif-bar"></div>
        <h2 id="form-title">Login</h2>
        @if (session('success')) <p style="color: green;">{{ session('success') }}</p> @endif
        @if ($errors->any()) <p style="color: red;">{{ $errors->first() }}</p> @endif
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <input type="email" name="email" id="email" placeholder="Email" required>
            <div class="relative w-full">
                <input type="password" id="password" name="password" placeholder="Password" required 
                    class="border p-2 rounded w-full pr-10">
                <!-- Show/Hide Password Icon -->
                {{-- <img src="images/icons/show_pass.png" id="togglePassword" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 h-6 w-6 cursor-pointer"> --}}
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let passwordInput = document.getElementById("password");
            let toggleIcon = document.getElementById("togglePassword");

            toggleIcon.addEventListener("click", function () {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    toggleIcon.src = "images/icons/hide_pass.png"; // Change to "hide" icon
                } else {
                    passwordInput.type = "password";
                    toggleIcon.src = "images/icons/show_pass.png"; // Change back to "show" icon
                }
            });
        });
    </script>
</body>
</html>
