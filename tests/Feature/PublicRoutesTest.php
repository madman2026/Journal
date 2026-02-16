<?php

use Illuminate\Support\Facades\Artisan;

it('lists application routes without errors', function () {
    $exitCode = Artisan::call('route:list');

    expect($exitCode)->toBe(0);
});

it('loads home page without seeded sections', function () {
    $this->get(route('home'))->assertOk();
});

it('loads public routes', function (string $routeName, array $params = []) {
    $this->get(route($routeName, $params))->assertOk();
})->with([
    ['activity.index'],
    ['tip.index'],
    ['magazine.index'],
    ['login'],
    ['register'],
    ['forgot-password'],
    ['core.search', ['type' => '0']],
]);
