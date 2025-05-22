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
            'Cuerpo del post',
            'Fecha de publicación',
            '',
            'Deberás colocar debajo de los campos la informacion de los posts que quieras crear, con el mismo formato en la fecha.'
        ];
    }

    public function array(): array
    {
        return [
            ['Ejemplo', now()->format('Y-m-d H:i:s')],
        ];
    }
}
