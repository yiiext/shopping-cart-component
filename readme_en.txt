Shopping Cart
=============
Provides shpping cart functionality for models.

Installing and configuring
--------------------------

1. Add to `protected/config/main.php`:
~~~
[php]
'import' => array(
    //…
    'ext.yiiext.components.shoppingCart.*'
),
~~~

Preparing model
---------------
Models that can be put into shopping cart should implement `IECartPosition`
interface:

~~~
[php]
class Book extends CActiveRecord implements IECartPosition {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function getId(){
        return 'Book'.$this->id;
    }

    function getPrice(){
        return $this->price;
    }
}
~~~

`EShoppingCart` implements [CMap](http://www.yiiframework.com/doc/api/CMap),
so we can work with it as map:

~~~
[php]
$cart = new EShoppingCart();

$cart[] = Book::model()->findByPk(1);
$cart[] = Book::model()->findByPk(2);

foreach($cart as $book){
  // …
}
~~~

This document is not complete, see API.