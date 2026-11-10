<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">TESTORA ADMINISTRATION</span>
            <h1>Create Tester Account</h1>
            <p>Create a login account and assign testing products.</p>
        </div>
    </div>

    <div class="settings-card user-form-card">

        <form method="POST" action="{{ route('users.store') }}" class="settings-grid">
            @csrf

            <div class="form-section">
                <h2>Tester Information</h2>
                <p>Enter the Tester's personal and account details.</p>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter full name"
                        required
                    >
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter email address"
                        required
                    >
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Product Assignment</h2>
                <p>Select the testing products this Tester will participate in.</p>

                @error('product_ids')
                    <span class="field-error">{{ $message }}</span>
                @enderror

                @if ($products->isEmpty())
                    <p class="text-muted">
                        You don't have any products available for assignment yet.
                    </p>
                @else
                    <div class="project-assignment-list">
                        @foreach ($products as $product)
                            <label class="project-assignment-option">
                                <input
                                    type="checkbox"
                                    name="product_ids[]"
                                    value="{{ $product->id }}"
                                    {{ in_array($product->id, old('product_ids', [])) ? 'checked' : '' }}
                                >

                                <span>
                                    <strong>{{ $product->name }}</strong>
                                    <small>{{ $product->category }} · {{ ucfirst($product->status) }}</small>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    @error('product_ids.*')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                @endif
            </div>

            <div class="form-actions" style="grid-column: 1 / -1;>
                <a href="{{ route('users.index') }}" class="cancel-button">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="sentra-primary-button"
                    {{ $products->isEmpty() ? 'disabled' : '' }}
                >
                    Create Tester Account
                </button>
            </div>
        </form>

    </div>
</x-app-layout>