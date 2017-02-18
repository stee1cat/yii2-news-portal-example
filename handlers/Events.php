<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

/**
 * Список всех событий
 *
 * Class Events
 * @package app\handlers
 */
final class Events
{

    const USER_SIGNUP = 'user.signup';
    const USER_CREATED_BY_ADMIN = 'user.createdByAdmin';
    const USER_UPDATED_BY_ADMIN = 'user.updatedByAdmin';
    const USER_PASSWORD_CHANGED = 'user.passwordChanged';

    const POST_PUBLISHED = 'post.published';

}