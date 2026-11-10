
<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Manage Product Assignments</h1>
            <p>Update the products assigned to {{ $user->name }}.</p>
        </div>

        <a href="{{ route('users.index') }}" class="sentra-primary-button">
            ← Back to Users
        </a>
    </div>

    <section class="projects-section">
        <div class="section-heading">
            <div>
                <h2>Available Products</h2>
                <p>Select the products this Tester should have access to.</p>
            </div>
        </div>

        <form action="{{ route('users.assignments.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="error-message">
                    Please check your product selections.
                </div>
            @endif

            <div class="assignment-list">
                @forelse ($products as $product)
                    <label class="assignment-item">
                        <input
                            type="checkbox"
                            name="product_ids[]"
                            value="{{ $product->id }}"
                            {{ in_array($product->id, old('product_ids', $assignedProductIds)) ? 'checked' : '' }}
                        >

                        <div>
                            <strong>{{ $product->name }}</strong>
                            <p>{{ $product->category }}</p>
                        </div>
                    </label>
                @empty
                    <p>No products are available. Create a product first.</p>
                @endforelse
            </div>

            @error('product_ids')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="sentra-primary-button">
                Save Assignments
            </button>
        </form>
    </section>
</x-app-layout>
