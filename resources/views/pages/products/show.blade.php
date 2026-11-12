
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

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <!-- Product Header -->
        <div class="section-heading">
            <div>
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->category }}</p>
            </div>

            <span class="status-{{ $product->status }}">
                {{ ucfirst($product->status) }}
            </span>
        </div>

        <!-- Product Information -->
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

        <!-- Product Payment Information -->
        <div class="project-information mt-6">

            <div class="information-item">
                <label>Product Publishing Fee</label>
                <p>
                    ₱{{ number_format((float) $product->upload_fee, 2) }}
                </p>
            </div>

            <div class="information-item">
                <label>Payment Status</label>

                <p>
                    @if ($product->payment_status === 'paid_simulated' || $product->payment_status === 'paid')
                        <span class="text-green-600 font-semibold">
                            Paid
                        </span>
                    @else
                        <span class="text-amber-600 font-semibold">
                            Pending
                        </span>
                    @endif
                </p>
            </div>

            @if ($product->paid_at)
                <div class="information-item">
                    <label>Payment Date</label>
                    <p>{{ $product->paid_at->format('F d, Y h:i A') }}</p>
                </div>
            @endif

        </div>

        <!-- Product Actions -->
        <div class="form-actions">

            @if ($product->status === 'draft' && $product->payment_status !== 'paid_simulated')
                <a href="{{ route('products.payment', $product) }}"
                    class="sentra-primary-button">
                    Publish Product · ₱150
                </a>
            @endif


            @if ($product->status === 'collecting')
                <form
                    action="{{ route('products.complete', $product) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to complete this product testing? Testers will no longer be able to submit or edit feedback.');"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="sentra-primary-button">
                        Complete Testing
                    </button>
                </form>
            @endif


            @if ($product->status === 'completed')
                <form method="POST"
                    action="{{ route('products.reopen', $product) }}"
                    onsubmit="return confirm('Are you sure you want to reopen testing for this product?')">

                    @csrf
                    @method('PATCH')

                    <button type="submit"
                        class="sentra-primary-button">
                        Reopen Testing
                    </button>
                </form>
            @endif



            @if ($product->status !== 'completed')
                <a href="{{ route('products.edit', $product) }}"
                    class="sentra-primary-button">
                    Edit Product
                </a>
            @endif

            <form action="{{ route('products.destroy', $product) }}"
                method="POST"
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
