<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\LazyCollection;

HeadingRowFormatter::default('none');

class JobImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */

    public $job_data;

    public function collection(Collection $collection)
    {
        $this->job_data = $collection->map(function ($row) {
            return (object) $row->toArray(); // Ensure rows are converted to objects
        })->all(); // Convert the collection to an array of objects
    }
}
