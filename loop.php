<?php
class Loop {
    private static $plane;
    public static function start($plane) {
        self::$plane = $plane;
        $time = 0;
        system("stty -icanon");
        while (true) {
            self::listen();
            $plane->step(0.2);
            $time += 0.2;
            self::draw($time);
            usleep(200000);
        }
    }
    private static function draw($time) {
        echo View::draw(self::$plane->getRoll(), self::$plane->getPitch(), $time, self::$plane->getSpeed(), self::$plane->getAltitude(), self::$plane->getPower());
    }
    private static function listen() {
        stream_set_blocking(STDIN, false);
        if ($c = fread(STDIN,1)) {
            switch ($c) {
                case '4':
                    self::$plane->roll(0.05);
                    break;
                case '6':
                    self::$plane->roll(-0.05);
                    break;
                case '8':
                    self::$plane->pitch(-0.05);
                    break;
                case '2':
                    self::$plane->pitch(0.05);
                    break;
                case 'a':
                case 'A':
                    self::$plane->throttle(5);
                    break;
                case 'z':
                case 'Z':
                    self::$plane->throttle(-5);
                    break;
            }
        }
    }
}
