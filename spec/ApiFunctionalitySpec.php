<?php

use function Brunty\Kahlan\Mink\visit;
use function Brunty\Kahlan\Mink\page;
use function Brunty\Kahlan\Mink\url;
use function Brunty\Kahlan\Mink\json;
use function Brunty\Kahlan\Mink\xml;

describe('Cage API functionality', function () {
    context('application/json content type', function () {
        it('returns a single random image', function () {
            visit(url('/random'), ['Accept' => 'application/json']);

            expect(json(page()))->toContainKey('image');
        });

        it('returns multiple random images', function () {
            visit(url('/bomb/4'), ['Accept' => 'application/json']);

            expect(json(page())['images'])->toHaveLength(4);
        });
    });

    context('application/xml content type', function () {
        it('returns a random image', function () {
            visit(url('/random'), ['Accept' => 'application/xml']);

            expect(xml(page()))->toContainKey('image');
        });

        it('returns multiple random images', function () {
            visit(url('/bomb/4'), ['Accept' => 'application/xml']);

            expect(xml(page())['images']['image'])->toHaveLength(4);
        });
    });
});
