@forelse($educations as $education)
<div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <h3 class="font-medium text-gray-900">{{ $education->degree }}</h3>
            <p class="text-gray-600 mt-1">{{ $education->institution }}</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-1.5"></i>
                <span>{{ $education->start_date->format('M Y') }} - 
                {{ $education->is_current ? 'Present' : ($education->end_date ? $education->end_date->format('M Y') : '') }}</span>
            </div>
        </div>
        <div class="flex space-x-2">
            <button onclick="editEducation({{ $education->id }}, '{{ $education->institution }}', '{{ $education->degree }}', '{{ $education->start_date->format('Y-m-d') }}', '{{ $education->end_date ? $education->end_date->format('Y-m-d') : '' }}', {{ $education->is_current ? 'true' : 'false' }})" 
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Edit
            </button>
            <button onclick="deleteItem('{{ route('job-seeker.profile.education.destroy', $education) }}', 'education')" 
                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                Delete
            </button>
        </div>
    </div>
</div>
@empty
<div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
    <i class="fas fa-graduation-cap text-gray-400 text-3xl mb-3"></i>
    <p class="text-gray-500">No education added yet</p>
    <p class="text-gray-400 text-sm mt-1">Click "Add Education" to get started</p>
</div>
@endforelse