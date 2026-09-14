<?php

use App\Models\User;

it('falls back to a generated avatar for missing files and dead placeholders', function () {
    expect((new User(['name' => 'Anna', 'avatar' => null]))->avatar_url)->toContain('dicebear.com')
        ->and((new User(['name' => 'Anna', 'avatar' => 'https://api.adorable.io/avatars/160']))->avatar_url)->toContain('dicebear.com')
        ->and((new User(['name' => 'Anna', 'avatar' => '/user/avatars/gibt-es-nicht.jpg']))->avatar_url)->toContain('dicebear.com')
        ->and((new User(['name' => 'Anna', 'avatar' => 'https://example.com/me.png']))->avatar_url)->toBe('https://example.com/me.png')
        ->and((new User(['name' => 'Anna', 'avatar' => '/img/logo_fussballgoetter.png']))->avatar_url)->toBe('/img/logo_fussballgoetter.png');
});
