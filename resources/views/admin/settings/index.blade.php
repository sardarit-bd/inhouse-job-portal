@extends('layouts.admin')

@section('title', 'Settings - Admin Panel')
@section('page-title', 'Site Settings')
@section('page-subtitle', 'Manage site configuration')

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow rounded-lg">
        <!-- <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                General Settings
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Update your site settings and information.
            </p>
        </div> -->

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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Logo</label>

                        @if(!empty($settings['site_logo']))
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}"
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
                                      file:text-sm file:font-medium
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-400">
                            Max size: 5MB. Allowed: PNG, JPG, GIF, SVG
                        </p>
                    </div>

                    {{-- ================= Site Name ================= --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Site Name</label>
                        <input type="text"
                               name="site_name"
                               value="{{ $settings['site_name'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    {{-- ================= Contact Email ================= --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Email</label>
                        <input type="email"
                               name="contact_email"
                               value="{{ $settings['contact_email'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    {{-- ================= Contact Phone ================= --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Phone</label>
                        <input type="text"
                               name="contact_phone"
                               value="{{ $settings['contact_phone'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    {{-- ================= Contact Address ================= --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Address</label>
                        <textarea name="contact_address" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= About Us ================= --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">About Us</label>
                        <textarea name="about_us" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $settings['about_us'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= Privacy Policy ================= --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Privacy Policy</label>
                        <textarea name="privacy_policy" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $settings['privacy_policy'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= Terms & Conditions ================= --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Terms & Conditions</label>
                        <textarea name="terms_conditions" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $settings['terms_conditions'] ?? '' }}</textarea>
                    </div>

                    {{-- ================= Save Button ================= --}}
                    <div class="pt-5 text-right">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-6 text-sm font-medium text-white rounded-md bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
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
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteLogoForm').submit();
        }
    });
}
</script>
@endpush
