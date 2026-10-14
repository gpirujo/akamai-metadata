<?php

namespace Akamai\Behaviors;

class Caching extends Behavior {
  protected $behavior = 'MAX_AGE';
  protected $mustRevalidate = false;
  protected $ttl = '0s';
  protected $defaultTtl = '0s';
  protected $honorMustRevalidateEnabled = true;
  protected $honorPrivateEnabled = true;
  public function __construct() {
    parent::__construct('caching');
  }
  public function noStore() {
    $this->behavior = 'NO_STORE';
    return $this;
  }
  public function bypass() {
    $this->behavior = 'BYPASS_CACHE';
    return $this;
  }
  public function maxAge($ttl) {
    $this->ttl = validate([
      'type' => 'string',
      'pattern' => '^[0-9]+[DdHhMmSs]$',
    ], $ttl);
    $this->behavior = 'MAX_AGE';
    return $this;
  }
  public function honorCacheControl() {
    $this->behavior = 'CACHE_CONTROL';
    return $this;
  }
  public function honorExpires() {
    $this->behavior = 'EXPIRES';
    return $this;
  }
  public function honorCacheControlAndExpires() {
    $this->behavior = 'CACHE_CONTROL_AND_EXPIRES';
    return $this;
  }
  public function defaultTtl($defaultTtl) {
    $this->defaultTtl = validate([
      'type' => 'string',
      'pattern' => '^[0-9]+[DdHhMmSs]$',
    ], $defaultTtl);
    return $this;
  }
  public function mustRevalidate($must = true) {
    $this->mustRevalidate = validate([
      'type' => 'boolean',
    ], $must);
    return $this;
  }
  public function honorMustRevalidate($honor = true) {
    $this->honorMustRevalidateEnabled = validate([
      'type' => 'boolean',
    ], $honor);
    return $this;
  }
  public function honorPrivate($honor = true) {
    $this->honorPrivateEnabled = validate([
      'type' => 'boolean',
    ], $honor);
    return $this;
  }
  public function export($options = []) {
    $options['behavior'] = $this->behavior;
    $options['mustRevalidate'] = $this->mustRevalidate;
    $options['ttl'] = $this->ttl;
    $options['defaultTtl'] = $this->defaultTtl;
    $options['honorMustrevalidateEnabled'] /* sic */ = $this->honorMustRevalidateEnabled;
    $options['honorPrivateEnabled'] = $this->honorPrivateEnabled;
    return parent::export($options);
  }
}
