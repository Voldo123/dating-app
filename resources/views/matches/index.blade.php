@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-rose-600">Ваши мэтчи 💕</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @php
        $matches = Auth::user()->matches()->with(['user1', 'user2'])->get();
    @endphp

    @if($matches->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($matches as $match)
                @php
                    $partner = $match->user1_id === Auth::id() ? $match->user2 : $match->user1;
                @endphp
                
                <div class="bg-white rounded-lg shadow-md p-6 border-2 border-rose-200">
                    <div class="flex items-center space-x-4">
                        <!-- Аватар или фото -->
                        <div class="w-20 h-20 rounded-full overflow-hidden flex items-center justify-center bg-rose-200">
                            @if($partner->photo)
                                <img src="{{ asset('storage/' . $partner->photo) }}" 
                                     alt="{{ $partner->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-rose-600 font-bold text-2xl">
                                    {{ substr($partner->name, 0, 1) }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800">{{ $partner->name }}</h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                @if($partner->age)
                                    <span>{{ $partner->age }} лет</span>
                                @endif
                                @if($partner->gender)
                                    <span>• {{ $partner->gender }}</span>
                                @endif
                                @if($partner->city)
                                    <span>• {{ $partner->city }}</span>
                                @endif
                            </div>
                            
                            @if($partner->about)
                                <p class="text-gray-700 mb-4 line-clamp-2">{{ $partner->about }}</p>
                            @else
                                <p class="text-gray-500 mb-4">Пользователь пока не написал о себе</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('profile.show', $partner->id) }}"
                           class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-lg flex-1 text-center transition duration-200">
                            👀 Посмотреть профиль
                        </a>
                        
                        @if($partner->telegram)
                            <a href="https://t.me/{{ ltrim($partner->telegram, '@') }}" 
                               target="_blank"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center transition duration-200">
                                <span class="mr-2">✈️</span> Telegram
                            </a>
                        @endif
                    </div>

                    <div class="mt-3 text-xs text-gray-500 text-right">
                        Нашли друг друга {{ $match->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="text-6xl mb-4">💔</div>
            <p class="text-gray-600 text-lg mb-2">У вас пока нет мэтчей</p>
            <p class="text-gray-500 mb-6">Ставьте лайки пользователям, и когда они ответят взаимностью - здесь появится мэтч!</p>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('feed.index') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-lg transition duration-200">
                    🔥 Начать оценивать
                </a>
                <a href="{{ route('search.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200">
                    🔍 Поиск людей
                </a>
            </div>
        </div>
    @endif
</div>
@endsection