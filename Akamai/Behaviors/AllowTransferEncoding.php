<?php

namespace Akamai\Behaviors;

class AllowTransferEncoding extends Enabled {
  public function __construct($enabled = true) {
    parent::__construct('allowTransferEncoding', $enabled);
  }
}
