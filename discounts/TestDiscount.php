<?php
/**
 * тестовая скидка, применяется если добавленно больше 1 позиции товара:
 * добавляешь в корзину две единицы товара и получаешь скидку на первую позицию в $rate %
 */
class TestDiscount extends IEDiscount {
    /**
     * Скидка в %
     */
    public $rate = 30;

    public function apply() {
        foreach ($this->shoppingCart as $position) {
            $quantity = $position->getQuantity();
            if ($quantity > 1) {
                $productPrice = $position->getPrice();
                $discountPrice = $this->rate * $position->getPrice() / 100;
                $position->addDiscountPrice($discountPrice);
            }
        }
    }
}
