<?php

if (!function_exists('formatRupiah')) {
  function formatRupiah($angka)
  {
    return 'Rp' . number_format($angka, 0, ',', '.');
  }
}

if (!function_exists('numberFormat')) {
  function numberFormat($angka)
  {
    return number_format($angka, 0, ',', '.');
  }
}
