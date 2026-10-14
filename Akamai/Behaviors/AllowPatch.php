<?php

namespace Akamai\Behaviors;

class AllowPatch extends Enabled {
  public function __construct($enabled = true) {
    parent::__construct('allowPatch', $enabled);
  }
}
