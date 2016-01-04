## Модуль оплат beGateway для VirtueMart 1.1.9

Ссылка на архив с модулем: [begateway.zip]()

### Инструкция по установке

  * Распакуйте архив с файлами модуля в корневой директории Joomla
  * Для файла `administrator/components/com_virtuemart/classes/payment/ps_begateway.cfg.php` добавьте права на запись
  * В панели управления сайтом перейдите в меню _Компоненты_, пункт _VirtueMart_. В меню _Магазин_ выбeрите пункт _Добавить способ оплаты_
  * На вкладке _Добавить способ оплаты_ :
    - Ставим галочку напротив надписи _Опубликовано?_
    - В поле _Название способа оплаты_ укажите название: _Банковская карта_
    - В поле _Код_ укажите: _BGW_
    - В поле _Класс имени платежа_ укажите: `ps_begateway`
    - В поле _Способ оплаты_ выбираем _HTML-форма_
  * Нажмите _Применить_
  * На вкладке _Настройки_ укажите:
    - Домен платежного шлюза
    - Домен страницы оплаты
    - Id магазина
    - Ключ магазина
    - Статус заказа для успешной транзакции
    - Статус заказа для неудачной транзакции
    - Статус заказа, у которого платеж обрабатывается
    - В поле _Дополнительная информация по платежу_ вставьте содержимое файла `administrator/components/com_virtuemart/classes/begateway/begateway.tpl.php`
  * Нажмите _Сохранить_
  * Модуль оплаты настроен

### Примечания

Протестировано и разработано для VirtueMart 1.1.9

Требуется PHP 5.2+

### Тестовые данные

Если вы настроили модуль со значениями из примеров, то вы можете уже
осуществить тестовый платеж в вашем магазине. Используйте следующие
данные тестовой карты:

  * Домен платежного шлюза __demo-gateway.begateway.com__
  * Домен страницы оплаты __checkout.begateway.com__
  * номер карты __4200000000000000__
  * имя на карте __John Doe__
  * месяц срока действия карты __01__, чтобы получить успешный платеж
  * месяц срока действия карты __10__, чтобы получить неуспешный платеж
  * CVC __123__

## VirtueMart 1.1.9 payment module

Link to download the payment module: [begateway.zip]()

### How to install

  * Unpack the module archive in the Joomla root directory
  * Setup write rights for the file `administrator/components/com_virtuemart/classes/payment/ps_begateway.cfg.php`
  * In Joomla's administrator area go to the menu _Components_, пункт _VirtueMart_. В меню _Store_ выбeрите пункт _Add Payment Method_
  * Select the tab _Payment Method Form_ and configure:
    - Check the box _Active?_
    - In the field _Payment Method Name_ setup the method name: _Credit or debit card_
    - In the field _Code_ укажите: _BGW_
    - In the field _Payment class name_ select: `ps_begateway`
    - In the field _Payment method type_ check _HTML-форма_
  * Click _Apply_
  * Select the tab _Configuration_ and configure:
    - Payment gateway domain
    - Payment page domain
    - Shop Id
    - Shop key
    - Order Status for successful transactions
    - Order Status for failed transactions
    - Order Status for Pending Payments
    - Add to the field _Payment Extra Info_ contents of the file `administrator/components/com_virtuemart/classes/begateway/begateway.tpl.php`
  * Click _Save_
  * The module is configured


### Notes

Tested and developed with VirtueMart 1.1.9

PHP 5.2+ is required

### Test data

If you setup the module with default values, you can use the test data
to make a test payment:

  * payment gateway domain __demo-gateway.begateway.com__
  * payment page domain __checkout.begateway.com__
  * card number __4200000000000000__
  * card name __John Doe__
  * card expiry month __01__ to get a success payment
  * card expiry month __10__ to get a failed payment
  * CVC __123__  
