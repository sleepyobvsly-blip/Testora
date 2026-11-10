<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Product Details</h1>
            <p>View information about your testing product.</p>
        </div>

        <a href="{{ route('products.index') }}" class="sentra-primary-button">
            ← Back to Products
        </a>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->category }}</p>
            </div>

            <span class="status-{{ $product->status }}">
                {{ ucfirst($product->status) }}
            </span>
        </div>

        <div class="project-information">
            <div class="information-item">
                <label>Product Name</label>
                <p>{{ $product->name }}</p>
            </div>

            <div class="information-item">
                <label>Category</label>
                <p>{{ $product->category }}</p>
            </div>

            <div class="information-item">
                <label>Description</label>
                <p>{{ $product->description ?: 'No description provided.' }}</p>
            </div>

            <div class="information-item">
                <label>Status</label>
                <p>{{ ucfirst($product->status) }}</p>
            </div>

            <div class="information-item">
                <label>Date Created</label>
                <p>{{ $product->created_at->format('F d, Y') }}</p>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('products.edit', $product) }}" class="sentra-primary-button">
                Edit Product
            </a>
            
            <form action="{{ route('products.destroy', $product) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this product?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="delete-button">
                    Delete Product
                </button>
            </form>
        </div>
    </section>
</x-app-layout>