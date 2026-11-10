
<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <span class="page-eyebrow">TESTER WORKSPACE</span>
            <h1>{{ $product->name }}</h1>
            <p>Review the product details before submitting your feedback.</p>
        </div>

        <a href="{{ route('tester.products.index') }}" class="sentra-primary-button">
            ← Back to Products
        </a>
    </div>

    <div class="settings-card">
        <div class="form-section">
            <span class="page-eyebrow">PROJECT INFORMATION</span>

            <h2>{{ $product->name }}</h2>

            <p>{{ $product->description ?: 'No product description available.' }}</p>
        </div>

        <div class="project-item-meta">
            <div>
                <strong>Category</strong>
                <p>{{ $product->category }}</p>
            </div>

            <div>
                <strong>Product Status</strong>
                <p>{{ ucfirst($product->status) }}</p>
            </div>

            <div>
                <strong>Feedback Responses</strong>
                <p>{{ $product->feedback_count }}</p>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 25px;">

            @if ($myFeedback)
                <a href="{{ route('feedback.edit', $myFeedback) }}" class="sentra-primary-button">
                    Edit My Feedback
                </a>

            @elseif ($product->status === 'collecting')
                <a href="{{ route('feedback.create', ['product_id' => $product->id]) }}" class="sentra-primary-button">
                    Submit Feedback
                </a>

            @else
                <span class="text-muted">
                    Feedback submission is closed.
                </span>
            @endif

        </div>
    </div>
</x-app-layout>
