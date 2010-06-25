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
     *
     * @return float cost  units of the position
     *
     */
    public function getSummPrice() {
        return $this->owner->getPrice() * $this->quantity;
    }

    /**
     *
     * @return int number of units of the position
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * set quantity of position
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
