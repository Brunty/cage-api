<?php

use function App\Spec\browser;
use function App\Spec\page;

describe('Test spec', function () {
    it('browses the web', function () {
        browser()->visit('http://google.com');
        expect(page()->getText())->toContain('google');
    });
});
