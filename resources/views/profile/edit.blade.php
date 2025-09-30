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
@endsection