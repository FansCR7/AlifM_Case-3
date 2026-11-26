<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showTrash = false;

    public bool $formOpen = false;

    public ?int $editingProductId = null;

    public string $name = '';

    public string $sku = '';

    public string $category = '';

    public string $description = '';

    public string $stock = '0';

    public string $price = '0';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedShowTrash(): void
    {
        $this->resetPage();
    }

    public function startCreating(): void
    {
        $this->resetForm();
        $this->formOpen = true;
    }

    public function editProduct(int $id): void
    {
        $product = $this->ownedProducts()->findOrFail($id);

        $this->editingProductId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->category = $product->category ?? '';
        $this->description = $product->description ?? '';
        $this->stock = (string) $product->stock;
        $this->price = (string) $product->price;
        $this->formOpen = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')
                    ->where('user_id', Auth::id())
                    ->ignore($this->editingProductId),
            ],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        if ($this->editingProductId !== null) {
            $this->ownedProducts()->findOrFail($this->editingProductId)->update($validated);
            session()->flash('status', 'Barang berhasil diperbarui.');
        } else {
            Product::query()->create([
                ...$validated,
                'user_id' => Auth::id(),
            ]);
            session()->flash('status', 'Barang berhasil ditambahkan.');
        }

        $this->clearStatisticsCache();
        $this->resetForm();
        $this->formOpen = false;
    }

    public function deleteProduct(int $id): void
    {
        $this->ownedProducts()->findOrFail($id)->delete();

        $this->clearStatisticsCache();
        $this->resetForm();
        $this->formOpen = false;
        session()->flash('status', 'Barang dipindahkan ke tempat sampah.');
    }

    public function restoreProduct(int $id): void
    {
        $this->ownedProducts()->onlyTrashed()->findOrFail($id)->restore();

        $this->clearStatisticsCache();
        session()->flash('status', 'Barang berhasil dipulihkan.');
    }

    public function render(): View
    {
        $products = $this->ownedProducts()
            ->when($this->showTrash, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('sku', 'like', '%'.$this->search.'%')
                        ->orWhere('category', 'like', '%'.$this->search.'%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.products.index', [
            'products' => $products,
            'statistics' => $this->statistics(),
        ])->layout('components.layouts.app', ['title' => 'Inventaris Barang']);
    }

    /**
     * @return Builder<Product>
     */
    private function ownedProducts(): Builder
    {
        return Product::query()->where('user_id', Auth::id());
    }

    /**
     * @return array{total: int, stock: int, low_stock: int}
     */
    private function statistics(): array
    {
        return Cache::remember(
            $this->statisticsCacheKey(),
            now()->addMinutes(5),
            fn (): array => [
                'total' => Product::query()->where('user_id', Auth::id())->count(),
                'stock' => (int) Product::query()->where('user_id', Auth::id())->sum('stock'),
                'low_stock' => Product::query()
                    ->where('user_id', Auth::id())
                    ->where('stock', '<=', 5)
                    ->count(),
            ],
        );
    }

    private function clearStatisticsCache(): void
    {
        Cache::forget($this->statisticsCacheKey());
    }

    private function statisticsCacheKey(): string
    {
        return 'products:statistics:user:'.Auth::id();
    }

    private function resetForm(): void
    {
        $this->reset(['editingProductId', 'name', 'sku', 'category', 'description']);
        $this->stock = '0';
        $this->price = '0';
        $this->resetValidation();
    }

    public function cancelForm(): void
    {
        $this->resetForm();
        $this->formOpen = false;
    }
}
