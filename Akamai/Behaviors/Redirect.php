<?php

namespace Akamai\Behaviors;

class Redirect extends Behavior {
  protected $responseCode;
  protected $destinationProtocol = 'SAME_AS_REQUEST';
  protected $destinationHostname = 'SAME_AS_REQUEST';
  protected $destinationHostnameOther;
  protected $destinationPath = 'SAME_AS_REQUEST';
  protected $destinationPathOther;
  protected $queryString = 'APPEND';
  public function __construct($responseCode) {
    parent::__construct('redirect');
    validate([
      'type' => 'enum',
      'enum' => [301, 302, 303, 307],
    ], $responseCode);
    $this->responseCode = $responseCode;
  }
  public function http() {
    $this->destinationProtocol = 'HTTP';
    return $this;
  }
  public function https() {
    $this->destinationProtocol = 'HTTPS';
    return $this;
  }
  public function hostname($hostname) {
    validate([
      'type' => 'string',
    ], $hostname);
    $this->destinationHostname = 'OTHER';
    $this->destinationHostnameOther = $hostname;
    return $this;
  }
  public function path($path) {
    validate([
      'type' => 'string',
    ], $path);
    $this->destinationPath = 'OTHER';
    $this->destinationPathOther = $path;
    return $this;
  }
  public function ignoreQueryString() {
    $this->queryString = 'IGNORE';
    return $this;
  }
  public function export($options = []) {
    $options['mobileDefaultChoice'] = 'DEFAULT';
    $options['responseCode'] = $this->responseCode;
    $options['destinationProtocol'] = $this->destinationProtocol;
    $options['destinationHostname'] = $this->destinationHostname;
    $options['destinationPath'] = $this->destinationPath;
    $options['queryString'] = $this->queryString;
    if ($this->destinationHostname == 'OTHER') {
      $options['destinationHostnameOther'] = $this->destinationHostnameOther;
    }
    if ($this->destinationPath == 'OTHER') {
      $options['destinationPathOther'] = $this->destinationPathOther;
    }
    return parent::export($options);
  }
}
