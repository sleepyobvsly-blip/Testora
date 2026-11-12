
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

    <!-- Success Message -->
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <!-- Information Message -->
    @if (session('info'))
        <div class="success-message">
            {{ session('info') }}
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

                <!-- Product Details -->
                <div class="project-details">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->category }}</p>

                    @if ($product->description)
                        <p>{{ $product->description }}</p>
                    @endif

                    @if ($product->status === 'draft')
                        <p class="text-xs text-amber-600 mt-1">
                            Payment:
                            {{ $product->payment_status === 'paid_simulated' ? 'Paid' : 'Pending' }}
                        </p>
                    @endif
                </div>

                <!-- Product Status -->
                <div class="project-status">
                    <span class="status-{{ $product->status }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <!-- Date Created -->
                <div class="project-date">
                    {{ $product->created_at->format('M d, Y') }}
                </div>

                <!-- Product Actions -->
                <div class="flex items-center gap-3 flex-wrap">

                    @if ($product->status === 'draft' && $product->payment_status !== 'paid_simulated')
                        {{-- <a
                            href="{{ route('products.payment', $product) }}"
                            class="sentra-primary-button"
                        >
                            Publish Product · ₱50
                        </a> --}}
                    @endif

                    <a
                        href="{{ route('products.show', $product) }}"
                        class="view-project-link"
                    >
                        View product →
                    </a>

                </div>

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
