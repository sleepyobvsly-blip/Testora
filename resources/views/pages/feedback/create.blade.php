<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Submit Feedback</h1>
            <p>Record feedback about a product or service being tested.</p>
        </div>

        {{-- <a href="{{ route('feedback.index') }}" class="sentra-primary-button">
            ← Back to Feedback
        </a> --}}
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Feedback Information</h2>
                <p>Select a product and enter the feedback response.</p>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="empty-projects">
                <h3>No active products available</h3>
                <p>You need a product with Collecting status before submitting feedback.</p>

                <a href="{{ route('products.index') }}" class="primary-button">
                    View Products
                </a>
            </div>
        @else
            <form action="{{ route('feedback.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="product_id">Select Product</label>

                    <select id="product_id" name="product_id" required>
                        <option value="">Choose a product</option>

                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            >
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('product_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="feedback_text">Feedback Response</label>

                    <textarea
                        id="feedback_text"
                        name="feedback_text"
                        rows="7"
                        placeholder="Write the customer's feedback here..."
                        required
                    >{{ old('feedback_text') }}</textarea>

                    @error('feedback_text')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('feedback.index') }}" class="cancel-button">
                        Cancel
                    </a>

                    <button type="submit" class="sentra-primary-button">
                        Submit Feedback
                    </button>
                </div>
            </form>
        @endif
    </section>
</x-app-layout>