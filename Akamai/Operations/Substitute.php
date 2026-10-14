<?php

namespace Akamai\Operations;

class Substitute extends Operation {
  protected $regex;
  protected $replacement;
  protected $caseSensitive = true;
  protected $globalSubstitution = false;
  public function __construct($regex, $replacement, $caseSensitive = true, $globalSubstitution = false) {
    parent::__construct('SUBSTITUTE');
    $this->regex = validate([
      'type' => 'string',
    ], $regex);
    $this->replacement = validate([
      'type' => 'string',
    ], $replacement);
    $this->caseSensitive = validate([
      'type' => 'boolean',
    ], $caseSensitive);
    $this->globalSubstitution = validate([
      'type' => 'boolean',
    ], $globalSubstitution);
  }
  public function export($options = []) {
    return parent::export(array_merge($options, [
      'regex' => $this->regex,
      'replacement' => $this->replacement,
      'caseSensitive' => $this->caseSensitive,
      'globalSubstitution' => $this->globalSubstitution,
    ]));
  }
}
