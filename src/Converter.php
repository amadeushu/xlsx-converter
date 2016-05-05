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
   * Konstruktor
   *
   * @param  array  $array  A feldolgozandó adatok tömbje
   */
  public function __construct($array)
  {
    // Felépítjük az excel oszlopnevek tömbjet
    $columns = function($column_value)
    {
      // szamlalo
      $count = 26;

      // ideigelenes tombok
      $array = $in_array = $response = array();

      // karakterek szama
      $char_number  = ceil($column_value / $count);

      // elotag karakterek ... ha az oszlopok szama meghaladja az A - Z intervallumot, akkor innet veszi az ertekeket, elotagokat
      $prefix_array = range(chr(65), chr(64 + ($char_number)));

      // letrehozzuk az ideiglenes tombot
      for ($i = 0; $i < $char_number; $i++)
      {
        // karakterek generalasa
        $array[] = range(chr(65), chr(64 + ($column_value > $count ? $count : $column_value)));

        // csokkentjuk a sorok szamat
        $column_value = $column_value - $count;
      }

      // bejarjuk, egyesitjuk a tombot
      foreach ($array as $sub_array)
      {
        foreach ($sub_array as $value)
        {
          $in_array[] = $value;
        }
      }

      // bejarjuk, rendezzuk a tombot
      foreach ($in_array as $value)
      {
        // ha meg nincs benne az adott karakter a tombben, akkor beletesszuk
        if (!in_array($value, $response))
        {
          $response[] = $value;
        }
        // de ha mar benne van, akkor
        else
        {
          // ha a szamlalo 26, akkor csak siman kivesszuk a prefix, elotag tombbol az elso elemet
          if ($count == 26)
          {
            $prefix  = array_shift($prefix_array);
          }
          // ha a szamlalo 0, akkor ujra kezdjuk a szamlalast, es kivesszuk a prefixet
          elseif ($count == 0)
          {
            $count  = 26;
            $prefix = array_shift($prefix_array);
          }

          // hozzaadjuk a tombhoz az oszlop nevet
          $response[] = $prefix.$value;

          // csokkentjuk a szamlalo erteket
          $count--;
        }
      }

      // visszaterunk az oszlopok neveivel
      return $response;
    };

    $this->columns = $columns(count($array[0]));

    // Osztályváltozóba tesszük a kapott tömböt
    $this->array   = $array;

    // Az excel kulccsal ellátott tömb létrehozása
    $this->build();

    // A formátumok felismerése és beállítása
    $this->detect();
  }
}