<?php

namespace Akamai\Behaviors;

class CacheKeyQueryParams extends Behavior {
  protected $behavior = 'INCLUDE_ALL_PRESERVE_ORDER';
  protected $parameters;
  protected $exactMatch = false;
  public function __construct() {
    parent::__construct('cacheKeyQueryParams');
  }
  public function includeAllUnsorted() {
    $this->behavior = 'INCLUDE_ALL_PRESERVE_ORDER';
    return $this;
  }
  public function sort() {
    $this->behavior = 'INCLUDE_ALL_ALPHABETIZE_ORDER';
    return $this;
  }
  public function ignoreAll() {
    $this->behavior = 'IGNORE_ALL';
    return $this;
  }
  public function ignoreParams($parameters) {
    $this->parameters = validate([
      'type' => 'array',
    ], $parameters);
    $this->behavior = 'IGNORE';
    return $this;
  }
  public function includeParams($parameters) {
    $this->parameters = validate([
      'type' => 'array',
    ], $parameters);
    $this->behavior = 'INCLUDE';
    return $this;
  }
  public function exactMatch($exact = true) {
    $this->exactMatch = validate([
      'type' => 'boolean',
    ], $exact);
    return $this;
  }
  public function export($options = []) {
    $options['behavior'] = $this->behavior;
    if (in_array($this->behavior, ['IGNORE', 'INCLUDE'])) {
      $options['parameters'] = $this->parameters;
      $options['exactMatch'] = $this->exactMatch;
    }
    return parent::export($options);
  }
}
