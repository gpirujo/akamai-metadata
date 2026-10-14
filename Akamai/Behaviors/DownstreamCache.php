<?php

namespace Akamai\Behaviors;

class DownstreamCache extends Behavior {
  protected $behavior = 'ALLOW';
  protected $allowBehavior = 'LESSER';
  protected $ttl = '0s';
  protected $sendHeaders = 'CACHE_CONTROL_AND_EXPIRES';
  protected $sendPrivate = false;
  public function __construct() {
    parent::__construct('downstreamCache');
  }
  public function allowLesser() {
    $this->behavior = 'ALLOW';
    $this->allowBehavior = 'LESSER';
    return $this;
  }
  public function allowGreater() {
    $this->behavior = 'ALLOW';
    $this->allowBehavior = 'GREATER';
    return $this;
  }
  public function allowRemaining() {
    $this->behavior = 'ALLOW';
    $this->allowBehavior = 'REMAINING_LIFETIME';
    return $this;
  }
  public function allowFixed($ttl) {
    $this->ttl = validate([
      'type' => 'string',
      'pattern' => '^[0-9]+[DdHhMmSs]$',
    ]);
    $this->behavior = 'ALLOW';
    $this->allowBehavior = 'FROM_MAX_AGE';
    return $this;
  }
  public function mustRevalidate() {
    $this->behavior = 'MUST_REVALIDATE';
    return $this;
  }
  public function bust() {
    $this->behavior = 'BUST';
    return $this;
  }
  public function originHeaders() {
    $this->behavior = 'TUNNEL_ORIGIN';
    return $this;
  }
  public function none() {
    $this->behavior = 'NONE';
    return $this;
  }
  public function sendCacheControl() {
    if ($this->sendHeaders == 'EXPIRES') {
      $this->behavior = 'CACHE_CONTROL_AND_EXPIRES';
    } else {
      $this->behavior = 'CACHE_CONTROL';
    }
    return $this;
  }
  public function sendExpires() {
    if ($this->sendHeaders == 'CACHE_CONTROL') {
      $this->behavior = 'CACHE_CONTROL_AND_EXPIRES';
    } else {
      $this->behavior = 'EXPIRES';
    }
    return $this;
  }
  public function sendOriginHeaders() {
    $this->sendHeaders = 'PASS_ORIGIN';
    return $this;
  }
  public function sendPrivate($send = true) {
    $this->sendPrivate = validate([
      'type' => 'boolean',
    ], $send);
    return $this;
  }
  public function export($options = []) {
    $options['behavior'] = $this->behavior;
    $options['sendHeaders'] = $this->sendHeaders;
    $options['sendPrivate'] = $this->sendPrivate;
    if ($this->behavior == 'ALLOW') {
      $options['allowBehavior'] = $this->allowBehavior;
      if ($this->allowBehavior == 'FROM_MAX_AGE') {
        $options['ttl'] = $this->ttl;
      }
    }
    return parent::export($options);
  }
}
