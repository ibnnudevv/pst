<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scoreboard Operator') }}
        </h2>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Scoreboard Operator" :breadcrumbs="[['label' => 'Home', 'url' => '#'], ['label' => 'Scoreboard Operator', 'url' => '#']]" />

                    <div class="flex items-center space-x-2">
                        <x-secondary-button href="{{ route('games.index') }}" class="ms-3">
                            {{ __('Score Board') }}
                        </x-secondary-button>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg overflow-y-auto relative mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($games as $game)
                            <div class="border rounded-lg p-4">
                                <div class="mb-4">
                                    <h3 class="text-xl font-semibold">{{ $game->sport_type }}</h3>
                                    <p>{{ $game->home_team }} vs {{ $game->away_team }}</p>
                                </div>
                                <form class="score-update-form" data-game-id="{{ $game->id }}">
                                    @csrf
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                {{ $game->home_team }} Score
                                            </label>
                                            <input type="number" name="home_score" value="{{ $game->home_score }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                {{ $game->away_team }} Score
                                            </label>
                                            <input type="number" name="away_score" value="{{ $game->away_score }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Note</label>
                                        <input type="text" name="note"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        Update Score
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.score-update-form').forEach(form => {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const gameId = form.dataset.gameId;
                    const formData = new FormData(form);

                    try {
                        console.log('Sending score update for game:', gameId);
                        const response = await fetch(`/games/${gameId}/update-score`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify({
                                home_score: parseInt(formData.get('home_score')),
                                away_score: parseInt(formData.get('away_score')),
                                note: formData.get('note')
                            })
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Failed to update score');
                        }

                        const data = await response.json();
                        console.log('Score update response:', data);

                        // Update the form values
                        form.querySelector('[name="home_score"]').value = data.home_score;
                        form.querySelector('[name="away_score"]').value = data.away_score;
                        form.querySelector('[name="note"]').value = '';
                    } catch (error) {
                        console.error('Error:', error);
                        alert(error.message || 'Failed to update score');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
