<?php

namespace Tests\Feature\Routes;

use App\Models\Preference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

uses(RefreshDatabase::class);

it('has valid relationships', function () {
    $m = new Preference();
    $relation = $m->user();

    $this->assertInstanceOf(BelongsTo::class, $relation);
});
