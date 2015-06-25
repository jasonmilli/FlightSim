<?php
class View {
    public static function draw($roll, $time) {
        $footer = "Flight time: {$time}s ";
        $width = 41;
        $height = 21;
        $screen = '';
        for ($i = 0; $i < 10; $i++) $screen .= "\n";
        for ($y = 0; $y <= $height + 1; $y++) {
            for ($x = 0; $x <= $width + 1; $x++) {
                if ($x == ceil($width / 2) && $y == ceil($height / 2)) $screen .= '+';
                elseif ($x == 0 && $y == 0 || $x == $width + 1 && $y == $height + 1) $screen .= '\\';
                elseif ($x == 0 && $y == $height + 1 || $x == $width + 1 && $y == 0) $screen .= '/';
                elseif ($x == 0 || $x == $width + 1) $screen .= '-';
                elseif ($y == 0 || $y == $height + 1) $screen .= '|';
                elseif ($y == $height && $x <= strlen($footer)) {
                    if ($x == 1) $screen .= $footer;
                } else $screen .= self::horizon($roll, $x, $y);
            }
            $screen .= "\n";
        }
        return $screen;
    }
    private static function horizon($roll, $x, $y) {
        $height = 21;
        $width = 41;
        if ($roll > 0.25 && $roll < 0.75 || $roll < -0.25 && $roll > -0.75) {
            $roll -+ 0.5;
            $comp = (ceil($width / 2) - $x) - ceil((floor($height / 2) - $y) * 4 * $roll);
        }
        else $comp =  (ceil($height / 2) - $y) - ceil((floor($width / 2) - $x) * 4 * $roll);
        if ($comp == 0) return '-';
        if ($comp < 0) return '@';
        return ' ';
    }
}
