<?php


use function Brunty\Kahlan\Mink\browser;
use function Brunty\Kahlan\Mink\page;

describe('Test spec', function () {
    it('browses the web', function () {
        browser()->visit('http://google.com');
        expect(page()->getText())->toContain('google');
    });
});
