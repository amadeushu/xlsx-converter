<?php

namespace Amadeushu\XlsxConverter;

use PHPExcel_Style_NumberFormat;

trait Format
{
  private function detect()
  {
    foreach ($this->value as $cell_key => $cell_value)
    {
      if (preg_match('`\d{4}-\d{2}-\d{2}`', $cell_value)) // Ha dátum yyyy-mm-dd formátumban
      {
        $this->format[$cell_key] = PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2;
      }
      else if (preg_match('`^.*?%$`', $cell_value)) // Ha százalékjel van a szöveg végén
      {
        $this->format[$cell_key] = PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE;
      }
      else if (is_float($cell_value)) // Ha tört szám
      {
        $this->format[$cell_key] = PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00;
      }
      else if (is_numeric($cell_value)) // Ha szám
      {
        $this->format[$cell_key] = PHPExcel_Style_NumberFormat::FORMAT_NUMBER;
      }
      else // Minden egyéb esetben...
      {
        $this->format[$cell_key] = PHPExcel_Style_NumberFormat::FORMAT_GENERAL;
      }
    }
  }
}