### Требования

PHP >= v5.5, MySQL, cron

### Установка

* Клонировать репозитарий.
* ```composer install```
* Указать параметры подключения к БД в файле ```config/db.php```.
* Выполнить миграции ```yii migrate```.
* Инициализировать RBAC ```yii rbac/init```.
* Создать администратора ```yii user/create-admin <password>``` (логин admin).
* Создать модератора ```yii user/create-moderator <password>``` (логин moderator).
* При необходимости заполнить фейковыми данными ```yii faker/generate```.
* Добавить задачу в крон для обработки очереди уведомлений ```yii notification/send```.

### Добавление отслеживания событий уведомления для модели

Прописать в конфигурации у компонента eventManager модели и их события. Пример:

```php
[
    'components' => [
        'eventManager' => [
            'class' => EventManager::class,
            'models' => [
                Post::class => [
                    Events::POST_PUBLISHED,
                ],
            ],
        ],
    ],
];
```

Далее в необходимый момент вызывать события для модели:
```php
    $model->trigger(Events::POST_PUBLISHED);
```

Чтобы свойства модели стали доступны в шаблоне уведомления, их необходимо добавить в метод ```Model::attributeLabel```. Свойство должно быть публичным или быть геттер для него.

### Добавление нового типа уведомлений

Создать класс реализующего интерфейс ```app\notifications\NotificationServiceInterface```. Добавить в конфигурацию для компонента ```notificationManager```.

```php
[
    'components' => [
        'notificationManager' => [
            'class' => NotificationManager::class,
            'services' => [
                [
                    'class' => EmailNotificationService::class,
                    'from' => 'notification@news.local',
                ],
                BrowserNotificationService::class,
            ],
        ],
    ],
];

```

### Прочее

Были использованы сторонние модули:

* ```myclabs/php-enum``` - для реализации перечислений.
* ```vova07/yii2-imperavi-widget``` - WYSIWYG редактор.

Отрефакторить, написать тесты, исправить баги.