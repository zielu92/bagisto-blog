<?php


use function Pest\Laravel\deleteJson;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('should returns the blogs page', function () {
    // Act and Assert
    $this->loginAsAdmin();

    get(route('admin.blog.index'))
        ->assertOk()
        ->assertSeeText(trans('blog::blog.blog'))
        ->assertSeeText(trans('admin.blog.create'));
});
