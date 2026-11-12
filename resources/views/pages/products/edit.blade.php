
<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Edit Product</h1>
            <p>Update your product information.</p>
        </div>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Product Information</h2>
                <p>Modify the details of your product.</p>
            </div>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="form-group">
                <label for="name">Product Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    required
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Category -->
            <div class="form-group">
                <label for="category">Product Category</label>
                <input
                    type="text"
                    id="category"
                    name="category"
                    value="{{ old('category', $product->category) }}"
                    required
                >
                @error('category')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Description -->
            <div class="form-group">
                <label for="description">Product Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Status (Read Only) -->
            <div class="form-group">
                <label>Current Product Status</label>

                <div class="project-status">
                    <span class="status-{{ $product->status }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <p class="text-xs text-slate-500 mt-2">
                    Product status is managed automatically by Testora.
                </p>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('products.show', $product) }}" class="cancel-button">
                    Cancel
                </a>

                <button type="submit" class="sentra-primary-button">
                    Save Changes
                </button>
            </div>
        </form>
    </section>
</x-app-layout>
