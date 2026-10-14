<?php

namespace Akamai\Behaviors;

class AllowDelete extends Enabled {
  protected $allowBody = false;
  public function __construct($enabled = true) {
    parent::__construct('allowDelete', $enabled);
  }
  public function allowBody($allow = true) {
    $this->allowBody = validate([
      'type' => 'boolean',
    ], $allow);
    return $this;
  }
  public function export($options = []) {
    $options['allowBody'] = $this->allowBody;
    return parent::export($options);
  }
}
