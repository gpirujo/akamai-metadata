<?php

namespace Akamai\Criteria;

class RequestProtocol extends Criterion {
  protected $requestProtocol;
  public function __construct() {
    parent::__construct('requestProtocol');
  }
  public function isHttp() {
    $this->requestProtocol = 'HTTP';
    return $this;
  }
  public function isHttps() {
    $this->requestProtocol = 'HTTPS';
    return $this;
  }
  public function export($options = []) {
    if (!isset($this->requestProtocol)) {
      throw new Exception('Request protocol not set');
    }
    $options['value'] = $this->requestProtocol;
    return parent::export($options);
  }
}
