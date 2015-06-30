<?php
class Plane {
    private $latitude;
    private $longitude;
    private $altitude;
    private $speed;
    private $pitch;
    private $roll;
    private $yaw;
    private $max_power;
    private $throttle;
    private $mass;
    private $wing_width;
    private $wing_height;
    private $wing_span;
    private $fuselage_diameter;
    private $fuselage_length;
    private $climbing_rate;
    public function __construct (
        $latitude = 0,
        $longitude = 0,
        $altitude = 0,
        $speed = 0,
        $pitch = 0,
        $roll = 0,
        $yaw = 0,
        $max_power = 1000000,
        $mass = 3000,
        $throttle = 50,
        $wing_width = 5,
        $wing_height = 0.5,
        $wing_span = 10,
        $fuselage_radius = 1,
        $fuselage_length = 10,
        $climbing_rate = 0
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
        $this->speed = $speed;
        $this->pitch = $pitch;
        $this->roll = $roll;
        $this->yaw = $yaw;
        $this->max_power = $max_power;
        $this->mass = $mass;
        $this->throttle = $throttle;
        $this->wing_width = $wing_width;
        $this->wing_height = $wing_height;
        $this->wing_span = $wing_span;
        $this->fuselage_radius = $fuselage_radius;
        $this->fuselage_length = $fuselage_length;
        $this->climbing_rate = $climbing_rate;
    }
    public function getRoll() {
        return $this->roll;
    }
    public function getPitch() {
        return $this->pitch;
    }
    public function getSpeed() {
        return $this->speed;
    }
    public function getAltitude() {
        return $this->altitude;
    }
    public function getPower() {
        return $this->throttle * $this->max_power / 100;
    }
    public function roll($inc) {
        $this->roll += $inc;
        if ($this->roll > 1) $this->roll -= 2;
        elseif ($this->roll <= -1) $this->roll += 2;
    }
    public function pitch($inc) {
        $this->pitch += $inc;
        if ($this->pitch > 1) $this->pitch -= 2;
        elseif ($this->pitch <= -1) $this->pitch += 2;
    }
    public function throttle($inc) {
        if ($this->throttle + $inc <= 100 && $this->throttle + $inc>= 0 ) $this->throttle += $inc;
    }
    public function step($time) {
        $this->speed($time);
        $this->climbing_rate($time);
        $this->altitude($time);
        echo "Climbing rate: {$this->climbing_rate}\n";
    }
    private function speed($time) {
        $area = $this->wing_span * $this->wing_height + $this->fuselage_radius * M_PI * 2;
        $drag_force = 0.5 * 1.225 * pow($this->speed, 2) * 0.04 * $area;
        $power = 0.8 * $this->throttle * $this->max_power / 100;
        $force = $power / $this->speed - $drag_force;
        $this->speed += (1 / $time) * $force / $this->mass;
    }
    private function climbing_rate($time) {
        $area = $this->wing_span * $this->wing_width;
        $lift_force = 0.5 * 1.225 * pow($this->speed, 2) * $area * 0.0002;
        $whole_area = $area + 2 * $this->fuselage_radius * $this->fuselage_length;
        $drag_force = 0.5 * 1.225 * pow($this->climbing_rate, 2) * 0.04 * $whole_area;
        $force = $lift_force - 10 - $drag_force;
        $this->climbing_rate += (1 / $time) * $force / $this->mass;
    }
    private function altitude($time) {
        $this->altitude += $this->climbing_rate * $time;
    }
}
