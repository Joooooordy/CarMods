<div>
    @include('partials.settings-heading')
    <x-settings.layout :heading="__('Product Panel')"
                      :subheading="__('View and edit existing products and add new products.')"
                      content-class="w-full max-w-none">

        <div class="mt-10 text-left pb-10">
            <button wire:click="toggleForm"
                    wire:loading.attr="disabled"
                    class="mb-4 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 cursor-pointer transition">
                {{ $showForm ? 'Hide Form' : 'Add New Product' }}
            </button>

            @if($showForm)
                <form wire:submit.prevent="save" id="newProductForm"
                      class="bg-white dark:bg-gray-800 p-4 rounded shadow space-y-4">
                    <h2 class="text-xl font-bold">{{ $isEditing ? 'Editing Product' : 'New Product' }}</h2>

                    <flux:field>
                        <flux:label badge="Required">Name</flux:label>
                        <flux:input wire:model="name" type="text" required/>
                        <flux:error name="name"/>
                    </flux:field>

                    <flux:field>
                        <flux:label badge="Required">Description</flux:label>
                        <flux:textarea
                            wire:model="description"
                            placeholder="Description"
                            required
                        />
                        <flux:error name="description"/>
                    </flux:field>

                    <flux:field>
                        <flux:label badge="Required">Price</flux:label>
                        <flux:input.group>
                            <flux:select wire:model="currency" class="max-w-fit">
                                <flux:select.option value="EUR">EUR</flux:select.option>
                                <flux:select.option value="USD">USD</flux:select.option>
                                <flux:select.option value="GBP">GBP</flux:select.option>
                                <flux:select.option value="CAD">CAD</flux:select.option>
                            </flux:select>
                            <flux:input wire:model="price" placeholder="€99,99" type="text"/>
                        </flux:input.group>
                        <flux:error name="price"/>
                    </flux:field>

                    <flux:input type="file" wire:model="image" label="Product Image"/>

                    {{-- Spinner tijdens uploaden van afbeelding --}}
                    <div wire:loading wire:target="image" class="flex flex-row items-center gap-2 mt-2">
                        <flux:icon.loading class="w-5 h-5 text-blue-600" />
                        <span>Uploading...</span>
                    </div>

                    {{-- Preview alleen tonen als image geladen is --}}
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 mt-2 object-cover rounded"/>
                    @endif

                    <div class="flex gap-4">
                        <button type="submit"
                                class="bg-blue-600 cursor-pointer text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center justify-center gap-2 min-w-[100px]"
                                wire:loading.attr="disabled">

                            {{-- Spinner + tekst samen, goed gecentreerd --}}
                            <div class="flex items-center gap-2">
                                <flux:icon.loading wire:loading wire:target="save" class="w-5 h-5 text-white" />
                                <span>{{ $isEditing ? 'Edit' : 'Save' }}</span>
                            </div>
                        </button>

                        @if($isEditing)
                            <button type="button" wire:click="resetForm" class="text-gray-600 cursor-pointer">Cancel</button>
                        @endif
                    </div>
                </form>
            @endif
        </div>

        @if(!$showForm)
            <div id="productOverview" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($products as $product)
                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded shadow relative">
                        @if($product->image)
                            <img src="{{ image_url($product->id) }}"
                                 class="w-full h-64 object-cover rounded mb-6"/>
                        @endif
                        <h3 class="font-bold">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-12">{{ $product->description }}</p>

                        <div class="absolute bottom-0 left-0 mb-3 w-full px-4 py-2 flex justify-between items-center">
                            <p class="text-lg font-semibold text-gray-800">
                                €{{ number_format($product->price, 2, ',', '.') }}
                            </p>

                            <div class="flex gap-2">
                                <button wire:click="edit({{ $product->id }})"
                                        class="text-blue-600 cursor-pointer hover:underline text-sm">
                                    <flux:icon name="pencil"/>
                                </button>

                                <button wire:click="delete({{ $product->id }})"
                                        class="text-red-600 cursor-pointer hover:underline text-sm">
                                    <flux:icon name="trash"/>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="pagination" class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </x-settings.layout>
</div>
