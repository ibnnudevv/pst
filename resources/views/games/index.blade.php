<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scoreboard') }}
        </h2>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Scoreboard" :breadcrumbs="[['label' => 'Home', 'url' => '#'], ['label' => 'Scoreboard', 'url' => '#']]" />

                    <div class="flex items-center space-x-2">
                        <x-secondary-button href="{{ route('games.operator') }}" class="ms-3">
                            {{ __('Operator') }}
                        </x-secondary-button>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg overflow-y-auto relative mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($games as $game)
                            <div class="border rounded-lg p-4 relative game-card" data-game-id="{{ $game->id }}">
                                <div class="absolute top-2 right-2 text-sm text-gray-500">
                                    {{ $game->sport_type }}
                                </div>
                                <div class="flex justify-between items-center mb-4 mt-4">
                                    <div class="text-lg font-semibold">{{ $game->home_team }}</div>
                                    <div class="text-3xl font-bold home-score">{{ $game->home_score }}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-lg font-semibold">{{ $game->away_team }}</div>
                                    <div class="text-3xl font-bold away-score">{{ $game->away_score }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Setting up Echo listener...');

                if (window.Echo) {
                    console.log('Echo is available, connecting to channel...');

                    window.Echo.connector.pusher.connection.bind('connected', () => {
                        console.log('Successfully connected to Reverb!');
                    });

                    window.Echo.channel('scores')
                        .listen('.score.updated', (data) => {
                            console.log('Received score update:', data);
                            const game = data.game;
                            const gameCard = document.querySelector(`[data-game-id="${game.id}"]`);

                            if (gameCard) {
                                console.log('Updating game card:', game.id);
                                const homeScore = gameCard.querySelector('.home-score');
                                const awayScore = gameCard.querySelector('.away-score');

                                if (homeScore && awayScore) {
                                    homeScore.textContent = game.home_score;
                                    awayScore.textContent = game.away_score;
                                    console.log('Scores updated successfully');
                                } else {
                                    console.error('Score elements not found in game card');
                                }
                            } else {
                                console.error('Game card not found for id:', game.id);
                            }
                        });

                    // Debug: Log all incoming events
                    window.Echo.connector.pusher.connection.bind('message', (data) => {
                        console.log('Received message:', data);
                    });
                } else {
                    console.error('Echo is not available!');
                }
            });
        </script>
    @endpush
</x-app-layout>
