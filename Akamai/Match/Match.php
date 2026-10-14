<?php

namespace Akamai\Match;

class Match {
  protected $matchOperator;
  public function __construct($matchOperator) {
    $this->matchOperator = $matchOperator;
  }
  public function export($options = []) {
    $options['matchOperator'] = $this->matchOperator;
    return $options;
  }
}
