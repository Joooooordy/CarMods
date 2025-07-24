<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithFileUploads;

    public $name, $description, $price, $image, $productId;
    public $isEditing = false;
    public $perPage = 15;
    public $showForm = false;

    protected $rules = [
        'name' => 'required|string|min:2',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
    ];

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->resetForm();
    }

    public function edit($id)
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

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        $this->resetForm();
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->image instanceof UploadedFile) {
            $data['image'] = $this->saveFileSafely($this->image, 'products', $this->productId);
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

    protected function saveFileSafely(UploadedFile $file, string $folder = 'uploads', int $productId = 0): string
    {
        $userId = auth()->id() ?? 'guest';

        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();
        $uniqueName = $safeName . '-' . uniqid() . '.' . $extension;

        // Opslaan in public disk (public/storage)
        $path = $file->storeAs("{$userId}/{$folder}/{$productId}", $uniqueName, 'public');

        return $uniqueName;
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'price', 'image', 'productId', 'isEditing']);
    }

    public function render()
    {
        $products = Product::orderByDesc('created_at')->paginate($this->perPage);

        return view('livewire.admin.products', [
            'products' => $products
        ]);
    }
}
