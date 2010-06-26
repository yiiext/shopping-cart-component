<?php
/**
 * Discount abstract class
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.7
 * @package ShoppingCart
 *
 */
abstract class IEDiscount {

    protected $shoppingCart;

    public function setShoppingCart(EShoppingCart $shoppingCart) {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * Применить скидку к позиции.
     * в реализации нужно установить сумму скидки на позицию
     * @abstract
     * @return void
     */
    abstract public function apply();

}
