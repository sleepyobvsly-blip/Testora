<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Products</h1>
            <p>Manage your product testing and feedback collection products.</p>
        </div>

        <a href="{{ route('products.create') }}" class="sentra-primary-button">
            + Create New Product
        </a>
    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <section class="projects-section">
        <div class="section-heading">
            <div>
                <h2>All Products</h2>
                <p>View and manage your products.</p>
            </div>

            <span class="project-count">
                {{ $products->count() }} Products
            </span>
        </div>

        @forelse ($products as $product)
            <div class="project-row">
                <div class="project-details">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->category }}</p>

                    @if ($product->description)
                        <p>{{ $product->description }}</p>
                    @endif
                </div>

                <div class="project-status">
                    <span class="status-{{ $product->status }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <div class="project-date">
                    {{ $product->created_at->format('M d, Y') }}
                </div>

                <a href="{{ route('products.show', $product) }}"
                   class="view-project-link">
                    View product →
                </a>
            </div>
        @empty
            <div class="empty-projects">
                <h3>No products yet</h3>
                <p>Create your first product to start organizing feedback.</p>

                <a href="{{ route('products.create') }}" class="primary-button">
                    Create Your First Product
                </a>
            </div>
        @endforelse
    </section>
</x-app-layout>