<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostsTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            __('Post body'),
            __('Publication date'),
            '',
            __('Below the fields, you must place the information of the posts you want to create, with the same date format.'),

        ];
    }

    public function array(): array
    {
        return [
            ['Ejemplo', now()->format('Y-m-d H:i:s')],
        ];
    }
}
