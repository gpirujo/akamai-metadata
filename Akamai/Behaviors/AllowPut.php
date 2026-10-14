<?php

namespace Akamai\Behaviors;

class AllowPut extends Enabled {
  public function __construct($enabled = true) {
    parent::__construct('allowPut', $enabled);
  }
}
