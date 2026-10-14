<?php

namespace Akamai\Criteria;

class RequestHeader extends Criterion {
  protected $headerName;
  protected $matchWildcardName = false;
  protected $matchWildcardValue = false;
  protected $matchCaseSensitiveValue = true;
  public function __construct($headerName) {
    parent::__construct('requestHeader');
    $this->headerName = validate([
      'type' => 'string',
    ], $headerName);
  }
  public function isOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(true, $values));
  }
  public function isNotOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(false, $values));
  }
  public function exists() {
    return $this->match(new \Akamai\Match\Exists(true));
  }
  public function doesNotExist() {
    return $this->match(new \Akamai\Match\Exists(false));
  }
  public function caseSensitiveValue($sensitive = true) {
    $this->matchCaseSensitiveValue = validate([
      'type' => 'boolean',
    ], $sensitive);
    return $this;
  }
  public function caseInsensitiveValue() {
    $this->caseSensitiveValue(false);
    return $this;
  }
  public function wildcardName($wildcard = true) {
    $this->matchWildcardName = validate([
      'type' => 'boolean',
    ], $wildcard);
    return $this;
  }
  public function wildcardValue($wildcard = true) {
    $this->matchWildcardValue = validate([
      'type' => 'boolean',
    ], $wildcard);
    return $this;
  }
  public function export($options = []) {
    $options['headerName'] = $this->headerName;
    $options['matchCaseSensitiveValue'] = $this->matchCaseSensitiveValue;
    $options['matchWildcardName'] = $this->matchWildcardName;
    $options['matchWildcardValue'] = $this->matchWildcardValue;
    return parent::export($options);
  }
}
