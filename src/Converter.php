<?php

namespace Amadeushu\XlsxConverter;

class Converter
{
  use Format, Value;

  public $format;
  public $value;

  private $columns;
  private $array;

  private function createColumnsArray($ec, $first_letters = '')
  {
    $columns = array();
    $length = strlen($ec);
    $letters = range('A', 'Z');
    foreach ($letters as $letter)
    {
      $column = $first_letters.$letter;
      $columns[] = $column;
      if ($column == $ec)
      {
        return $columns;
      }
    }
    foreach ($columns as $column)
    {
      if (!in_array($ec, $columns) && strlen($column) < $length)
      {
        $new_columns = $this->createColumnsArray($ec, $column);
        $columns = array_merge($columns, $new_columns);
      }
    }
    return $columns;
  }

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