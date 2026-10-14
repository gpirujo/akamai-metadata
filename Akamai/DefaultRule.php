<?php

namespace Akamai;

class DefaultRule extends AnyRule {
  protected $isSecure = false;
  protected $variables = [];
  public function isSecure($isSecure) {
    if (is_bool($isSecure)) {
      $this->isSecure = $isSecure;
    } else if (is_string($isSecure) && in_array(strtolower($isSecure), ['true', 'false'])) {
      $this->isSecure = $isSecure === 'true';
    } else {
      throw new Exception('Value %s must be "true" or "false"');
    }
    return $this;
  }
  public function variables($variables) {
    $this->variables = $variables;
    return $this;
  }
  public function __construct() {
    parent::__construct('default');
  }
  public function export() {
    $result = parent::export();
    $result['options']['is_secure'] = $this->isSecure;
    $variables = [];
    foreach ($this->variables as $name => $value) {
      $variables[] = [
        'name' => sprintf('PMUSER_%s', strtoupper($name)),
        'value' => $value,
        'description' => '',
        'sensitive' => false,
        'hidden' => false,
      ];
    };
    if (count($variables)) $result['variables'] = $variables;
    return $result;
  }
}
