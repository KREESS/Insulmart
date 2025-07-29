<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VarianProduk;

class ProdukVarianTable extends Component
{
    use WithPagination;

    public $produkId;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = VarianProduk::query()
            ->where('produk_id', $this->produkId);

        if (strlen($this->search) > 0) {
            $keyword = '%' . $this->search . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('tipe', 'like', $keyword)
                    ->orWhere('ukuran', 'like', $keyword)
                    // Ketebalan: jika integer, convert to string di query
                    ->orWhereRaw("CAST(ketebalan AS CHAR) LIKE ?", [$keyword]);
            });
        }

        $varians = $query->orderBy('tipe')->paginate(10);

        return view('livewire.produk-varian-table', compact('varians'));
    }
}
