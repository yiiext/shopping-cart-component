CShoppingCart
=============
Поведение для реализации корзины моделей.

Установка и настройка
---------------------

1. В protected/config/main.php добавить:
~~~
[php]
'import' => array(
    //…
    'ext.CShoppingCart.*'
),
~~~

Подготавливаем модель
---------------------
Модели, которым необходимо дать возможность добавления в корзину,
должны реализовать интерфейс ICartPosition:

~~~
[php]
class Book extends CActiveRecord implements ICartPosition {
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

Так как CShoppingCart реализует интерфейс CMap, с ним можно работать как с массивом:

~~~
[php]
$cart = new CShoppingCart();

$cart[] = Book::model()->findByPk(1);
$cart[] = Book::model()->findByPk(2);

foreach($cart as $book){
  // …
}
~~~
