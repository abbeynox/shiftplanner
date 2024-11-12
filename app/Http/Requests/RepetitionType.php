<?php

namespace App\Http\Requests;

abstract class RepetitionType {
    const None = 'none';
    const Hourly = 'hourly';
    const Daily = 'daily';
    const Weekly = 'weekly';

    static function cases() {
        return [self::None, self::Hourly, self::Daily, self::Weekly];
    }

    static function timeDiff($type, $start) {
        switch($type) {
            case self::Hourly:
                return date('Y-m-d H:i', strtotime('+1 hour', strtotime($start)));
            case self::Daily:
                return date('Y-m-d H:i', strtotime('+1 day', strtotime($start)));
            case self::Weekly:
                return date('Y-m-d H:i', strtotime('+1 week', strtotime($start)));
        }
    }
};
