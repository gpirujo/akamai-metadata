<?php

namespace Akamai\Behaviors;

class Origin extends Behavior {
  protected $originType;
  public function __construct($originType) {
    parent::__construct('origin');
    $this->originType = $originType;
  }
  public function export($options = []) {
    $options['originType'] = $this->originType;
    return parent::export($options);
  }
}
