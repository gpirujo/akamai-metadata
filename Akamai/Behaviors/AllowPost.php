<?php

namespace Akamai\Behaviors;

class AllowPost extends Enabled {
  protected $allowWithoutContentLength = false;
  public function __construct($enabled = true) {
    parent::__construct('allowPost', $enabled);
  }
  public function allowWithoutContentLength($allow = true) {
    $this->allowWithoutContentLength = validate([
      'type' => 'boolean',
    ], $allow);
    return $this;
  }
  public function export($options = []) {
    $options['allowWithoutContentLength'] = $this->allowWithoutContentLength;
    return parent::export($options);
  }
}
