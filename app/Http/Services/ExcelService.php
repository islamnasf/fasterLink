<?php

namespace App\Http\Services;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class ExcelService
{
    public function exportXLSX($filename,$data,$headerRow=null)
    {
        // Create a writer
        $writer = WriterEntityFactory::createXLSXWriter();

        // Set headers
        $writer->openToBrowser("$filename.xlsx");

        // Write header row
        if ($headerRow) {
            $header = WriterEntityFactory::createRowFromArray($headerRow);
            $writer->addRow($header);
        }

        // Write data rows
        foreach (array_slice($data, 0) as $item) {
            $row = WriterEntityFactory::createRowFromArray($item);
            $writer->addRow($row);
        }

        // Close the writer
        $writer->close();
    }
}
