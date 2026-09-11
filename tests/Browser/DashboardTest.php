<?php

declare(strict_types=1);

it('renders the dashboard without JavaScript errors', function (): void {
    visit('/dashboard')
        ->assertSee('Dashboard')
        ->assertNoJavaScriptErrors();
});
