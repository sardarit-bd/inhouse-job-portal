@forelse($skills as $skill)
<div class="bg-blue-50 border border-blue-200 text-blue-700 px-3 py-1.5 rounded-full flex items-center">
    {{ $skill->name }}
    @if($skill->level)
    <span class="ml-1.5 text-xs bg-blue-100 px-1.5 py-0.5 rounded">({{ ucfirst($skill->level) }})</span>
    @endif
    <button onclick="deleteItem('{{ route('job-seeker.profile.skill.destroy', $skill) }}', 'skill')" 
            class="ml-2 text-blue-500 hover:text-blue-700 text-xs">
        <i class="fas fa-times"></i>
    </button>
</div>
@empty
<div class="w-full text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
    <i class="fas fa-tools text-gray-400 text-3xl mb-3"></i>
    <p class="text-gray-500">No skills added yet</p>
    <p class="text-gray-400 text-sm mt-1">Click "Add Skill" to get started</p>
</div>
@endforelse