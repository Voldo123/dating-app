@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Лента</h2>
@foreach($users as $u)
<div class="bg-white p-4 mb-3 rounded shadow">
    <div class="flex items-start mb-2">
        <!-- Фото пользователя -->
        <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden mr-3">
            @if($u->photo)
                <img src="{{ asset('storage/' . $u->photo) }}" alt="Фото {{ $u->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">👤</div>
            @endif
        </div>
        <div>
            <h3 class="text-lg font-bold">{{ $u->name }}</h3>
            <p>{{ $u->age }} лет, {{ $u->city }}</p>
            <p>{{ $u->about }}</p>
        </div>
    </div>

    <div class="flex space-x-2">
        <form action="{{ route('feed.like', $u->id) }}" method="POST" class="inline">
            @csrf
            <button class="bg-green-500 text-white px-3 py-1 rounded">👍</button>
        </form>
        <form action="{{ route('feed.dislike', $u->id) }}" method="POST" class="inline">
            @csrf
            <button class="bg-red-500 text-white px-3 py-1 rounded">👎</button>
        </form>
    </div>
</div>
@endforeach
@endsection