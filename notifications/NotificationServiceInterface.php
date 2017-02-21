<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use app\models\User;

/**
 * Interface NotificationServiceInterface
 * @package app\notifications
 */
interface NotificationServiceInterface
{

    /**
     * Код типа уведомления
     *
     * Краткий уникальный символьный код
     *
     * @return string
     */
    public function getCode();

    /**
     * Имя типа уведомления
     *
     * Используется для вывода пользователю
     *
     * @return string
     */
    public function getName();

    /**
     * Значение по умолчанию (подписан или нет новый пользователь)
     *
     * @return boolean
     */
    public function getDefaultStatus();

    /**
     * @param User $user
     * @param Message $message
     * @return boolean Если уведомление обработано, то необходимо возвратить true
     */
    public function notify(User $user, Message $message);

}