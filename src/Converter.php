<?php

namespace Amadeushu\XlsxConverter;

class Converter
{
  use Format, Value;

  public $format;
  public $value;

  private $array;

  public function __construct($array)
  {
    // 
    $this->array = $array;

    // Az excel kulccsal ellátott tömb létrehozása
    $this->build();

    // A formátumok felismerése és beállítása
    $this->detect();
  }
}