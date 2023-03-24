<?php

namespace App\Interfaces;

interface StatusesInterface
{
    const STATUS_PUBLISH   = 'publish';
    const STATUS_NOPUBLISH = 'nopublish';
    const STATUS_DELETE    = 'delete';
    const STATUS_BAN       = 'ban';

    const CATEGORY_STATUSES = [
        self::STATUS_PUBLISH   => 'Опубликован',
        self::STATUS_NOPUBLISH => 'Не опубликован',
        self::STATUS_DELETE    => 'Удален',
    ];

    const PRODUCT_STATUSES = [
        self::STATUS_PUBLISH   => 'Опубликован',
        self::STATUS_NOPUBLISH => 'Не опубликован',
        self::STATUS_DELETE    => 'Удален',
        self::STATUS_BAN       => 'Заблокирован',
    ];

    const USER_STATUSES = [
        self::STATUS_PUBLISH   => 'Активирован',
        self::STATUS_NOPUBLISH => 'Не активирован',
        self::STATUS_DELETE    => 'Удален',
        self::STATUS_BAN       => 'Заблокирован',
    ];
}