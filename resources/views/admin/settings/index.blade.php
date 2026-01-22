@extends('layouts.admin')

@section('title', 'Settings - Admin Panel')
@section('page-title', 'Site Settings')
@section('page-subtitle', 'Manage site configuration')

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            {{-- ===================== Settings Form ===================== --}}
            <form action="{{ route('admin.settings.update') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="settingsForm">
                @csrf

                <div class="space-y-6">

                    {{-- ================= Site Logo ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700 mb-2">Site Logo</label>

                        @php
                            $siteLogo = $settings['site_logo'] ?? null;
                            $logoUrl = $siteLogo ? asset('storage/' . $siteLogo) : null;
                        @endphp

                        @if($logoUrl)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $logoUrl }}"
                                         class="h-16 w-auto object-contain border rounded">
                                    <button type="button"
                                            onclick="deleteLogo()"
                                            class="text-sm text-red-600 border border-red-300 px-3 py-1 rounded hover:bg-red-50">
                                        Remove Logo
                                    </button>
                                </div>
                            </div>
                        @endif

                        <input type="file"
                               name="site_logo"
                               id="site_logo"
                               accept=".png,.jpg,.jpeg,.gif,.svg,.webp"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-400">
                            Max size: 5MB. Allowed: PNG, JPG, GIF, SVG, WEBP
                        </p>
                    </div>

                    {{-- ================= Favicon ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700 mb-2">Favicon</label>

                        @php
                            $favicon = $settings['favicon'] ?? null;
                            $faviconUrl = $favicon ? asset('storage/' . $favicon) : null;
                        @endphp

                        @if($faviconUrl)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Favicon:</p>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $faviconUrl }}"
                                             class="h-10 w-10 object-contain border rounded">
                                        <!-- <div>
                                            <p class="text-xs text-gray-500">Preview in browser tab:</p>
                                            <div class="flex items-center mt-1">
                                                <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                                <div class="w-32 h-6 bg-gray-200 rounded ml-2 flex items-center px-2">
                                                    <div class="w-4 h-4 mr-2">
                                                        <img src="{{ $faviconUrl }}" 
                                                             class="w-full h-full object-contain">
                                                    </div>
                                                    <span class="text-xs text-gray-600">Website</span>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <button type="button"
                                            onclick="deleteFavicon()"
                                            class="text-sm text-red-600 border border-red-300 px-3 py-1 rounded hover:bg-red-50">
                                        Remove Favicon
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="mb-4 p-3">
                                <p class="text-sm text-gray-400">No favicon uploaded. Default favicon will be used.</p>
                            </div>
                        @endif

                        <input type="file"
                               name="favicon"
                               id="favicon"
                               accept=".ico,.png,.jpg,.jpeg,.gif,.svg"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-400">
                            Max size: 2MB. Recommended: ICO, PNG (32x32 or 64x64)
                        </p>
                    </div>

                    {{-- ================= Site Name ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700">Site Name</label>
                        <input type="text"
                               name="site_name"
                               value="{{ $settings['site_name'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    {{-- ================= Contact Email ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700">Contact Email</label>
                        <input type="email"
                               name="contact_email"
                               value="{{ $settings['contact_email'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    {{-- ================= Contact Phone ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700">Contact Phone</label>
                        <input type="text"
                               name="contact_phone"
                               value="{{ $settings['contact_phone'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    {{-- ================= Contact Address ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700">Contact Address</label>
                        <textarea name="contact_address" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= About Us ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700">About Us</label>
                        <textarea name="about_us" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['about_us'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= Privacy Policy ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700">Privacy Policy</label>
                        <textarea name="privacy_policy" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['privacy_policy'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= Terms & Conditions ================= --}}
                    <div>
                        <label class="block text-md font-semibold text-gray-700">Terms & Conditions</label>
                        <textarea name="terms_conditions" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['terms_conditions'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= Save Button ================= --}}
                    <div class="pt-5 text-right">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-6 text-sm font-semibold text-white rounded-md bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Settings
                        </button>
                    </div>

                </div>
            </form>

            {{-- ================= Hidden Delete Logo Form ================= --}}
            <form id="deleteLogoForm"
                action="{{ route('admin.settings.deleteLogo') }}"
                method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            {{-- ================= Hidden Delete Favicon Form ================= --}}
            <form id="deleteFaviconForm"
                action="{{ route('admin.settings.deleteFavicon') }}"
                method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ================= Logo Delete ================= */
function deleteLogo() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to remove the site logo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteLogoForm').submit();
        }
    });
}

/* ================= Favicon Delete ================= */
function deleteFavicon() {
    Swal.fire({
        title: 'Remove Favicon?',
        text: 'You want to remove the site favicon?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteFaviconForm').submit();
        }
    });
}

/* ================= Form Validation ================= */
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    const logoInput = document.getElementById('site_logo');
    const faviconInput = document.getElementById('favicon');
    
    // Logo size validation
    if (logoInput.files.length > 0) {
        const logoFile = logoInput.files[0];
        if (logoFile.size > 5 * 1024 * 1024) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Logo file must be less than 5MB',
                confirmButtonColor: '#4f46e5',
            });
            return;
        }
    }
    
    // Favicon size validation
    if (faviconInput.files.length > 0) {
        const faviconFile = faviconInput.files[0];
        if (faviconFile.size > 2 * 1024 * 1024) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Favicon file must be less than 2MB',
                confirmButtonColor: '#4f46e5',
            });
            return;
        }
    }
});
</script>
@endpush