<?php

namespace Akamai\Behaviors;

class GzipResponse extends Behavior {
  protected $behavior;
  public function __construct() {
    parent::__construct('gzipResponse');
    $this->always();
  }
  public function always() {
    $this->behavior = 'ALWAYS';
    return $this;
  }
  public function never() {
    $this->behavior = 'NEVER';
    return $this;
  }
  public function originResponse() {
    $this->behavior = 'ORIGIN_RESPONSE';
    return $this;
  }
  public function export($options = []) {
    $options['behavior'] = $this->behavior;
    return parent::export($options);
  }
}
