<x-layouts.app title="Masuk · Ruang Barang">
    <div class="mx-auto grid min-h-[65vh] max-w-5xl items-center gap-10 lg:grid-cols-2">
        <section class="hidden rounded-3xl bg-slate-900 p-10 text-white lg:block">
            <span class="inline-flex rounded-full bg-emerald-400/15 px-3 py-1 text-sm font-medium text-emerald-300">Pengelolaan inventaris</span>
            <h1 class="mt-8 text-4xl font-semibold leading-tight">Barang tercatat rapi, pekerjaan jadi lebih mudah.</h1>
            <p class="mt-4 max-w-md text-slate-300">Kelola data barang, pantau stok, dan perbarui inventaris dari satu tempat.</p>
        </section>

        <section class="mx-auto w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Selamat datang</p>
            <h2 class="mt-2 text-2xl font-semibold">Masuk ke akun</h2>
            <p class="mt-2 text-sm text-slate-500">Masukkan email dan kata sandi untuk melanjutkan.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                @csrf
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-700">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                    @error('email') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-700">Kata sandi</span>
                    <input name="password" type="password" autocomplete="current-password" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                    @error('password') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                </label>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input name="remember" type="checkbox" value="1" class="size-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    Ingat saya
                </label>

                <flux:button type="submit" variant="primary" class="w-full">Masuk</flux:button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Daftar</a>
            </p>
        </section>
    </div>
</x-layouts.app>
