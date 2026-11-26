<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'Ruang Barang') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 font-semibold tracking-tight">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-emerald-600 text-white">
                        <flux:icon name="cube" class="size-5" />
                    </span>
                    <span class="text-lg">Ruang Barang</span>
                </a>

                @auth
                    <div class="flex items-center gap-3">
                        <span class="hidden text-sm text-slate-600 sm:block">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:button type="submit" variant="outline" size="sm">Keluar</flux:button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
            @if (session('status'))
                <div
                    x-data="{ visible: true }"
                    x-show="visible"
                    x-init="setTimeout(() => visible = false, 4500)"
                    class="mb-6 flex items-center justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"
                    role="status"
                >
                    <span>{{ session('status') }}</span>
                    <button type="button" class="font-semibold" @click="visible = false" aria-label="Tutup notifikasi">×</button>
                </div>
            @endif

            {{ $slot }}
        </main>

        @livewireScripts
        @fluxScripts
    </body>
</html>
