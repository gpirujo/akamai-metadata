<?php

namespace Akamai\Behaviors;

class RewriteUrl extends Behavior {
  protected $behavior;
  protected $match, $targetPath; // replace
  protected $matchRegex, $targetRegex; // regex_replace
  protected $targetUrl; // rewrite
  protected $targetPathPrepend; // prepend
  protected $matchMultiple = false;
  protected $keepQueryString = true;
  public function __construct() {
    parent::__construct('rewriteUrl');
  }
  public function replace($match, $targetPath) {
    $this->match = validate([
      'type' => 'string',
    ], $match);
    $this->targetPath = validate([
      'type' => 'string',
    ], $targetPath);
    $this->behavior = 'REPLACE';
    return $this;
  }
  public function remove($match) {
    $this->match = validate([
      'type' => 'string',
    ], $match);
    $this->behavior = 'REMOVE';
    return $this;
  }
  public function rewrite($targetUrl) {
    $this->targetUrl = validate([
      'type' => 'string',
    ], $targetUrl);
    $this->behavior = 'REWRITE';
    return $this;
  }
  public function prepend($targetPathPrepend) {
    $this->targetPathPrepend = validate([
      'type' => 'string',
    ], $targetPathPrepend);
    $this->behavior = 'PREPEND';
    return $this;
  }
  public function regexReplace($matchRegex, $targetRegex) {
    $this->matchRegex = validate([
      'type' => 'string',
    ], $matchRegex);
    $this->targetRegex = validate([
      'type' => 'string',
    ], $targetRegex);
    $this->behavior = 'REGEX_REPLACE';
    return $this;
  }
  public function matchMultiple($do = true) {
    $this->matchMultiple = validate([
      'type' => 'boolean',
    ], $do);
    return $this;
  }
  public function keepQueryString($do = true) {
    $this->keepQueryString = validate([
      'type' => 'boolean',
    ], $do);
    return $this;
  }
  public function removeQueryString() {
    return $this->keepQueryString(false);
  }
  public function export($options = []) {
    $options['behavior'] = $this->behavior;
    $options['matchMultiple'] = $this->matchMultiple;
    $options['keepQueryString'] = $this->keepQueryString;
    if ($this->behavior == 'REPLACE') {
      $options['match'] = $this->match;
      $options['targetPath'] = $this->targetPath;
    } else if ($this->behavior == 'REMOVE') {
      $options['match'] = $this->match;
    } else if ($this->behavior == 'REWRITE') {
      $options['targetUrl'] = $this->targetUrl;
    } else if ($this->behavior == 'PREPEND') {
      $options['targetPathPrepend'] = $this->targetPathPrepend;
    } else if ($this->behavior == 'REGEX_REPLACE') {
      $options['matchRegex'] = $this->matchRegex;
      $options['targetRegex'] = $this->targetRegex;
    }
    return parent::export($options);
  }
}
