
<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">TESTER WORKSPACE</span>
            <h1>My Assigned Products</h1>
            <p>View the products assigned to you and share your feedback.</p>
        </div>
    </div>

    <div class="settings-card user-management-card">
        <div class="user-table-header">
            <div>
                <h2>Your Products</h2>
                <p>Products assigned to your Tester account.</p>
            </div>

            <span>{{ $products->count() }} Products</span>
        </div>

        @if ($products->isEmpty())
            <div class="empty-state">
                <h3>No Assigned Products Yet</h3>
                <p>
                    You don't have any assigned products.
                    Please contact your Administrator.
                </p>
            </div>
        @else
            <div class="project-list">
                @foreach ($products as $product)
                    <div class="settings-card project-item-card">
                        <div>
                            <span class="page-eyebrow">
                                {{ $product->category }}
                            </span>

                            <h3>{{ $product->name }}</h3>

                            <p>
                                {{ $product->description ?: 'No product description available.' }}
                            </p>

                           <div class="project-item-meta">
                                <span>
                                    {{ $product->feedback_count }} Feedback Responses
                                </span>

                                <span class="status-active">
                                    {{ ucfirst($product->status) }}
                                </span>

                                <br/>

                                <span>
                                    My Feedback:

                                    @if ($product->status !== 'collecting')
                                        <span class="status-closed">Closed</span>
                                    @elseif ($product->has_my_feedback)
                                        <span class="status-submitted">Submitted</span>
                                    @else
                                        <span class="status-pending">Pending</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <a
                            href="{{ route('tester.products.show', $product->id) }}"
                            class="sentra-primary-button"
                        >
                            View Product
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
