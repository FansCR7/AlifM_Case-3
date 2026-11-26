<x-layouts.app title="Daftar · Ruang Barang">
    <div class="mx-auto max-w-xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-9">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Buat akun</p>
        <h1 class="mt-2 text-2xl font-semibold">Mulai kelola inventaris</h1>
        <p class="mt-2 text-sm text-slate-500">Lengkapi data di bawah untuk membuat akun baru.</p>

        <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">
            @csrf
            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Nama</span>
                <input name="name" type="text" value="{{ old('name') }}" autocomplete="name" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                @error('name') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Email</span>
                <input name="email" type="email" value="{{ old('email') }}" autocomplete="email" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                @error('email') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <div class="grid gap-5 sm:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-700">Kata sandi</span>
                    <input name="password" type="password" autocomplete="new-password" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                    @error('password') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-700">Ulangi kata sandi</span>
                    <input name="password_confirmation" type="password" autocomplete="new-password" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                </label>
            </div>

            <flux:button type="submit" variant="primary" class="w-full">Buat akun</flux:button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Masuk</a>
        </p>
    </div>
</x-layouts.app>
