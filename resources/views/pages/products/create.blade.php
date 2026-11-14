
<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Create New Offering</h1>
            <p>Set up a product, service, or college course for testing.</p>
        </div>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Offering Information</h2>
                <p>Enter the details of the offering you want to evaluate.</p>
            </div>
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="offering_type">Offering Type</label>
                <select id="offering_type" name="offering_type" required>
                    <option value="">Select offering type</option>
                    <option value="product" {{ old('offering_type') == 'product' ? 'selected' : '' }}>Product</option>
                    <option value="service" {{ old('offering_type') == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="college_course" {{ old('offering_type') == 'college_course' ? 'selected' : '' }}>College Course</option>
                </select>
                @error('offering_type')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Offering Name</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="business_name">Business / Institution Name</label>
                <input type="text" id="business_name" name="business_name"
                    value="{{ old('business_name') }}" required>
                @error('business_name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="business_address">Business / Institution Address</label>
                <textarea id="business_address" name="business_address"
                    rows="2" required>{{ old('business_address') }}</textarea>
                @error('business_address')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category"
                    value="{{ old('category') }}" required>
                @error('category')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Offering Description</label>
                <textarea id="description" name="description"
                    rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('products.index') }}" class="cancel-button">
                    Cancel
                </a>

                <button type="submit" class="sentra-primary-button">
                    Create Offering
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
                const selectedType = offeringType.value;
                const selectedPlaceholders = placeholders[selectedType];

                Object.keys(fields).forEach(function (key) {
                    fields[key].placeholder =
                        selectedPlaceholders ? selectedPlaceholders[key] : '';
                });
            }

            offeringType.addEventListener('change', updatePlaceholders);

            updatePlaceholders();
        });
    </script>
</x-app-layout>
