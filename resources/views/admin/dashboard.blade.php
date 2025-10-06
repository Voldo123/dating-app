@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">📊 Панель администратора</h1>

    <!-- Статистика -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <span class="text-2xl">👥</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Всего пользователей</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <span class="text-2xl">💑</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Мэтчи</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_matches'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-rose-100 rounded-lg">
                    <span class="text-2xl">❤️</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Лайки</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_likes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <span class="text-2xl">🆕</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Новые сегодня</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['new_users_today'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Управление пользователями -->
        <a href="{{ route('admin.users') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <span class="text-2xl">👥</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Пользователи</h3>
                    <p class="text-sm text-gray-600">Управление всеми пользователями</p>
                </div>
            </div>
        </a>

        <!-- Управление тегами -->
        <a href="{{ route('admin.tags') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 bg-green-50 rounded-lg">
                    <span class="text-2xl">🏷️</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Теги</h3>
                    <p class="text-sm text-gray-600">Создание и управление тегами</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Недавние пользователи -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">🆕 Недавно зарегистрированные</h2>
        </div>
        <div class="p-6">
            @if($recent_users->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_users as $user)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center">
                                    <span class="text-rose-600">👤</span>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">{{ $user->created_at->format('d.m.Y') }}</p>
                                <span class="inline-block px-2 py-1 text-xs rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $user->role === 'admin' ? 'Админ' : 'Пользователь' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Нет недавних пользователей</p>
            @endif
        </div>
    </div>
</div>
@endsection