<?php

namespace Akamai\Behaviors;

abstract class Enabled extends Behavior {
  protected $name, $enabled;
  public function __construct($name, $enabled = true) {
    parent::__construct($name);
    $this->enabled($enabled);
  }
  public function enabled($enabled = true) {
    validate([
      'type' => 'boolean',
    ], $enabled);
    $this->enabled = $enabled;
    return $this;
  }
  public function export($options = []) {
    $options['enabled'] = $this->enabled;
    return parent::export($options);
  }
}
