<?php
class View {
    private static $width = 41;
    private static $height = 21;
    private static $roll;
    private static $pitch;
    public static function draw($roll, $pitch, $time) {
        $footer = "Flight time: {$time}s ";
        self::$roll = $roll;
        self::$pitch = $pitch;
        $screen = '';
        for ($i = 0; $i < 10; $i++) $screen .= "\n";
        for ($y = 0; $y <= self::$height + 1; $y++) {
            for ($x = 0; $x <= self::$width + 1; $x++) {
                if ($x == ceil(self::$width / 2) && $y == ceil(self::$height / 2)) $screen .= '+';
                elseif ($x == 0 && $y == 0 || $x == self::$width + 1 && $y == self::$height + 1) $screen .= '\\';
                elseif ($x == 0 && $y == self::$height + 1 || $x == self::$width + 1 && $y == 0) $screen .= '/';
                elseif ($x == 0 || $x == self::$width + 1) $screen .= '-';
                elseif ($y == 0 || $y == self::$height + 1) $screen .= '|';
                elseif ($y == self::$height && $x <= strlen($footer)) {
                    if ($x == 1) $screen .= $footer;
                } else $screen .= self::horizon($x, $y);
            }
            $screen .= "\n";
        }
        return "$screen Roll: {self::$roll}\nPitch: {self::$pitch}\n";
    }
    private static function horizon($x, $y) {
        $roll = self::$roll;
        $pitch = self::$pitch;
        if ($roll > 0.25 && $roll < 0.75) {
            $roll = 0.5 - $roll;
            $comp = -(ceil(self::$width / 2) - $x) + ceil((floor(self::$height / 2) - $y) * 4 * $roll);
        } elseif ($roll >= -0.75 && $roll < -0.25) {
            $roll = 0.5 + $roll;
            $comp = (ceil(self::$width / 2) - $x) + ceil((floor(self::$height / 2) - $y) * 4 * $roll);
        } elseif ($roll < -0.75 || $roll >= 0.75) {
            if ($roll > 0) $roll = 1 - $roll;
            else $roll = -1 - $roll;
            $comp = -(ceil(self::$height / 2) - $y) - ceil((floor(self::$width / 2) - $x) * 4 * $roll);
        } else $comp = (ceil(self::$height / 2) - $y) - ceil((floor(self::$width / 2) - $x) * 4 * $roll);
        if ($pitch < 0.5 && $pitch > -0.5) $elevation = floor($pitch * 4 * floor(self::$height / 2));
        else {
            $comp = -$comp;
            if ($pitch < 0) $pitch = -1 - $pitch;
            else $pitch = 1 - $pitch;
            $elevation = floor($pitch * 4 * floor(self::$height / 2));
        }
        if ($comp == -$elevation) return '-';
        if ($comp < -$elevation) return '@';
        return ' ';
    }
}
