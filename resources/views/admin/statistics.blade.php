@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Статистика</h1>

    <!-- Активность -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-gray-800 mb-2">{{ $activityStats['total_likes'] }}</div>
            <p class="text-gray-600">Всего лайков</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-gray-800 mb-2">{{ $activityStats['total_matches'] }}</div>
            <p class="text-gray-600">Всего мэтчей</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-gray-800 mb-2">{{ $activityStats['likes_today'] }}</div>
            <p class="text-gray-600">Лайков сегодня</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-gray-800 mb-2">{{ $activityStats['matches_today'] }}</div>
            <p class="text-gray-600">Мэтчей сегодня</p>
        </div>
    </div>

    <!-- Распределение по полу -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Распределение по полу</h2>
            <div class="space-y-3">
                @foreach($userStats['by_gender'] as $stat)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $stat->gender ?? 'Не указан' }}</span>
                        <span class="text-sm font-medium text-gray-700">{{ $stat->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-rose-600 h-2 rounded-full" 
                             style="width: {{ ($stat->count / $userStats['by_gender']->sum('count')) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Топ городов -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Популярные города</h2>
            <div class="space-y-3">
                @foreach($userStats['by_city'] as $stat)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium">{{ $stat->city }}</span>
                    <span class="bg-rose-100 text-rose-800 px-2 py-1 rounded-full text-sm">{{ $stat->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection