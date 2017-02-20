<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\Notification\Message;

use MyCLabs\Enum\Enum;

/**
 * Class UserStatus
 * @package app\models\Notification\Message
 *
 * @method static MessageStatus AWAIT()
 * @method static MessageStatus SENT()
 */
class MessageStatus extends Enum
{

    const AWAIT = 0;
    const SENT = 1;

}