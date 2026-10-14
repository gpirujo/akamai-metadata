<?php

namespace Akamai\Behaviors;

class ModifyOutgoingResponseHeader extends Behavior {
  protected $action, $customHeaderName;
  protected $standardAddHeaderName, $headerValue;
  protected $standardModifyHeaderName, $newHeaderValue, $avoidDuplicateHeaders;
  public function __construct() {
    parent::__construct('modifyOutgoingResponseHeader');
  }
  public function add($name, $value) {
    $this->customHeaderName = validate([
      'type' => 'string',
    ], $name);
    $this->headerValue = validate([
      'type' => 'string',
    ], $value);
    $this->action = 'ADD';
    $this->standardAddHeaderName = 'OTHER';
    return $this;
  }
  public function modify($name, $value, $avoidDuplicates = true) {
    $this->customHeaderName = validate([
      'type' => 'string',
    ], $name);
    $this->newHeaderValue = validate([
      'type' => 'string',
    ], $value);
    $this->avoidDuplicateHeaders = validate([
      'type' => 'boolean',
    ], $avoidDuplicates);
    $this->action = 'MODIFY';
    $this->standardModifyHeaderName = 'OTHER';
    return $this;
  }
  public function export($options = []) {
    $options['action'] = $this->action;
    $options['customHeaderName'] = $this->customHeaderName;
    if ($this->action == 'ADD') {
      $options['headerValue'] = $this->headerValue;
      $options['standardAddHeaderName'] = 'OTHER';
    } else if ($this->action == 'MODIFY') {
      $options['newHeaderValue'] = $this->newHeaderValue;
      $options['standardModifyHeaderName'] = 'OTHER';
    }
    return parent::export($options);
  }
}
