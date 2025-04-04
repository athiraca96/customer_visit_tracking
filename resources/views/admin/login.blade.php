<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 90%;
            max-width: 450px;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .input-group-text {
            background: white;
            cursor: pointer;
        }

        .error-message {
            color: red;
            font-size: 14px;
            min-height: 18px;
            display: block;
        }

        .alert ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .alert ul li {
            list-style-position: inside;
            padding-left: 5px;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-container text-center">
        <h1 class="fw-bold">Welcome</h1>
        <p class="text-muted">Sign in to continue</p>

        @if ($errors->any())
        <div class="alert alert-danger" id="errorAlert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" required value="{{ old('email') }}">
                <small class="error-message" id="emailError">@error('email') {{ $message }} @enderror</small>
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                <small class="error-message" id="passwordError">@error('password') {{ $message }} @enderror</small>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 mt-3">Sign In</button>

            <!-- <p class="text-muted mt-3">
                <a href="#" class="text-primary">Forgot Password?</a>
            </p> -->
        </form>
    </div>

    <script>
        function clearErrorOnInput(fieldId, errorId) {
            document.getElementById(fieldId).addEventListener("input", function() {
                document.getElementById(errorId).textContent = "";
                this.classList.remove("is-invalid");
            });
        }

        document.querySelectorAll("input").forEach(input => {
            input.addEventListener("input", function() {
                let errorAlert = document.getElementById("errorAlert");
                if (errorAlert) {
                    errorAlert.style.display = "none";
                }
            });
        });

        clearErrorOnInput("email", "emailError");
        clearErrorOnInput("password", "passwordError");

        document.getElementById("togglePassword").addEventListener("click", function() {
            let passwordField = document.getElementById("password");
            let icon = this.querySelector("i");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            } else {
                passwordField.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            }
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</body>

</html>