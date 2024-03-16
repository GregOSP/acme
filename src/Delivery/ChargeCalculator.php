<?php

namespace Acme\WidgetCo\Delivery;

class ChargeCalculator {

    /**
     * Calculates the delivery charge based on order total
     * 
     * @param float $total The total cost of the order
     * @param array<array{limit: float, charge: float}> $chargeRules An array of associative arrays with delivery charge rules [[limit: 1.00, charge: 1.00], [limit: 100, charge: 0]]
     * @return float The delivery charge
     */
    public static function calculate(float $total, array $chargeRules): float {
        foreach ($chargeRules as $rule) {
            if ($total >= $rule['limit']) {
                return $rule['charge'];
            }
        }
        // Default to max charge if no rules match (There are some bigger issues here, since we are paying the user to take the widget)
        return max(array_column($chargeRules, 'charge'));
    }
}
