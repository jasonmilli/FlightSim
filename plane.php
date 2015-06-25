<?php
class Plane {
    private $latitude;
    private $longitude;
    private $altitude;
    private $speed;
    private $pitch;
    private $roll;
    private $yaw;
    private $power;
    private $cruising_speed;
    public function __construct ($latitude = 0, $longitude = 0, $altitude = 0, $speed = 0, $pitch = 0, $roll = 0, $yaw = 0, $power = 50, $cruising_speed = 100) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
        $this->speed = $speed;
        $this->pitch = $pitch;
        $this->roll = $roll;
        $this->yaw = $yaw;
        $this->power = $power;
        $this->cruising_speec = $cruising_speed;
    }
    public function getRoll() {
        return $this->roll;
    }
    public function roll($inc) {
        $this->roll += $inc;
        if ($this->roll > 1) $this->roll -= 2;
        elseif ($this->roll <= -1) $this->roll += 2;
    }
}
