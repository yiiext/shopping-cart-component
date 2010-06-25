<?php
/**
 * Shopping cart class
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.7
 * @package ShoppingCart
 */


class EShoppingCart extends CMap
{

    /**
     * Update the model on session restore?
     * @var boolean
     */
    public $refresh = true;

    public function init()
    {

        $this->restoreFromSession();
    }

    /**
     * Restores the object from the session
     */
    public function restoreFromSession()
    {
        $data = Yii::app()->getUser()->getState(__CLASS__);
        if(is_array($data) || $data instanceof Traversable)
            foreach($data as $key=>$product)
                parent::add($key, $product);
        
    }

    /**
     * Add items to cart
     * If the position was previously added to the cart,
     * then information of it is updated, and count increases by $quantity
     * @param IECartPosition $position
     * @param int count of elements positions
     */
    public function put(IECartPosition $position, $quantity = 1)
    {
        $key = $position->getId();
        if($this->itemAt($key) instanceof IECartPosition)
        {
            $position = $this->itemAt($key);
            $oldQuantity = $position->getQuantity();
            $quantity += $oldQuantity;
        }

        $this->update($position, $quantity);
        
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
     * Removes element from the collection of key
     * @param mixed $key
     */
    public function remove($key)
    {
        parent::remove($key);
        $this->onRemovePosition(new CEvent($this));
        $this->saveState();
    }


    /**
     * Updates the position in the collection
     * If the position was previously added, then it will be updated in cart,
     * if the position was not previously in the cart, it will be added there.
     * If the count of less than 1, the position will be deleted.
     *
     * @param IECartPosition $position
     * @param int $quantity
     */
    public function update(IECartPosition $position, $quantity)
    {
        if(!($position instanceof CComponent))
            throw new InvalidArgumentException('invalid argument 1, product must implement CComponent interface');

        $key = $position->getId();

        $position->attachBehavior("CartPosition", new ECartPositionBehaviour());
        $position->setRefresh($this->refresh);

        $position->setQuantity($quantity);

        if($position->getQuantity() < 1)
            $this->remove($key);
        else
            parent::add($key, $position);

        $this->onUpdatePoistion(new CEvent($this));
        $this->saveState();
    }

    /**
     * Saves the state of the object in the session.
     * @return void
     */
    protected function saveState()
    {
        Yii::app()->getUser()->setState(__CLASS__, $this->toArray());
    }

    /**
     * Returns count of items in cart
     * @return int
     */
    public function getItemsCount()
    {
        $count = 0;
        foreach($this as $position)
        {
            $count += $position->getQuantity();
        }

        return $count;
    }


    /**
     * Returns cost of cart
     * @return float
     */
    public function getCost()
    {
        $price = 0.0;
        foreach($this as $position)
        {
            $price += $position->getSummPrice();
        }

        return $price;
    }

    public function onRemovePosition($event)
    {
        $this->raiseEvent('onRemovePosition', $event);
    }

    public function onUpdatePoistion($event)
    {
        $this->raiseEvent('onUpdatePoistion', $event);
    }


}
