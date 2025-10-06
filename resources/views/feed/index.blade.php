@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow relative">
    <h2 class="text-2xl font-bold text-center mb-4">💘 Найди совпадение</h2>

    @if($users->isEmpty())
        <p class="text-center text-gray-600">Нет доступных анкет. Попробуйте позже.</p>
    @else
        <div id="user-slider" class="relative">
            @foreach($users as $index => $u)
                <div class="user-card {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}" data-user-id="{{ $u->id }}">
                    <div class="text-center">
                        <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-4 border-4 border-rose-200">
                            @if($u->photo)
                                <img src="{{ asset('storage/' . $u->photo) }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-500 text-5xl">
                                    👤
                                </div>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold">{{ $u->name }}</h3>
                        <p class="text-gray-600">{{ $u->age }} лет, {{ $u->city }}</p>
                        <p class="mt-2">{{ $u->about ?? 'Пока ничего не рассказал(а) о себе' }}</p>

                        @if($u->tags && $u->tags->count() > 0)
                            <div class="mt-3">
                                @foreach($u->tags as $tag)
                                    <span class="inline-block bg-rose-100 text-rose-700 text-sm px-3 py-1 rounded-full m-1">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Кнопки управления слайдером -->
        <div class="flex justify-between items-center mt-6">
            <!-- Кнопка "Назад" -->
            <button id="prevBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 w-12 h-12 rounded-full flex items-center justify-center text-xl">
                ⬅️
            </button>

            <!-- Кнопки лайков/дизлайков для текущего пользователя -->
            <div class="flex gap-4" id="action-buttons">
                <!-- Форма дизлайка -->
                <form action="{{ route('feed.dislike', $users->first()->id) }}" method="POST" class="action-form">
                    @csrf
                    <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-gray-800 w-12 h-12 rounded-full flex items-center justify-center text-xl">
                        ❌
                    </button>
                </form>

                <!-- Форма лайка -->
                <form action="{{ route('feed.like', $users->first()->id) }}" method="POST" class="action-form">
                    @csrf
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white w-12 h-12 rounded-full flex items-center justify-center text-xl">
                        ❤️
                    </button>
                </form>
            </div>

            <!-- Кнопка "Вперед" -->
            <button id="nextBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 w-12 h-12 rounded-full flex items-center justify-center text-xl">
                ➡️
            </button>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.user-card');
    const actionForms = document.querySelectorAll('.action-form');
    let current = 0;

    const updateSlider = () => {
        // Показываем текущую карточку, скрываем остальные
        cards.forEach((card, index) => {
            card.classList.toggle('hidden', index !== current);
        });

        // Обновляем action формы для текущего пользователя
        const currentUserId = cards[current].dataset.userId;
        actionForms.forEach(form => {
            const action = form.action;
            // Обновляем ID в URL формы
            form.action = action.replace(/\/feed\/\d+\/(like|dislike)/, `/feed/${currentUserId}/$1`);
        });
    };

    // Кнопка "Вперед"
    document.getElementById('nextBtn').addEventListener('click', () => {
        if (current < cards.length - 1) {
            current++;
            updateSlider();
        }
    });

    // Кнопка "Назад"
    document.getElementById('prevBtn').addEventListener('click', () => {
        if (current > 0) {
            current--;
            updateSlider();
        }
    });

    // Обработка отправки форм (чтобы не перезагружать страницу сразу)
    actionForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Отправляем форму
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                // Переходим к следующему пользователю после действия
                if (current < cards.length - 1) {
                    current++;
                    updateSlider();
                } else {
                    // Если это последний пользователь, показываем сообщение
                    alert('Анкеты закончились!');
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // В случае ошибки все равно переходим дальше
                if (current < cards.length - 1) {
                    current++;
                    updateSlider();
                }
            });
        });
    });

    // Инициализация слайдера
    updateSlider();
});
</script>
@endsection