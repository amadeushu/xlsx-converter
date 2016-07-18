<?php
/**
 * Extranet: Xlsx Converter
 *
 * @package    Amadeushu\XlsxConverter
 * @subpackage Amadeushu\XlsxConverter\Format
 * @author     Tamas Verten <tverten@hu.amadeus.com>
 * @copyright  2016 Amadeus Hungary
 */

namespace Amadeushu\XlsxConverter;

use PHPExcel_Style_NumberFormat;

/**
 * Format trait
 *
 * Az excel generáló típusmeghatározó függvényének feltöltése,
 * a cellák típusainak meghatározása.
 * 
 * @package    Amadeushu\XlsxConverter
 * @subpackage Amadeushu\XlsxConverter\Format
 * @author     Tamas Verten <tverten@hu.amadeus.com>
 */
trait Format
{
  /**
   * Az értékek típusának megállapítása és a formátumok tömbjének feltöltése
   */
  private function detect()
  {
    // Iterálunk a sorokon
    foreach ($this->value as $row_idx => $row)
    {
      // Iterálunk az oszlopokon
      foreach ($row as $cell_idx => $cell_value)
      {
        // Összerakjuk az excel cellaindexét
        $cell_key = $this->columns[$cell_idx].($row_idx + 1);

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
          $this->format[$cell_key] = PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1;
        }
        else if (is_integer($cell_value)) // Ha szám
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
}