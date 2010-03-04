<?php
/**
 * Корзина товаров
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.5 rc2
 * @package ShoppingCart
 */


class CShoppingCart extends CMap
{

    /**
     * Обновлять модели при востановлении из сессии?
     * @var boolean
     */
    public $refresh = true;

    /**
     * При иницализации копируем из сессии корзину
     */
    public function init()
    {

        $this->restoreFromSession();
    }

    /**
     * Востанавливает объект из сессии
     */
    public function restoreFromSession()
    {
        $data = Yii::app()->user->getState(__CLASS__);
        if(is_array($data) || $data instanceof Traversable)
            foreach($data as $key=>$product)
                parent::add($key, $product);
        
    }

    /**
     * Добавляет в коллекцию объект товара
     * Если товар был добавлен ранее в корзину, то
     * инофрмация о нем обновляется ,а кол-во увеличивается на $quantity
     * @param ICartPosition $product
     * @param int кол-во элементов позиции
     */
    public function put(ICartPosition $product, $quantity = 1)
    {
        $key = $product->getId();
        if($this->itemAt($key) instanceof ICartPosition)
        {
            $product = $this->itemAt($key);
            $oldQuantity = $product->getQuantity();
            $quantity += $oldQuantity;
        }

        $this->update($product, $quantity);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        $this->put($value, 1);
    }

    /**
     * Удаляет из коллекции элемент по ключу
     * @param mixed $key
     */
    public function remove($key)
    {
        parent::remove($key);
        $this->saveState();
    }

    /**
     * Обновляет позицию товара в корзине
     * Если продукт был ранее добавлен, то в корзине он обновится,
     * если продукта ранее не было в корзине, он будет туда добавлен.
     * Если кол-во менее 1, товар будет удален.
     *
     * @param int $key
     * @param int $quantity
     */
    public function update(ICartPosition $product, $quantity)
    {

        $key = $product->getId();

        $product->attachBehavior("CartPosition", new CartPositionBehaviour());
        $product->setRefresh($this->refresh);

        $product->setQuantity($quantity);

        if($product->getQuantity() < 1)
            $this->remove($key);
        else
            parent::add($key, $product);

        $this->saveState();
    }

    /**
     * Сохраняет состояние объекта
     */
    protected function saveState()
    {
        Yii::app()->user->setState(__CLASS__, $this->toArray());
    }

    /**
     * Возращает кол-во товаров в корзине
     * @return int
     */
    public function getItemsCount()
    {
        $count = 0;
        foreach($this as $product)
        {
            $count += $product->getQuantity();
        }

        return $count;
    }


    /**
     * Возращает суммарную стоимость всех позиций в корзине
     * @return float
     */
    public function getCost()
    {
        $price = 0.0;
        foreach($this as $product)
        {
            $price += $product->getSummPrice();
        }

        return $price;
    }


}
