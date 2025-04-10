<?php

class FilingSerial
{
    public static $map_to_zh = [
        1 => '首次',
        2 => '第一次賸餘',
        3 => '第二次賸餘',
        4 => '第三次賸餘',
        5 => '第四次賸餘',
        6 => '第五次賸餘',
    ];

    public static function toZh($serial_int)
    {
        return self::$map_to_zh[$serial_int];
    }
}
