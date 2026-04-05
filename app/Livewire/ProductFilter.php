<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductFilter extends Component
{
    use WithPagination;

    public Category $category;
    public $brands;

    #[Url(as: 'marca')]
    public ?string $brandSlug = null;

    #[Url(as: 'buscar')]
    public string $search = '';

    #[Url(as: 'disponible')]
    public bool $onlyAvailable = false;

    public function mount(Category $category, $brands): void
    {
        $this->category = $category;
        $this->brands   = $brands;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingBrandSlug(): void
    {
        $this->resetPage();
    }

    public function updatingOnlyAvailable(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['brand', 'images'])
            ->active()
            ->whereHas('categories', fn ($q) => $q->where('categories.id', $this->category->id));

        if ($this->search) {
            $term = $this->search;
            // Use fulltext search when the term is 3+ chars (uses ft_products_name index)
            // Fall back to LIKE for short terms
            if (strlen($term) >= 3) {
                $query->whereFullText('name', $term);
            } else {
                $query->where('name', 'like', $term . '%');
            }
        }

        if ($this->brandSlug) {
            // Use the already-loaded brands collection (no extra DB query)
            $brand = collect($this->brands)->firstWhere('slug', $this->brandSlug);
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        if ($this->onlyAvailable) {
            $query->where('is_available', true);
        }

        $products = $query->latest()->paginate(12);

        return view('livewire.product-filter', [
            'products' => $products,
        ]);
    }
}
