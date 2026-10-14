<?php

namespace Akamai\Criteria;

class MatchVariable extends Criterion {
  protected $variableName, $matchCaseSensitive = true, $matchWildcard = false;
  public function __construct($variableName) {
    parent::__construct('matchVariable');
    #"IS", "IS_NOT", "IS_ONE_OF", "IS_NOT_ONE_OF", "IS_EMPTY", "IS_NOT_EMPTY", "IS_BETWEEN", "IS_NOT_BETWEEN",
    # "IS_GREATER_THAN", "IS_GREATER_THAN_OR_EQUAL_TO", "IS_LESS_THAN", "IS_LESS_THAN_OR_EQUAL_TO"
    $this->variableName = validate([
      'type' => 'string',
    ], $variableName);
  }
  public function isOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(true, $values, 'variableValues'));
  }
  public function isNotOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(false, $values, 'variableValues'));
  }
  public function isEmpty() {
    return $this->match(new \Akamai\Match\IsEmpty(true));
  }
  public function isNotEmpty() {
    return $this->match(new \Akamai\Match\IsEmpty(false));
  }
  public function caseInsensitive() {
    $this->matchCaseSensitive = false;
    return $this;
  }
  public function caseSensitive() {
    $this->matchCaseSensitive = true;
    return $this;
  }
  public function matchWildcard($match = true) {
    $this->matchWildcard = validate([
      'type' => 'boolean',
    ], $match);
    return $this;
  }
  public function export($options = []) {
    $options['variableName'] = sprintf('PMUSER_%s', strtoupper($this->variableName));
    $options['matchCaseSensitive'] = $this->matchCaseSensitive;
    $options['matchWildcard'] = $this->matchWildcard;
    return parent::export($options);
  }
}
