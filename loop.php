<?php
class Loop {
    public static function start($plane) {
        $time = 0;
        system("stty -icanon");
        while (true) {
        //for ($i = 0; $i <= 20; $i++) {
            self::listen($plane);
            //$plane->roll(0.1);
            $time += 0.2;
            self::draw($plane, $time);
            usleep(200000);
        }
    }
    private static function draw($plane, $time) {
        echo View::draw($plane->getRoll(), $time);
    }
    private static function listen($plane) {
        stream_set_blocking(STDIN, false);
        if ($c = fread(STDIN,1)) {
            switch ($c) {
                case '4':
                    $plane->roll(0.05);
                    break;
                case '6':
                    $plane->roll(-0.05);
                    break;
            }
        }
    }
}
