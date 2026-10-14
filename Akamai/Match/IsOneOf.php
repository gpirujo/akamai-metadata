<?php

namespace Akamai\Match;

class IsOneOf extends Match {
  protected $values, $paramName;
  public function __construct($positive, $values, $paramName = 'values') {
    parent::__construct($positive ? 'IS_ONE_OF' : 'IS_NOT_ONE_OF');
    $this->values = validate([
      'type' => 'array',
    ], $values);
    $this->paramName = $paramName;
  }
  public function export($options = []) {
    $options[$this->paramName] = $this->values;
    return parent::export($options);
  }
}
