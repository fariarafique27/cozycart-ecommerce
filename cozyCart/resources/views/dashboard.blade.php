<x-layout>
<body class="flex items-center justify-center min-h-screen bg-stone-50 p-4">

    <div class="w-full max-w-2xl rounded-xl bg-white p-8 shadow-lg text-center">

        <h1 class="mb-4 text-4xl font-bold text-rose-500">
            🧸 Welcome to the CozyCart Customer Storefront!
        </h1>

        <p class="mb-8 text-lg text-gray-700">
            Hello,
            <span class="font-semibold">{{ Auth::user()->name }}</span>!
            You are logged in as a
            <span class="font-bold text-green-600">Customer</span>.
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="rounded-lg bg-rose-500 px-6 py-3 font-semibold text-white transition hover:bg-rose-600"
            >
                Log Out
            </button>
        </form>

    </div>

</body>
</x-layout>