<?php
/**
 * Extranet: Xlsx Converter
 *
 * @package    Amadeushu\XlsxConverter
 * @subpackage Amadeushu\XlsxConverter\Value
 * @author     Tamas Verten <tverten@hu.amadeus.com>
 * @copyright  2016 Amadeus Hungary
 */

namespace Amadeushu\XlsxConverter;

/**
 * Value trait
 *
 * Az értékek típuskonverziójának végrehajtása
 * 
 * @package    Amadeushu\XlsxConverter
 * @subpackage Amadeushu\XlsxConverter\Value
 * @author     Tamas Verten <tverten@hu.amadeus.com>
 */
trait Value
{
  /**
   * Az értékek típusának meghatározása és a szövegek UTF-8 kódolása (amennyiben szükséges)
   */
  private function build()
  {
    // Iterálunk a sorokon
    foreach ($this->array as $row_idx => $row)
    {
      // Az első oszlop indexe 0
      $col_idx = 0;

      // Iterálunk az oszlopokon
      foreach ($row as $cell_key => $cell)
      {
        if (preg_match('`^.*?%$`', $cell))
        {
          $cell = intval(str_replace('%', '', $cell));
          $cell /= 100;
        }
        else if (is_numeric($cell)) // Ha szám a cella értéke
        {
          //$cell = (string)floatval($cell).' - '.$cell;
          
          if (floatval($cell) !== $cell)
          {
            $cell = (float)$cell;
          }
          else
          {
            $cell = intval($cell);
          }
        }
        else
        {
          // A cella értékének karakterkódolása...
          $inconv = mb_detect_encoding($cell);

          // ...amely ha nem UTF-8...
          if ($inconv != 'UTF-8')
          {
            // ...akkor UTF-8-ra kódoljuk
            $cell = iconv($inconv, 'UTF-8', $cell);
          }
        }
        
        // A tömbbe tesszük
        $this->value[$row_idx][$col_idx] = $cell;

        // Egyet hozzáadunk az oszlopindexhez
        $col_idx++;
      }
    }
  }
}