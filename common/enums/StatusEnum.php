<?php



namespace common\enums;

use Yii;


class StatusEnum
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const STATUS_ON_LABEL = 'Active';
    const STATUS_OFF_LABEL = 'Inactive';

    public static $list = [
        self::STATUS_ON => STATUS_ON_LABEL,
        self::STATUS_OFF => STATUS_OFF_LABEL,
    ];
}