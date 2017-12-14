<?php
/**
 * @author Radosław Wojtyczka <radoslaw.wojtyczka@gmail.com>
 */

namespace Radowoj\Invoicer\Invoice\Traits;

trait StringFloat
{
    /**
     * @param float $float
     * @return string
     */
    protected function floatToString(float $float) : string
    {
        return sprintf("%0.2f", round($float, 2));
    }


    /**
     * @param string $string
     * @return float
     */
    protected function stringToFloat(string $string) : float
    {
        if (!preg_match('/\d+(\.\d{2})?/', $string)) {
            throw new InvalidArgumentException('Input string must be numeric (integer or decimal with two decimal digits)');
        }

        return (float)$string;
    }
}