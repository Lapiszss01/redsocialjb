<?php

use App\Exports\PostsTemplateExport;

it('exports correct headings and example row', function () {
    $export = new PostsTemplateExport();
    $headings = $export->headings();
    $data = $export->array();

    expect($headings)->toBe([
        __('Post body'),
        __('Publication date'),
        '',
        __('Below the fields, you must place the information of the posts you want to create, with the same date format.'),
    ])
        ->and($data)->toBeArray()
        ->and($data)->toHaveCount(1)
        ->and($data[0][0])->not->toBeEmpty()
        ->and($data[0][1])->not->toBeEmpty();

});
