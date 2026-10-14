<?php

namespace Akamai\Behaviors;

class BaseDirectory extends Behavior {
  protected $value;
  public function __construct($value) {
    parent::__construct('baseDirectory');
    validate([
      'type' => 'string',
    ], $value);
    $this->value = $value;
  }
  public function export($options = []) {
    $options['value'] = $this->value;
    return parent::export($options);
  }
}
