<?php

namespace Akamai;

class Configuration {
  protected $hostnames, $defaultRule, $comments;
  public function hostnames($hostnames) {
    $this->hostnames = $hostnames;
    return $this;
  }
  public function rules($defaultRule) {
    $this->defaultRule = $defaultRule;
    return $this;
  }
  public function comments($comments) {
    $this->comments = $comments;
    return $this;
  }
  public function exportHostnames() {
    $result = [];
    foreach ($this->hostnames as $shn => $ehn) {
      $result[] = [
        'cnameType' => 'EDGE_HOSTNAME',
        'cnameFrom' => $shn,
        'cnameTo' => $ehn,
      ];
    }
    return $result;
  }
  public function exportRules() {
    $result = [];
    #$result['ruleFormat'] = 'v2019-07-25';
    $result['rules'] = $this->defaultRule->export();
    if (isset($this->comments)) {
      $result['comments'] = $this->comments;
    }
    return $result;
  }
}
