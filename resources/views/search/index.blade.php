@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Поиск</h2>
<form action="{{ route('search.results') }}" method="POST" class="bg-white p-4 rounded shadow mb-4">
    @csrf
    <select name="gender" class="w-full mb-3 p-2 border rounded">
    <option value="">Любой пол</option>
    <option value="Мужчина" {{ old('gender') == 'Мужчина' ? 'selected' : '' }}>Мужчина</option>
    <option value="Женщина" {{ old('gender') == 'Женщина' ? 'selected' : '' }}>Женщина</option>
</select>
    <input type="number" name="age_min" placeholder="Возраст от" class="w-full mb-3 p-2 border rounded">
    <input type="number" name="age_max" placeholder="Возраст до" class="w-full mb-3 p-2 border rounded">
    <input type="text" name="city" placeholder="Город" class="w-full mb-3 p-2 border rounded">
    <button class="bg-rose-500 text-white px-4 py-2 rounded">Поиск</button>
</form>


@if(isset($users))
    @foreach($users as $u)
        <div class="bg-white p-4 mb-3 rounded shadow">
            <h3 class="font-bold">{{ $u->name }}</h3>
            <p>{{ $u->age }} лет, {{ $u->city }}</p>
        </div>
    @endforeach
@endif
@endsection
