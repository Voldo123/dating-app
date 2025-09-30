@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Редактирование пользователя</h1>
        <a href="{{ route('admin.users') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            ← Назад к списку
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Форма редактирования -->
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="editForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Основная информация -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Основная информация</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Имя *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Роль *</label>
                        <select name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent" required>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Пользователь</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Администратор</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Профильная информация -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Профиль</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Возраст</label>
                        <input type="number" name="age" value="{{ old('age', $user->age) }}" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                               min="18" max="100">
                        @error('age')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Пол</label>
                        <select name="gender" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                            <option value="">Не указан</option>
                            <option value="Мужчина" {{ old('gender', $user->gender) == 'Мужчина' ? 'selected' : '' }}>Мужчина</option>
                            <option value="Женщина" {{ old('gender', $user->gender) == 'Женщина' ? 'selected' : '' }}>Женщина</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Город</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telegram</label>
                        <input type="text" name="telegram" value="{{ old('telegram', $user->telegram) }}" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                        @error('telegram')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- О себе -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">О себе</label>
                <textarea name="about" rows="4" 
                          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">{{ old('about', $user->about) }}</textarea>
                @error('about')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Статистика (только для просмотра) -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Статистика</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="font-medium">Отправлено лайков:</span>
                        <span class="ml-2">{{ $user->sentLikes()->count() }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Получено лайков:</span>
                        <span class="ml-2">{{ $user->receivedLikes()->count() }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Мэтчей:</span>
                        <span class="ml-2">{{ $user->matchesCount() }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Зарегистрирован:</span>
                        <span class="ml-2">{{ $user->created_at->format('d.m.Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Кнопки редактирования -->
            <div class="flex justify-between items-center mt-8">
                

                <div class="flex space-x-3">
                    <a href="{{ route('admin.users') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Отмена
                    </a>
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-2 rounded-lg">
                        Сохранить изменения
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection