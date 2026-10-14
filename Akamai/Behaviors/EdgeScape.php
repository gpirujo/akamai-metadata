<?php

namespace Akamai\Behaviors;

class EdgeScape extends Enabled {
  public function __construct($enabled) {
    parent::__construct('edgeScape', $enabled);
  }
}
