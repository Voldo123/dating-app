@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Админ-панель</h1>

    <!-- Быстрое меню -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="{{ route('admin.users') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center">
                <span class="text-3xl mr-4">👥</span>
                <div>
                    <h3 class="text-lg font-semibold">Управление пользователями</h3>
                    <p class="text-gray-600">Просмотр и редактирование пользователей</p>
                </div>
            </div>
        </a>

        <a href="/" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center">
                <span class="text-3xl mr-4">🏠</span>
                <div>
                    <h3 class="text-lg font-semibold">На сайт</h3>
                    <p class="text-gray-600">Вернуться на главную</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Последние пользователи -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Последние зарегистрированные</h2>
        </div>
        <div class="p-6">
            @if($recent_users->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_users as $user)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-rose-200 rounded-full flex items-center justify-center">
                                <span class="text-rose-600 font-bold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Пользователей пока нет</p>
            @endif
        </div>
    </div>
</div>
@endsection