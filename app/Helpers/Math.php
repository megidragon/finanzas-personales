<?php

namespace App\Helpers;

trait Math {

    /**
     * Extrapolación lineal
     * 
     * @param float $y1 Valor Y de inicio
     * @param float $x2 Valor X final
     * @param float $y2 Valor Y final
     * 
     * @param float $y3 Valor Y para buscar su X
     * 
     * @return float Valor Y3
     */
    public function linearExtrapolation($y1, $x2, $y2, $x3) : float
    {
        $n = $y1;
        
        $m = ($y2 - $y1) / $x2;

        $y3 = $m * $x3 + $n;

        return $y3;
    }
}