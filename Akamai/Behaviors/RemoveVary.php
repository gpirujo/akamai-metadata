<?php

namespace Akamai\Behaviors;

class RemoveVary extends Enabled {
  public function __construct() {
    parent::__construct('removeVary');
  }
}
