@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Редактировать профиль</h2>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="number" name="age" value="{{ old('age', $user->age) }}" placeholder="Возраст" class="w-full mb-3 p-2 border rounded">

        <select name="gender" class="w-full mb-3 p-2 border rounded">
            <option value="">Выберите пол</option>
            <option value="Мужчина" {{ old('gender', $user->gender) == 'Мужчина' ? 'selected' : '' }}>Мужчина</option>
            <option value="Женщина" {{ old('gender', $user->gender) == 'Женщина' ? 'selected' : '' }}>Женщина</option>
        </select>

        <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="Город" class="w-full mb-3 p-2 border rounded">
        <textarea name="about" placeholder="О себе" class="w-full mb-3 p-2 border rounded">{{ old('about', $user->about) }}</textarea>
        <input type="text" name="telegram" value="{{ old('telegram', $user->telegram) }}" placeholder="Телеграм" class="w-full mb-3 p-2 border rounded">

        <!-- 👇 Блок выбора тегов -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Теги (максимум 3):</label>
            <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-3">
                @foreach($tags as $tag)
                    <label class="flex items-center">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                               class="tag-checkbox rounded border-gray-300 text-rose-500 focus:ring-rose-500"
                               {{ in_array($tag->id, old('tags', $user->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm">#{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('tags')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1" id="tag-counter">Выбрано: {{ $user->tags->count() }}/3</p>
        </div>

        <!-- Поле для фото -->
        <div class="mb-3">
            <label class="block mb-1">Фото профиля</label>
            <input type="file" name="photo" accept="image/*" class="w-full p-2 border rounded">
            @if($user->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Фото профиля" class="w-24 h-24 object-cover rounded-full">
                </div>
            @endif
        </div>

        <button class="bg-rose-500 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
</div>

<script>
// Тот же скрипт для ограничения тегов
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.tag-checkbox');
    const counter = document.getElementById('tag-counter');
    
    function updateCounter() {
        const checked = document.querySelectorAll('.tag-checkbox:checked').length;
        counter.textContent = `Выбрано: ${checked}/3`;
        
        checkboxes.forEach(checkbox => {
            if (checked >= 3 && !checkbox.checked) {
                checkbox.disabled = true;
            } else {
                checkbox.disabled = false;
            }
        });
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCounter);
    });
    
    updateCounter();
});
</script>
@endsection