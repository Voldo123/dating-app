@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <div class="flex items-center mb-4">
        <!-- Фото профиля -->
        <div class="w-24 h-24 bg-gray-200 rounded-full overflow-hidden">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Фото {{ $user->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">👤</div>
            @endif
        </div>
        <div class="ml-4">
            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
            <p>{{ $user->age }} лет, {{ $user->city }}</p>
            <p>{{ $user->gender }}</p>
        </div>
    </div>
    <p class="mb-4">{{ $user->about }}</p>
    <div>
        <a href="{{ route('profile.edit') }}" class="bg-rose-500 text-white px-4 py-2 rounded">Редактировать</a>
    </div>
</div>
@endsection