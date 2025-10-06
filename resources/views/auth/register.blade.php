@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <div class="text-center mb-6">
        <div class="text-5xl mb-3">✨</div>
        <h2 class="text-2xl font-bold">Регистрация</h2>
    </div>
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <input type="text" name="name" placeholder="Имя" class="input" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
        </div>
        <div>
            <input type="email" name="email" placeholder="Email" class="input" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
        </div>
        <div>
            <input type="password" name="password" placeholder="Пароль" class="input" required>
            @error('password')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
        </div>
        <div>
            <input type="password" name="password_confirmation" placeholder="Подтверждение пароля" class="input" required>
        </div>

        <!-- 👇 Блок выбора тегов -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Выберите теги (максимум 3):</label>
            <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-3">
                @foreach($tags as $tag)
                    <label class="flex items-center">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                               class="tag-checkbox rounded border-gray-300 text-rose-500 focus:ring-rose-500"
                               {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm">#{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('tags')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1" id="tag-counter">Выбрано: 0/3</p>
        </div>

        <button class="btn btn-rose w-full">Зарегистрироваться</button>
    </form>
    <p class="mt-4 text-center">
        Есть аккаунт? <a href="{{ route('login.show') }}" class="text-rose-600 font-semibold">Войти</a>
    </p>
</div>

<script>
// Ограничение выбора тегов (максимум 3)
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.tag-checkbox');
    const counter = document.getElementById('tag-counter');
    
    function updateCounter() {
        const checked = document.querySelectorAll('.tag-checkbox:checked').length;
        counter.textContent = `Выбрано: ${checked}/3`;
        
        // Блокируем остальные checkbox если выбрано 3
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
    
    updateCounter(); // Инициализация
});
</script>
@endsection