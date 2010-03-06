<?php

/**
 * IECartPosition
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.6
 * @package ShoppingCart
 */
interface IECartPosition {
    /**
     * @return mixed уникальный индификатор
     */
    public function getId();
    /**
     * @return float цена
     */
    public function getPrice();
}
