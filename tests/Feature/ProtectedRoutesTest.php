<?php

it('redirects guest users from protected routes', function (string $routeName, array $params = []) {
    $response = $this->get(route($routeName, $params));

    $response->assertRedirect(route('login'));
})->with([
    ['user.profile'],
    ['core.contact'],
    ['core.recommend'],
    ['activity.create'],
    ['tip.create'],
    ['magazine.create'],
    ['admin.settings'],
]);
