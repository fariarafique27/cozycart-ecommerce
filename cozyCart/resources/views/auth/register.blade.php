<x-layout>
    <div class="min-h-[calc(100vh-4rem)] w-full flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 bg-stone-50">
        
        <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-md border border-stone-100">
            <h2 class="mb-6 text-3xl font-black text-center text-rose-500 tracking-tight">
                Join CozyCart 🧸
            </h2>

            <form action="{{ url('/register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block mb-2 font-semibold text-stone-700">
                        Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-2 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition"
                        placeholder="Your Name"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-stone-700">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-2 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition"
                        placeholder="name@example.com"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-stone-700">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-stone-700">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-2 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition"
                        placeholder="••••••••"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-3 font-semibold text-white transition rounded-xl bg-rose-500 hover:bg-rose-600 shadow-sm shadow-rose-100 cursor-pointer"
                >
                    Create Account
                </button>
            </form>

            <p class="mt-6 text-sm text-center text-stone-600">
                Already have an account?
                <a href="{{ url('/login') }}" class="font-medium text-rose-500 hover:underline">
                    Login here
                </a>
            </p>
        </div>

    </div>
</x-layout>