<?php

namespace Akamai\Behaviors;

class Behavior {
  protected $name = null;
  public function __construct($name) {
    $this->name = $name;
  }
  public function export($options = []) {
    return [
      'name' => $this->name,
      'options' => $options,
    ];
  }
}
