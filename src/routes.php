<?php

Route::get('xlsx-test', function()
{

  Excel::create('New file', function($excel)
  {
    $excel->sheet('New sheet', function($sheet)
    {
      $sheet->setColumnFormat([
          'L1' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00,
        ]);
      $sheet->loadView('xlsx-converter::test');
    });
  })->export('xlsx');

});