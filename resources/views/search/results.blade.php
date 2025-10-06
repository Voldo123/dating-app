@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold">🔍 Результаты поиска</h2>
        <p class="text-gray-600 mt-2">Найдено анкет: <span class="font-bold text-rose-500">{{ $resultsCount }}</span></p>
    </div>

    @if($users->isEmpty())
        <div class="text-center py-12">
            <div class="text-6xl mb-4">😔</div>
            <p class="text-xl text-gray-600">По вашему запросу ничего не найдено</p>
            <a href="{{ route('search.index') }}" class="btn btn-rose mt-4">🔄 Попробовать другие критерии</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($users as $user)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <!-- Фото профиля -->
                    <div class="relative h-48 bg-gradient-to-br from-rose-100 to-pink-200">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-6xl text-rose-300">
                                👤
                            </div>
                        @endif
                        
                        <!-- Возраст и город -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <h3 class="text-white font-bold text-lg">{{ $user->name }}</h3>
                            <p class="text-white/90 text-sm">
                                {{ $user->age }} лет • {{ $user->city }}
                            </p>
                        </div>
                        
                        <!-- Пол -->
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $user->gender == 'Мужчина' ? '👨' : '👩' }}
                            </span>
                        </div>
                    </div>

                    <!-- Информация -->
                    <div class="p-4">
                        <!-- О себе -->
                        @if($user->about)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                "{{ Str::limit($user->about, 80) }}"
                            </p>
                        @endif

                        <!-- Теги -->
                        @if($user->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach($user->tags->take(3) as $tag)
                                    <span class="bg-rose-50 text-rose-700 px-2 py-1 rounded-full text-xs">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                                @if($user->tags->count() > 3)
                                    <span class="text-gray-400 text-xs">+{{ $user->tags->count() - 3 }}</span>
                                @endif
                            </div>
                        @endif

                        <!-- Кнопки действий -->
                        <div class="flex justify-between items-center">
                            <a href="{{ route('profile.show', $user->id) }}" 
                               class="btn btn-gray text-sm px-3 py-1">
                                👀 Профиль
                            </a>
                            
                            @if(!Auth::user()->hasLiked($user->id) && !Auth::user()->hasDisliked($user->id))
                                <div class="flex space-x-2">
                                    <form action="{{ route('feed.dislike', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-sm">
                                            ❌
                                        </button>
                                    </form>
                                    <form action="{{ route('feed.like', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-8 h-8 bg-rose-500 hover:bg-rose-600 rounded-full flex items-center justify-center text-sm text-white">
                                            ❤️
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-gray-500 px-2 py-1 bg-gray-100 rounded-full">
                                    {{ Auth::user()->hasLiked($user->id) ? '❤️ Лайкнуто' : '❌ Дизлайкнуто' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Кнопка возврата -->
        <div class="text-center mt-8">
            <a href="{{ route('search.index') }}" class="btn btn-rose">
                🔍 Новый поиск
            </a>
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
</style>
@endsection