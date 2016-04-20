<?php
/**
 * Extranet: Xlsx Converter
 *
 * @package    Amadeushu\XlsxConverter
 * @subpackage Amadeushu\XlsxConverter\Converter
 * @author     Tamas Verten <tverten@hu.amadeus.com>
 * @copyright  2016 Amadeus Hungary
 */

namespace Amadeushu\XlsxConverter;

/**
 * Converter osztály
 *
 * Excel fájl generáláshoz, adatkonvertáló és cellatípusmeghatározó osztály.
 * 
 * @package    Amadeushu\XlsxConverter
 * @subpackage Amadeushu\XlsxConverter\Converter
 * @author     Tamas Verten <tverten@hu.amadeus.com>
 */
class Converter
{
  // Használt traitek
  use Format, Value;

  // Formátumok tömbje
  public $format;
  // A meghatározott típusra alakított értékek tömbje
  public $value;

  // Privát; Az excel oszlopnevei
  private $columns;
  // Privát; A feldolgozandó adatok
  private $array;

  /**
   * Excel oszlopnevek tömbjének visszaadása
   *
   * @param   string  $end_column  Az oszlopok utolsó tagja
   * @return  array                Az oszlopneveket tartalmazó tömb
   */
  private function createColumnsArray($end_column)
  {
    $columns = array();
    $length = strlen($end_column);
    $letters = range('A', 'Z');
    foreach ($letters as $letter)
    {
      $column = $letter;
      $columns[] = $column;
      if ($column == $end_column)
      {
        return $columns;
      }
    }
    foreach ($columns as $column)
    {
      if (!in_array($end_column, $columns) && strlen($column) < $length)
      {
        $new_columns = $this->createColumnsArray($end_column, $column);
        $columns = array_merge($columns, $new_columns);
      }
    }
    return $columns;
  }

  /**
   * Konstruktor
   *
   * @param  array  $array  A feldolgozandó adatok tömbje
   */
  public function __construct($array)
  {
    // Felépítjük az excel oszlopnevek tömbjet
    $this->columns = $this->createColumnsArray('BB');

    // Osztályváltozóba tesszük a kapott tömböt
    $this->array = $array;

    // Az excel kulccsal ellátott tömb létrehozása
    $this->build();

    // A formátumok felismerése és beállítása
    $this->detect();
  }
}