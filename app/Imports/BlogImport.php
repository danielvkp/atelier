<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;

class BlogImport implements ToArray
{
   public function array(array $array){
        return $array;        
          // Example: Accessing the first row and first cell
          // $firstRowData = $array[0];
          // $firstCellData = $array[0][0];

          // If you want to access data by heading row, implement WithHeadingRow
        // and then you can access columns like $row['column_name']
    }
}
