<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <meta name="description" content="Login to our platform to manage your account and access your dashboard.">
</head>

<body class="bg-base-100 antialiased text-slate-800">
<main>
    <div class="max-w-md mx-auto px-6 py-16">

        {{-- Header --}}

        <div class="auth-box">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <header class="mb-10 text-center">
                    <h2 >Join Us</h2>
                </header>
                {{-- Name --}}
                <div class="form-control w-full">
                    <input type="text" name="name" placeholder="name" value="{{ old('name') }}"
                        class="input w-full bg-base-200 border-none focus:ring-2 ring-primary rounded-2xl p-4 h-12 font-medium @error('name') ring-2 ring-error @enderror"
                        required>
                        @error('name')
                        <span class="text-error text-[10px] font-bold mt-1 uppercase">{{ $message }}</span>
                        @enderror
                    </div>

                {{-- Username --}}
                <div class="form-control w-full">
                    <input type="text" name="user_name" placeholder="user_name" value="{{ old('user_name') }}"
                        class="input w-full bg-base-200 border-none focus:ring-2 ring-primary rounded-2xl p-4 h-12 font-medium @error('user_name') ring-2 ring-error @enderror"
                        required>
                        @error('user_name')
                        <span class="text-error text-[10px] font-bold mt-1 uppercase">{{ $message }}</span>
                        @enderror
                    </div>

                {{-- Email --}}
                <div class="form-control w-full">
                    <input type="email" name="email" placeholder="email" value="{{ old('email') }}"
                        class="input w-full bg-base-200 border-none focus:ring-2 ring-primary rounded-2xl p-4 h-12 font-medium @error('email') ring-2 ring-error @enderror"
                        required>
                        @error('email')
                        <span class="text-error text-[10px] font-bold mt-1 uppercase">{{ $message }}</span>
                        @enderror
                    </div>

                {{-- Password --}}
                <div>
                    <input type="password" name="password" placeholder="password"
                        class="input w-full bg-base-200 border-none focus:ring-2 ring-primary rounded-2xl p-4 h-12 font-medium @error('password') ring-2 ring-error @enderror"
                        required>
                        @error('password')
                        <span class="text-error text-[10px] font-bold mt-1 uppercase">{{ $message }}</span>
                        @enderror
                    </div>

                @error('error')
                    <div class="p-4 bg-error/10 text-error rounded-2xl text-[10px] font-bold uppercase">{{ $message }}
                    </div>
                @enderror

                <button type="submit"
                    class="btn btn-primary w-full h-14 rounded-2xl font-bold text-lg shadow-lg shadow-primary/20 border-none mt-4">
                    Create Account
                </button>


                <footer>
                    <Dev class="links-box">
                        <p class="text-xs text-slate-500 font-medium">
                            Already have an account?
                            <a href="{{ route('login') }}">Log in</a>
                            or
                            <a href="{{ route('home') }}">← Back to Home</a>
                        </p>
                    </Dev>
                </footer>
            </form>
        </div>
    </div>
    <script defer src="{{ asset('js/main.js') }}"></script>
</main>
</body>

</html>
