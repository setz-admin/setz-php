<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('home page loads successfully', function () {
    get('/')->assertOk();
});

test('all public pages are accessible from home page', function () {
    $homePage = get('/');

    // Check that all routes exist on the home page
    $homePage->assertSee(route('about'));
    $homePage->assertSee(route('contact'));
    $homePage->assertSee(route('impressum'));
    $homePage->assertSee(route('datenschutz'));

    // Verify each page is accessible
    get(route('about'))->assertOk();
    get(route('contact'))->assertOk();
    get(route('impressum'))->assertOk();
    get(route('datenschutz'))->assertOk();
});

test('navigation links are present in sidebar', function () {
    $response = get('/');

    $response->assertSee('EDV Integration');
    $response->assertSee('Dr. Setz');
    $response->assertSee('Home');
    $response->assertSee('Über Uns');
    $response->assertSee('Kontakt');
});

test('footer contains legal links', function () {
    $response = get('/');

    $response->assertSee('Impressum');
    $response->assertSee('Datenschutz');
});

test('tan paper background is applied to all public pages', function () {
    $pages = [
        '/',
        route('about'),
        route('contact'),
        route('impressum'),
        route('datenschutz'),
    ];

    foreach ($pages as $page) {
        $response = get($page);

        $response->assertOk();
        // Check that tan_paper.gif background is referenced
        $response->assertSee('tan_paper.gif', false);
    }
});

test('logos are displayed on all public pages', function () {
    $pages = [
        '/',
        route('about'),
        route('contact'),
        route('impressum'),
        route('datenschutz'),
    ];

    foreach ($pages as $page) {
        $response = get($page);

        $response->assertOk();
        // Check both logos are present
        $response->assertSee('logo_transl.gif', false);
        $response->assertSee('logo_transr.gif', false);
    }
});
