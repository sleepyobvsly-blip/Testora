
<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Edit Offering</h1>
            <p>Update your offering information.</p>
        </div>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Offering Information</h2>
                <p>Modify the details of your offering.</p>
            </div>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="offering_type">Offering Type</label>
                <select id="offering_type" name="offering_type" required>
                    <option value="">Select offering type</option>
                    <option value="product" {{ old('offering_type', $product->offering_type) == 'product' ? 'selected' : '' }}>Product</option>
                    <option value="service" {{ old('offering_type', $product->offering_type) == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="college_course" {{ old('offering_type', $product->offering_type) == 'college_course' ? 'selected' : '' }}>College Course</option>
                </select>
                @error('offering_type')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Offering Name</label>
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

            <div class="form-group">
                <label for="business_name">Business / Institution Name</label>
                <input
                    type="text"
                    id="business_name"
                    name="business_name"
                    value="{{ old('business_name', $product->business_name) }}"
                    required
                >
                @error('business_name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="business_address">Business / Institution Address</label>
                <textarea
                    id="business_address"
                    name="business_address"
                    rows="2"
                    required
                >{{ old('business_address', $product->business_address) }}</textarea>
                @error('business_address')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
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

            <div class="form-group">
                <label for="description">Offering Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Current Offering Status</label>

                <div class="project-status">
                    <span class="status-{{ $product->status }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <p class="text-xs text-slate-500 mt-2">
                    Offering status is managed automatically by Testora.
                </p>
            </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const offeringType = document.getElementById('offering_type');

            const fields = {
                name: document.getElementById('name'),
                business_name: document.getElementById('business_name'),
                business_address: document.getElementById('business_address'),
                category: document.getElementById('category'),
                description: document.getElementById('description')
            };

            const placeholders = {
                product: {
                    name: 'Enter product name',
                    business_name: 'Enter business name',
                    business_address: 'Enter business address',
                    category: 'Enter product category',
                    description: 'Provide a detailed description of the product, including its features and purpose...'
                },
                service: {
                    name: 'Enter service name',
                    business_name: 'Enter business name',
                    business_address: 'Enter business address',
                    category: 'Enter service category',
                    description: 'Describe the service, its features, and the experience offered to participants...'
                },
                college_course: {
                    name: 'Enter course or academic program name',
                    business_name: 'Enter institution name',
                    business_address: 'Enter institution address',
                    category: 'Enter academic program category',
                    description: 'Describe the course, proposed curriculum, learning objectives, and potential career opportunities...'
                }
            };

            function updatePlaceholders() {
                const selectedPlaceholders = placeholders[offeringType.value];

                Object.keys(fields).forEach(function (key) {
                    fields[key].placeholder = selectedPlaceholders
                        ? selectedPlaceholders[key]
                        : '';
                });
            }

            offeringType.addEventListener('change', updatePlaceholders);

            updatePlaceholders();
        });
    </script>
</x-app-layout>
