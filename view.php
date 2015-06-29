<?php
class View {
    private static $width = 41;
    private static $height = 21;
    private static $roll;
    private static $pitch;
    private static $elevation;
    public static function draw($roll, $pitch, $time, $speed, $altitude, $throttle) {
        $header_left = "Altitude: {$altitude}m ";
        $header_right = " Power: {$throttle}w";
        $footer = "Flight time: {$time}s ";
        $footer_right = " Speed: ".floor($speed)."m/s";
        self::$roll = $roll;
        self::$pitch = $pitch;
        self::setElevation();
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
                } elseif ($y == self::$height && $x > self::$width - strlen($footer_right)) {
                    if ($x == self::$width - strlen($footer_right) + 1) $screen .= $footer_right;
                } elseif ($y == 1 && $x <= strlen($header_left)) {
                    if ($x == 1) $screen .= $header_left;
                } elseif ($y == 1 && $x > self::$width - strlen($header_right)) {
                    if ($x == self::$width - strlen($header_right) + 1) $screen .= $header_right;
                } else $screen .= self::horizon($x, $y);
            }
            $screen .= "\n";
        }
        return "$screen Roll: $roll\nPitch: $pitch\n";
    }
    private static function setElevation() {
        $pitch = self::$pitch;
        if ($pitch < 0.5 && $pitch > -0.5) self::$elevation = floor($pitch * 4 * floor(self::$height / 2));
        else {
            if ($pitch < 0) $pitch = -1 - $pitch;
            else $pitch = 1 - $pitch;
            self::$elevation = floor($pitch * 4 * floor(self::$height / 2));
        }
        if (self::$roll >= 0) self::$elevation = floor(self::$elevation * 2 * abs(self::$roll - 0.5));
        else self::$elevation = floor(self::$elevation * 2 * abs(self::$roll + 0.5));
    }
    private static function horizon($x, $y) {
        $roll = self::$roll;
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
        if (!(self::$pitch < 0.5 && self::$pitch > -0.5)) $comp = -$comp;
        if ($comp == -self::$elevation) return '-';
        if ($comp < -self::$elevation) return '@';
        return ' ';
    }
}
