<?php

use App\Models\Draw;

it('splits comma separated teams into arrays', function () {
    $draw = new Draw(['teamA' => 'Anna,Ben,', 'teamB' => 'Chris, Dana', 'teamC' => null]);

    expect($draw->teams())->toBe([['Anna', 'Ben'], ['Chris', 'Dana']]);
});
