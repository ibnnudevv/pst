<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('scores', function () {
    return true;
});

Broadcast::channel('.score.updated', function ($game) {
    return $game;
});
