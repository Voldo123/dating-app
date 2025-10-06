@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <!-- Профиль пользователя -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Верхний баннер -->
        <div class="h-32 bg-gradient-to-r from-rose-400 to-pink-500 relative">
            <!-- Аватар поверх баннера -->
            <div class="absolute -bottom-16 left-8">
                <div class="w-32 h-32 rounded-2xl border-4 border-white bg-white shadow-lg overflow-hidden">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" 
                             alt="Фото {{ $user->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-rose-100 to-pink-200 flex items-center justify-center">
                            <span class="text-4xl text-rose-600">👤</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Основная информация -->
        <div class="pt-20 pb-8 px-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                    
                    <!-- Основные данные -->
                    <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-4">
                        @if($user->age)
                            <span class="flex items-center bg-rose-50 px-3 py-1 rounded-full text-sm">
                                <span class="mr-2">🎂</span> {{ $user->age }} лет
                            </span>
                        @endif
                        
                        @if($user->gender)
                            <span class="flex items-center bg-blue-50 px-3 py-1 rounded-full text-sm">
                                <span class="mr-2">{{ $user->gender == 'Мужчина' ? '👨' : '👩' }}</span>
                                {{ $user->gender }}
                            </span>
                        @endif
                        
                        @if($user->city)
                            <span class="flex items-center bg-green-50 px-3 py-1 rounded-full text-sm">
                                <span class="mr-2">🏙️</span> {{ $user->city }}
                            </span>
                        @endif
                    </div>

                    <!-- Telegram -->
                    @if($user->telegram)
                        <div class="flex items-center mb-4">
                            <span class="flex items-center bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                <span class="mr-2">✈️</span> 
                                <a href="https://t.me/{{ ltrim($user->telegram, '@') }}" 
                                   target="_blank" 
                                   class="hover:underline">
                                    {{ $user->telegram }}
                                </a>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Кнопка редактирования (только для своего профиля) -->
                @if(Auth::id() === $user->id)
                    <a href="{{ route('profile.edit') }}" 
                       class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-xl transition duration-200 flex items-center font-semibold">
                        <span class="mr-2">✏️</span> Редактировать
                    </a>
                @else
                    <!-- Кнопки действий для чужого профиля -->
                    <div class="flex space-x-3">
                        @if(Auth::user()->hasLiked($user->id))
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-xl flex items-center text-sm">
                                <span class="mr-2">❤️</span> Лайкнуто
                            </span>
                        @elseif(Auth::user()->hasDisliked($user->id))
                            <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl flex items-center text-sm">
                                <span class="mr-2">❌</span> Дизлайкнуто
                            </span>
                        @else
                            <form action="{{ route('feed.like', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl transition duration-200 flex items-center">
                                    <span class="mr-2">❤️</span> Лайк
                                </button>
                            </form>
                            <form action="{{ route('feed.dislike', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl transition duration-200 flex items-center">
                                    <span class="mr-2">❌</span> Дизлайк
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

            <!-- О себе -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="mr-2">📝</span> О себе
                </h3>
                @if($user->about)
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <p class="text-gray-700 leading-relaxed text-lg">{{ $user->about }}</p>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 text-center">
                        <p class="text-gray-500">Пользователь пока не рассказал о себе</p>
                    </div>
                @endif
            </div>

            <!-- Теги/Интересы -->
            @if($user->tags->count() > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="mr-2">🏷️</span> Интересы
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($user->tags as $tag)
                            <span class="bg-gradient-to-r from-rose-100 to-pink-200 text-rose-700 px-4 py-2 rounded-xl font-medium">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Статистика (только для своего профиля) -->
            @if(Auth::id() === $user->id)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                    <div class="bg-rose-50 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-rose-600 mb-1">{{ $user->sentLikes()->count() }}</div>
                        <div class="text-sm text-rose-700">Отправлено лайков</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600 mb-1">{{ $user->receivedLikes()->count() }}</div>
                        <div class="text-sm text-blue-700">Получено лайков</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-green-600 mb-1">{{ $user->matchesCount() }}</div>
                        <div class="text-sm text-green-700">Мэтчей</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600 mb-1">{{ $user->tags->count() }}</div>
                        <div class="text-sm text-purple-700">Интересов</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Дополнительные действия -->
    @if(Auth::id() !== $user->id)
        <div class="mt-6 flex justify-center space-x-4">
            <a href="{{ route('feed.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition duration-200 flex items-center font-semibold">
                <span class="mr-2">🔥</span> Вернуться в ленту
            </a>
            <a href="{{ route('matches.index') }}" 
               class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-xl transition duration-200 flex items-center font-semibold">
                <span class="mr-2">💕</span> Мои мэтчи
            </a>
        </div>
    @endif
</div>

<style>
.gradient-border {
    background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
    border: 1px solid transparent;
    background-clip: padding-box;
}
</style>
@endsection