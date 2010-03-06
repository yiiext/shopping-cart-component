Shopping Cart
=============
Компонент для реализации корзины моделей.

Установка и настройка
---------------------

1. В `protected/config/main.php` добавить:
~~~
[php]
'import' => array(
    //…
    'ext.yiiext.components.shoppingCart.*'
),
~~~

Подготавливаем модель
---------------------
Модели, которым необходимо дать возможность добавления в корзину,
должны реализовать интерфейс `IECartPosition`:

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

Так как `EShoppingCart` реализует интерфейс [CMap](http://www.yiiframework.com/doc/api/CMap),
с ним можно работать как с массивом:

~~~
[php]
$cart = new EShoppingCart();

$cart[] = Book::model()->findByPk(1);
$cart[] = Book::model()->findByPk(2);

foreach($cart as $book){
  // …
}
~~~

Описание пока не полное, смотрите API.