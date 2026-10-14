<?php

namespace Akamai\Behaviors;

class CPCode extends Behavior {
  protected $id;
  public function __construct($id) {
    parent::__construct('cpCode');
    $this->id = validate([
      'type' => 'number',
      'minimum' => 1,
      'maximum' => pow(2, 20),
    ], $id);
  }
  public function export($options = []) {
    if (!isset($options['value'])) $options['value'] = [];
    $options['value']['id'] = $this->id;
    return parent::export($options);
  }
}
