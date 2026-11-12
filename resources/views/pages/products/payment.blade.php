
<x-guest-layout>

    <div class="w-full max-w-3xl mx-auto px-2">

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-10 h-10 rounded-xl bg-[#7965e8] flex items-center justify-center text-white font-bold text-xl">
                    S
                </div>
                <span class="text-2xl font-extrabold text-slate-800">
                    Testora
                </span>
            </div>

            <h1 class="text-2xl font-bold text-slate-800">
                Publish Your Product
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                Confirm the publishing fee and start collecting feedback.
            </p>
        </div>

        <!-- Main Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- LEFT SIDE: Product Information -->
                <div>

                    <h3 class="text-sm font-bold text-slate-800 mb-5">
                        Product Information
                    </h3>

                    <div class="space-y-5">

                        <!-- Product Name -->
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-[#7965e8] shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>

                            <div>
                                <p class="text-xs font-semibold text-slate-700">
                                    Product Name
                                </p>
                                <p class="text-[11px] text-slate-500 mt-1">
                                    {{ $product->name }}
                                </p>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-[#7965e8] shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M4 4h7l9 9-7 7-9-9V4z"/>
                                <circle cx="8" cy="8" r="1"/>
                            </svg>

                            <div>
                                <p class="text-xs font-semibold text-slate-700">
                                    Category
                                </p>
                                <p class="text-[11px] text-slate-500 mt-1">
                                    {{ $product->category }}
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-[#7965e8] shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M8 10h8m-8 4h5m-9 7l1.5-4.5A8 8 0 1119 19H6z"/>
                            </svg>

                            <div>
                                <p class="text-xs font-semibold text-slate-700">
                                    Description
                                </p>
                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                    {{ $product->description ?: 'No description provided.' }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- After Publishing -->
                    <div class="mt-7 pt-5 border-t border-slate-100">

                        <h3 class="text-sm font-bold text-slate-800 mb-4">
                            What Happens After Publishing?
                        </h3>

                        <div class="space-y-4">

                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#7965e8] shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-[11px] text-slate-500">
                                    Your product status changes to Collecting.
                                </p>
                            </div>

                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#7965e8] shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-[11px] text-slate-500">
                                    Assigned testers can submit their feedback.
                                </p>
                            </div>

                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#7965e8] shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-[11px] text-slate-500">
                                    AI sentiment analysis will process submitted feedback.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDE: Publishing Fee -->
                <div class="border border-slate-100 rounded-xl p-4">

                    <!-- Publishing Fee -->
                    <div class="text-center mb-5">

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            One-Time Product Publishing Fee
                        </p>

                        <h2 class="text-4xl font-extrabold text-[#7965e8] mt-2">
                            ₱{{ number_format((float) $product->upload_fee, 2) }}
                        </h2>

                        <p class="text-xs text-slate-400 mt-2">
                            One-time fee for this product testing project.
                        </p>

                    </div>

                    <!-- Simulated Payment Notice -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4">

                        <div class="flex items-start gap-2">
                            <span class="text-amber-600">ⓘ</span>

                            <div>
                                <p class="text-xs font-semibold text-amber-800">
                                    Simulated Payment Notice
                                </p>

                                <p class="text-[11px] text-amber-700 mt-1 leading-relaxed">
                                    This is a demonstration payment process.
                                    No actual money will be collected or transferred.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Order Summary -->
                    <div class="border border-slate-100 rounded-xl p-4">

                        <div class="flex justify-between text-sm gap-3">
                            <span class="text-slate-500">
                                Product Publishing Fee
                            </span>

                            <span class="font-semibold text-slate-800 whitespace-nowrap">
                                ₱{{ number_format((float) $product->upload_fee, 2) }}
                            </span>
                        </div>

                        <div class="border-t border-slate-100 mt-3 pt-3 flex justify-between">
                            <span class="font-semibold text-slate-700">
                                Total
                            </span>

                            <span class="font-bold text-[#7965e8]">
                                ₱{{ number_format((float) $product->upload_fee, 2) }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Confirmation Button -->
            <div class="mt-6">

                <form method="POST"
                    action="{{ route('products.payment.confirm', $product) }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full py-3 rounded-lg bg-[#7965e8] hover:bg-[#6651d5] text-white font-semibold transition">
                        Confirm Simulated Payment
                    </button>
                </form>

                <!-- Back Link -->
                <div class="text-center mt-5">
                    <a href="{{ route('products.index') }}"
                        class="text-sm text-slate-500 hover:text-[#7965e8]">
                        Back to Products
                    </a>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-400 mt-6">
            © {{ date('Y') }} Testora. All rights reserved.
        </p>

    </div>

</x-guest-layout>
