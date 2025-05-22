<?php

namespace App\Imports;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreOrUpdatePostRequest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PostsImport implements ToModel, WithStartRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        if (empty(array_filter($row))) {
            return null;
        }

        if (empty($row[0]) && empty($row[1])) {
            return null;
        }

        $dateValue = $row[1] ?? null;

        $publishedAt = null;

        if ($dateValue) {
            if (is_numeric($dateValue)) {
                $publishedAt = Carbon::instance(Date::excelToDateTimeObject($dateValue));
            } else {
                try {
                    $publishedAt = Carbon::createFromFormat('d/m/Y H:i:s', trim($dateValue));
                } catch (\Exception $e) {
                    try {
                        $publishedAt = Carbon::createFromFormat('d/m/Y H:i', trim($dateValue));
                    } catch (\Exception $e) {
                        try {
                            $publishedAt = Carbon::parse(trim($dateValue));
                        } catch (\Exception $e) {
                            $publishedAt = null;
                        }
                    }
                }
            }
        }

        //dd($dateValue);

        return new Post([
            'body'        => $row[0],
            'published_at' => $publishedAt,
            'user_id'      => auth()->id(),
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|min:1',
            '1' => 'required|min:1',
            '2' => 'nullable|date',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => __('The body is required.'),
            '1.required' => __('The publication date is required.'),
            '2.date'     => __('The publication date must have a valid format.'),
        ];
    }
}
