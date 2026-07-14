<x-layout>
    <div class="min-h-[calc(100vh-4rem)] w-full flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 bg-stone-50">
        
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-md border border-stone-100">
            <h2 class="mb-6 text-center text-3xl font-black text-pink-600 tracking-tight">
                Welcome Back to CozyCart 🧸
            </h2>

            @if(session('error'))
                <div class="mb-4 rounded-md bg-red-100 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block font-semibold text-stone-700">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl border border-stone-200 px-4 py-2 focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block font-semibold text-stone-700">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-stone-200 px-4 py-2 focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-pink-600 py-3 font-semibold text-white transition hover:bg-pink-700 shadow-sm shadow-pink-100 cursor-pointer"
                >
                    Log In
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-stone-600">
                Don't have an account?
                <a href="{{ url('/register') }}" class="font-medium text-pink-600 hover:underline">
                    Register here
                </a>
            </p>
        </div>

    </div>
</x-layout>