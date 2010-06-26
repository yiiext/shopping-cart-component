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


    public function init() {

    }

    /**
     * Returns total price for all units of the position
     * @return float
     *
     */
    public function getSummPrice() {
        return $this->owner->getPrice() * $this->quantity;
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
    public function setQuantity( $newVal ) {
        $this->quantity = $newVal;
    }

    /**
     * Magic method, call on restore from session
     * Refresh data to model
     */
    public function __wakeup() {
        if($this->refresh === true)
            $this->owner->refresh();
    }

    /**
     *
     * @param boolean $refresh
     */
    public function setRefresh($refresh) {
        $this->refresh = $refresh;
    }

}
