<?php

/**
 * position in the cart
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.7
 * @package ShoppingCart
 *
 * Can be used with not AR models.
 */
class ECartPositionBehaviour extends CActiveRecordBehavior {

    /**
     * number of positions
     * @var int
     */
    private $quantity = 0;
    /**
     * Update model on session restore?
     * @var boolean
     */
    private $refresh = true;

    /**
     * Сумма скидки на позицию
     * @var float
     */
    private $discountPrice = 0.0;


    public function init() {

    }

    /**
     * Returns total price for all units of the position
     * @param bool $withDiscount
     * @return float
     *
     */
    public function getSumPrice($withDiscount = true) {
        $fullSum = $this->owner->getPrice() * $this->quantity;
        if($withDiscount)
            $fullSum -=  $this->discountPrice;
        return $fullSum;
    }

    /**
     * Returns quantity.
     * @return int
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Updates quantity.
     *
     * @param int quantity
     */
    public function setQuantity($newVal) {
        $this->quantity = $newVal;
    }

    /**
     * Magic method, call on restore from session
     * Refresh data to model
     */
    public function __wakeup() {
        if ($this->refresh === true)
            $this->owner->refresh();
    }

    /**
     *
     * @param boolean $refresh
     */
    public function setRefresh($refresh) {
        $this->refresh = $refresh;
    }

    /**
     * Установить сумму скидки на позицию
     * @param  $price
     * @return void
     */
    public function addDiscountPrice($price) {
        $this->discountPrice += $price;
    }

}
