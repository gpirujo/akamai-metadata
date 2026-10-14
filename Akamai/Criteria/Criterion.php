<?php

namespace Akamai\Criteria;

class Criterion {
  protected $name, $match;
  public function __construct($name) {
    $this->name = $name;
  }
  protected function match($match) {
    $this->match = $match;
    return $this;
  }
  public function export($options = []) {
    if (isset($this->match)) $options = $this->match->export($options);
    return [
      'name' => $this->name,
      'options' => $options,
    ];
  }
}
