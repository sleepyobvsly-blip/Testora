<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Create New Product</h1>
            <p>Set up a product or service testing product.</p>
        </div>

        {{-- <a href="{{ route('products.index') }}" class="sentra-primary-button">
            ← Back to Products
        </a> --}}
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Product Information</h2>
                <p>Enter the basic details of your product.</p>
            </div>
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Product Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Local Milk"
                    required
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Product Category</label>
                <input
                    type="text"
                    id="category"
                    name="category"
                    value="{{ old('category') }}"
                    placeholder="e.g. Drink"
                    required
                >
                @error('category')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Product Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Describe the product or service being tested..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('products.index') }}" class="cancel-button">
                    Cancel
                </a>

                <button type="submit" class="sentra-primary-button">
                    Create Product
                </button>
            </div>
        </form>
    </section>
</x-app-layout>