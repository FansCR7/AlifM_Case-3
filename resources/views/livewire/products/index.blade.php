<div>
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Inventaris</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Daftar Barang</h1>
            <p class="mt-2 text-slate-500">Kelola stok dan informasi barang yang Anda miliki.</p>
        </div>
        <flux:button variant="primary" wire:click="startCreating" type="button">
            <flux:icon name="plus" class="size-4" />
            Tambah barang
        </flux:button>
    </div>

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Barang aktif</p>
            <p class="mt-3 text-3xl font-semibold">{{ number_format($statistics['total']) }}</p>
            <p class="mt-1 text-xs text-slate-400">Jumlah data inventaris</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total stok</p>
            <p class="mt-3 text-3xl font-semibold">{{ number_format($statistics['stock']) }}</p>
            <p class="mt-1 text-xs text-slate-400">Unit tersedia saat ini</p>
        </article>
        <article class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <p class="text-sm text-amber-800">Stok menipis</p>
            <p class="mt-3 text-3xl font-semibold text-amber-950">{{ number_format($statistics['low_stock']) }}</p>
            <p class="mt-1 text-xs text-amber-700">Barang dengan stok 5 unit atau kurang</p>
        </article>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
            <label class="relative block w-full sm:max-w-sm">
                <span class="sr-only">Cari barang</span>
                <flux:icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400" />
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari nama, SKU, atau kategori"
                    class="w-full rounded-xl border border-slate-300 py-2.5 pl-10 pr-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
            </label>
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input wire:model.live="showTrash" type="checkbox" class="size-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                Tampilkan tempat sampah
            </label>
        </div>

        @if ($formOpen)
            <form wire:submit="save" class="border-b border-emerald-100 bg-emerald-50/50 p-4 sm:p-6">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="font-semibold text-slate-900">{{ $editingProductId ? 'Edit barang' : 'Tambah barang baru' }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Isi informasi barang, lalu simpan perubahan.</p>
                    </div>
                    <button type="button" wire:click="cancelForm" class="rounded-lg p-1 text-slate-500 hover:bg-white hover:text-slate-900" aria-label="Tutup formulir">✕</button>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <label class="block">
                        <span class="mb-1.5 block text-sm font-medium text-slate-700">Nama barang</span>
                        <input wire:model="name" type="text" maxlength="255" required
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                        @error('name') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-sm font-medium text-slate-700">SKU</span>
                        <input wire:model="sku" type="text" maxlength="50" required
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                        @error('sku') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-sm font-medium text-slate-700">Kategori</span>
                        <input wire:model="category" type="text" maxlength="100"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                        @error('category') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-sm font-medium text-slate-700">Stok</span>
                        <input wire:model="stock" type="number" min="0" step="1" required
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                        @error('stock') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-sm font-medium text-slate-700">Harga (Rp)</span>
                        <input wire:model="price" type="number" min="0" step="0.01" required
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                        @error('price') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>

                    <label class="block sm:col-span-2 lg:col-span-1">
                        <span class="mb-1.5 block text-sm font-medium text-slate-700">Deskripsi</span>
                        <input wire:model="description" type="text" maxlength="2000"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                        @error('description') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="mt-5 flex flex-wrap justify-end gap-3">
                    <flux:button type="button" variant="ghost" wire:click="cancelForm">Batal</flux:button>
                    <flux:button type="submit" variant="primary">Simpan barang</flux:button>
                </div>
            </form>
        @endif

        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3.5 font-medium">Barang</th>
                        <th class="px-5 py-3.5 font-medium">Kategori / SKU</th>
                        <th class="px-5 py-3.5 text-right font-medium">Stok</th>
                        <th class="px-5 py-3.5 text-right font-medium">Harga</th>
                        <th class="px-5 py-3.5 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-900">{{ $product->name }}</p>
                                @if ($product->description)
                                    <p class="mt-1 max-w-xs truncate text-xs text-slate-500">{{ $product->description }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-slate-700">{{ $product->category ?: 'Tanpa kategori' }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $product->sku }}</p>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="{{ $product->stock <= 5 ? 'rounded-full bg-amber-100 px-2.5 py-1 text-amber-800' : 'text-slate-700' }}">
                                    {{ number_format($product->stock) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right text-slate-700">Rp{{ number_format((float) $product->price, 0, ',', '.') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    @if ($showTrash)
                                        <flux:button size="sm" variant="outline" wire:click="restoreProduct({{ $product->id }})">Pulihkan</flux:button>
                                    @else
                                        <flux:button size="sm" variant="ghost" wire:click="editProduct({{ $product->id }})">Edit</flux:button>
                                        <flux:button size="sm" variant="danger" wire:click="deleteProduct({{ $product->id }})" wire:confirm="Pindahkan barang ini ke tempat sampah?">Hapus</flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="font-medium text-slate-700">{{ $showTrash ? 'Tempat sampah kosong' : 'Belum ada barang' }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $showTrash ? 'Barang yang dihapus akan muncul di sini.' : 'Tambahkan barang pertama Anda untuk mulai mengelola inventaris.' }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="divide-y divide-slate-100 md:hidden">
            @forelse ($products as $product)
                <article class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="truncate font-semibold text-slate-900">{{ $product->name }}</h2>
                            <p class="mt-1 text-xs text-slate-500">{{ $product->sku }} · {{ $product->category ?: 'Tanpa kategori' }}</p>
                        </div>
                        <span class="shrink-0 rounded-full {{ $product->stock <= 5 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-50 text-emerald-700' }} px-2.5 py-1 text-xs font-medium">
                            Stok {{ number_format($product->stock) }}
                        </span>
                    </div>
                    <p class="mt-3 text-sm font-medium text-slate-700">Rp{{ number_format((float) $product->price, 0, ',', '.') }}</p>
                    @if ($product->description)
                        <p class="mt-1 text-sm text-slate-500">{{ $product->description }}</p>
                    @endif
                    <div class="mt-4 flex gap-2">
                        @if ($showTrash)
                            <flux:button size="sm" variant="outline" wire:click="restoreProduct({{ $product->id }})">Pulihkan</flux:button>
                        @else
                            <flux:button size="sm" variant="ghost" wire:click="editProduct({{ $product->id }})">Edit</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="deleteProduct({{ $product->id }})" wire:confirm="Pindahkan barang ini ke tempat sampah?">Hapus</flux:button>
                        @endif
                    </div>
                </article>
            @empty
                <p class="px-4 py-10 text-center text-sm text-slate-500">{{ $showTrash ? 'Tempat sampah kosong.' : 'Belum ada barang.' }}</p>
            @endforelse
        </div>

        @if ($products->hasPages())
            <div class="border-t border-slate-200 px-4 py-4 sm:px-5">
                {{ $products->links() }}
            </div>
        @endif
    </section>
</div>
