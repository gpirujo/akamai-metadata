<?php

namespace Akamai\Behaviors;

class ConstructResponse extends Behavior {
  protected $responseCode, $body, $forceEviction = false;
  public function __construct($responseCode, $body) {
    parent::__construct('constructResponse');
    $this->responseCode = validate([
      'type' => 'number',
      'minimum' => 100,
      'maximum' => 999,
    ], $responseCode);
    $this->body = validate([
      'type' => 'string',
    ], $body);
  }
  public function forceEviction($force = true) {
    $this->forceEviction = validate([
      'type' => 'boolean',
    ], $force);
    return $this;
  }
  public function export($options = []) {
    $options['enabled'] = true;
    $options['responseCode'] = $this->responseCode;
    $options['body'] = $this->body;
    $options['forceEviction'] = $this->forceEviction;
    return parent::export($options);
  }
}
