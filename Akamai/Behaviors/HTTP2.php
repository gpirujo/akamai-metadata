<?php

namespace Akamai\Behaviors;

class HTTP2 extends Enabled {
  public function __construct($enabled = true) {
    parent::__construct('http2', $enabled);
  }
}
