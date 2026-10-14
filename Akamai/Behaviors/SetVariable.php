<?php

namespace Akamai\Behaviors;

class SetVariable extends Behavior {
  protected $variableName;
  protected $valueSource;
  protected $variableValue;
  protected $transform;
  public function __construct($variableName) {
    parent::__construct('setVariable');
    $this->variableName = validate([
      'type' => 'string'
    ], $variableName);
  }
  public function expression($variableValue) {
    $this->variableValue = validate([
      'type' => 'string'
    ], $variableValue);
    $this->valueSource = 'EXPRESSION';
    return $this;
  }
  public function substitute($regex, $replacement, $caseSensitive = true, $globalSubstitution = false) {
    $this->transform = new \Akamai\Operations\Substitute($regex, $replacement, $caseSensitive, $globalSubstitution);
    return $this;
  }
  public function export($options = []) {
    if (!isset($this->transform)) {
      $this->transform = new \Akamai\Operations\None();
    }
    $options['variableName'] = sprintf('PMUSER_%s', strtoupper($this->variableName));
    $options['valueSource'] = $this->valueSource;
    $options['variableValue'] = $this->variableValue;
    return parent::export($this->transform->export($options));
  }
}
