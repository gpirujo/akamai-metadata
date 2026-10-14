<?php

namespace Akamai\Criteria;

class ContentType extends Criterion {
  protected $matchCaseSensitive = false, $matchWildcard = true;
  public function __construct() {
    parent::__construct('contentType');
  }
  public function isOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(true, $values));
  }
  public function isNotOneOf($values) {
    return $this->match(new \Akamai\Match\IsOneOf(false, $values));
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
    $options['matchCaseSensitive'] = $this->matchCaseSensitive;
    $options['matchWildcard'] = $this->matchWildcard;
    return parent::export($options);
  }
}
