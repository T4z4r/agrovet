<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="name" name="name" required>
                            @error('name')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="category" name="category" required>
                            @error('category')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="unit" name="unit" required>
                            @error('unit')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="stock" name="stock" required min="0">
                            @error('stock')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="cost_price" class="block text-sm font-medium text-gray-700">Cost Price</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="cost_price" name="cost_price" required min="0">
                            @error('cost_price')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="selling_price" class="block text-sm font-medium text-gray-700">Selling Price</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="selling_price" name="selling_price" required min="0">
                            @error('selling_price')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create</button>
                        <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>