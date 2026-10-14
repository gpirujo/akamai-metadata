<?php

namespace Akamai\Criteria;

class Hostname extends Criterion {
  public function __construct() {
    parent::__construct('hostname');
  }
  public function isOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(true, $values));
  }
  public function isNotOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(false, $values));
  }
}
