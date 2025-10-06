@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <!-- Заголовок -->
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">💕</div>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Ваши мэтчи</h1>
        <p class="text-xl text-gray-600">Люди, которые понравились вам взаимно</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center">
            <span class="text-xl mr-3">✅</span>
            {{ session('success') }}
        </div>
    @endif

    @php
        $matches = Auth::user()->getAllMatches();
    @endphp

    @if($matches->count() > 0)
        <!-- Статистика -->
        <div class="bg-gradient-to-r from-rose-500 to-pink-500 rounded-2xl p-6 text-white mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">🎉 Поздравляем!</h3>
                    <p class="text-rose-100">У вас {{ $matches->count() }} {{ trans_choice('мэтч|мэтча|мэтчей', $matches->count()) }}</p>
                </div>
                <div class="text-4xl">🥳</div>
            </div>
        </div>

        <!-- Сетка мэтчей -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($matches as $match)
                @php
                    $partner = $match->user1_id === Auth::id() ? $match->user2 : $match->user1;
                @endphp
                
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-rose-100">
                    <!-- Верхняя часть с фото и основной информацией -->
                    <div class="relative">
                        <!-- Фото профиля -->
                        <div class="h-48 bg-gradient-to-br from-rose-100 to-pink-200 relative overflow-hidden">
                            @if($partner->photo)
                                <img src="{{ asset('storage/' . $partner->photo) }}" 
                                     alt="{{ $partner->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-6xl text-rose-300">👤</span>
                                </div>
                            @endif
                            
                            <!-- Бейдж мэтча -->
                            <div class="absolute top-4 right-4">
                                <span class="bg-rose-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center">
                                    <span class="mr-1">💕</span> Мэтч
                                </span>
                            </div>
                        </div>

                        <!-- Аватар поверх фото -->
                        <div class="absolute -bottom-6 left-6">
                            <div class="w-16 h-16 rounded-2xl border-4 border-white bg-white shadow-lg overflow-hidden">
                                @if($partner->photo)
                                    <img src="{{ asset('storage/' . $partner->photo) }}" 
                                         alt="{{ $partner->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-rose-100 flex items-center justify-center">
                                        <span class="text-rose-600 font-bold text-lg">
                                            {{ substr($partner->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Информация о пользователе -->
                    <div class="pt-8 pb-6 px-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $partner->name }}</h3>
                        
                        <div class="flex items-center text-sm text-gray-600 mb-3 space-x-3">
                            @if($partner->age)
                                <span class="flex items-center">
                                    <span class="mr-1">🎂</span> {{ $partner->age }} лет
                                </span>
                            @endif
                            @if($partner->gender)
                                <span class="flex items-center">
                                    <span class="mr-1">{{ $partner->gender == 'Мужчина' ? '👨' : '👩' }}</span>
                                    {{ $partner->gender }}
                                </span>
                            @endif
                            @if($partner->city)
                                <span class="flex items-center">
                                    <span class="mr-1">🏙️</span> {{ $partner->city }}
                                </span>
                            @endif
                        </div>

                        <!-- О себе -->
                        @if($partner->about)
                            <p class="text-gray-700 mb-4 line-clamp-2 text-sm leading-relaxed">
                                "{{ Str::limit($partner->about, 100) }}"
                            </p>
                        @else
                            <p class="text-gray-500 text-sm mb-4">Пока ничего не рассказал(а) о себе</p>
                        @endif

                        <!-- Теги -->
                        @if($partner->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach($partner->tags->take(3) as $tag)
                                    <span class="bg-rose-50 text-rose-700 px-2 py-1 rounded-full text-xs">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                                @if($partner->tags->count() > 3)
                                    <span class="text-gray-400 text-xs">+{{ $partner->tags->count() - 3 }}</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Кнопки действий -->
                    <div class="px-6 pb-6">
                        <div class="flex space-x-3">
                            <a href="{{ route('profile.show', $partner->id) }}"
                               class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-3 rounded-xl flex-1 text-center transition duration-200 flex items-center justify-center font-semibold">
                                <span class="mr-2">👀</span> Профиль
                            </a>
                            
                            @if($partner->telegram)
                                <a href="https://t.me/{{ ltrim($partner->telegram, '@') }}" 
                                   target="_blank"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-xl transition duration-200 flex items-center justify-center font-semibold min-w-[120px]">
                                    <span class="mr-2">✈️</span> Telegram
                                </a>
                            @endif
                        </div>

                        <!-- Дата мэтча -->
                        <div class="mt-3 text-xs text-gray-500 text-center flex items-center justify-center">
                            <span class="mr-2">⏰</span>
                            Нашли друг друга {{ $match->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Подсказка -->
        <div class="text-center mt-8">
            <p class="text-gray-600">💡 Напишите своим мэтчам первыми - это увеличит шансы на общение!</p>
        </div>

    @else
        <!-- Состояние без мэтчей -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center max-w-2xl mx-auto">
            <div class="text-8xl mb-6">💔</div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Мэтчей пока нет</h3>
            <p class="text-gray-600 text-lg mb-2">Вы еще не нашли взаимную симпатию</p>
            <p class="text-gray-500 mb-8">Ставьте лайки пользователям, и когда они ответят взаимностью - здесь появится мэтч!</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('feed.index') }}" 
                   class="bg-rose-500 hover:bg-rose-600 text-white px-8 py-4 rounded-xl transition duration-200 font-semibold text-lg flex items-center justify-center">
                    <span class="mr-3">🔥</span> Начать оценивать
                </a>
                <a href="{{ route('search.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-xl transition duration-200 font-semibold text-lg flex items-center justify-center">
                    <span class="mr-3">🔍</span> Поиск людей
                </a>
            </div>

            <!-- Советы -->
            <div class="mt-8 p-6 bg-rose-50 rounded-xl border border-rose-200">
                <h4 class="font-semibold text-gray-900 mb-3 flex items-center justify-center">
                    <span class="mr-2">💡</span> Советы для успеха:
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
                    <div class="flex items-center">
                        <span class="mr-2">✅</span> Заполните профиль полностью
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">✅</span> Добавьте качественное фото
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">✅</span> Укажите свои интересы
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">✅</span> Будьте активны в ленте
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.hover-lift:hover {
    transform: translateY(-5px);
}
</style>
@endsection