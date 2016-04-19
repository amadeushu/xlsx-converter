<?php

namespace Amadeushu\XlsxConverter;

trait Value
{
  private function build()
  {
    $columns = range('A', 'Z');

    foreach ($this->array as $row_idx => $row)
    {
      $col_idx = 0;
      foreach ($row as $cell_key => $cell)
      {
        $this->value[$columns[$col_idx].($row_idx+1)] = $cell;
        $col_idx++;
      }
    }
  }
}