<?php

namespace Amadeushu\XlsxConverter;

trait Value
{
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
        // Ha szám a cella értéke
        if (is_numeric($cell))
        {
          // Számértéket veszünk
          $cell = intval($cell);
          // Majd mint szám a tömbbe illesztjük
          $this->value[$row_idx][$col_idx] = (integer)$cell;
        }
        else
        {
          // Ha bármi más, a tömbbe tesszük
          $this->value[$row_idx][$col_idx] = $cell;
        }
        // Egyet hozzáadunk az oszlopindexhez
        $col_idx++;
      }
    }
  }
}