<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <meta name="description" content="Login to our platform to manage your account and access your dashboard.">
</head>

<body>
    <main>
        <div class="auth-box">

            <form method="POST" action="{{ route('login') }}">
                <h2>Login</h2>
                @csrf

                <input type="email" name="email" placeholder="email" value="{{ old('email') }}" required autofocus>

                <input type="password" name="password" placeholder="Password"
                    class="@error('password') input-error @enderror" required>
                @error('error')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
                <div class="remember">
                    <label>
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit">Sign In</button>

                <a href="/auth/google"
                    class="btn w-full h-14 rounded-2xl font-bold text-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center gap-3 shadow-sm transition-all">
                    Continue with Google
                </a>

                <footer>
                    <Dev class="links-box">
                        <p class="text-xs text-slate-500 font-medium">
                            don't have an account?
                            <a href="{{ route('register') }}">sign up</a>
                            or
                            <a href="{{ route('home') }}">← Back to Home</a>
                        </p>
                    </Dev>
                </footer>
            </form>
            @if (session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <script src="{{ asset('js/main.js') }}"></script>
    </main>
</body>

</html>
