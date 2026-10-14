<?php

namespace Akamai\Operations;

abstract class Operation {
  protected $transform;
  public function __construct($transform) {
    $this->transform = $transform;
  }
  public function export($options) {
    $options['transform'] = $this->transform;
    return $options;
  }
}
