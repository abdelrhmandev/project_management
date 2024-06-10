<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ResearchersImport implements ToModel, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {

        if (isset($row[0])) {
            echo $row[0];
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
