<?php

namespace Akamai\Behaviors;

class AllowAllMethods extends Enabled {
  public function __construct($enabled) {
    parent::__construct('allHttpInCacheHierarchy', $enabled);
  }
}
