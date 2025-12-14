<?php

namespace App\Livewire\Settings\Admin;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithFileUploads;

    public string $name, $description, $price;
    public mixed $image;
    public int $productId;
    public bool $isEditing = false;
    public int $perPage = 15;
    public bool $showForm = false;

    protected array $rules = [
        'name' => 'required|string|min:2',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
    ];

    public function toggleForm(): void
    {
        $this->showForm = !$this->showForm;
        $this->resetForm();
    }

    public function edit($id): void
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->isEditing = true;
        $this->image = null;
        $this->showForm = true;
    }

    public function delete($id): void
    {
        Product::findOrFail($id)->delete();
        $this->resetForm();
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->image instanceof UploadedFile) {
            $data['image'] = saveFileSafely($this->image, null, 'products', $this->productId);
        } elseif ($this->isEditing) {
            unset($data['image']);
        }

        Product::updateOrCreate(
            ['id' => $this->productId],
            $data
        );

        $this->resetForm();
        $this->showForm = false;
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'description', 'price', 'image', 'productId', 'isEditing']);
    }

    public function render(): View
    {
        $products = Product::orderByDesc('created_at')->paginate($this->perPage);

        return view('livewire.settings.admin.products', [
            'products' => $products
        ]);
    }
}
