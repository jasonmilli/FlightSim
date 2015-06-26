<?php
class Loop {
    private static $plane;
    public static function start($plane) {
        self::$plane = $plane;
        $time = 0;
        system("stty -icanon");
        while (true) {
        //for ($i = 0; $i <= 20; $i++) {
            self::listen();
            //$plane->roll(0.1);
            $time += 0.2;
            self::draw($time);
            usleep(200000);
        }
    }
    private static function draw($time) {
        echo View::draw(self::$plane->getRoll(), self::$plane->getPitch(), $time);
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
            }
        }
    }
}
