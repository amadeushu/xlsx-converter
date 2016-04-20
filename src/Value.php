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
          // A cella értékének karakterkódolása...
          $inconv = mb_detect_encoding($cell);

          // ...amely ha nem UTF-8...
          if ($inconv != 'UTF-8')
          {
            // ...akkor UTF-8-ra kódoljuk
            $cell = iconv($inconv, 'UTF-8', $cell);
          }

          // Ha bármi más, a tömbbe tesszük
          $this->value[$row_idx][$col_idx] = $cell;
        }

        // Egyet hozzáadunk az oszlopindexhez
        $col_idx++;
      }
    }
  }
}