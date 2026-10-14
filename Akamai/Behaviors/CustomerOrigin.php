<?php

namespace Akamai\Behaviors;

class CustomerOrigin extends Origin {
  protected $hostname, $forwardHostHeader, $customForwardHostHeader;
  protected $cacheKeyHostname, $compress, $originSni;
  protected $enableTrueClientIp;
  #protected $trueClientIpHeader, $trueClientIpClientSetting;
  #protected $originTlsChoice, $originTlsSelectValues;
  protected $verificationMode, $customValidCnValues, $originCertsToHonor;
  protected $standardCertificateAuthorities, $customCertificateAuthorities, $customCertificates;
  protected $httpPort, $httpsPort;
  public function __construct($hostname) {
    parent::__construct('CUSTOMER');
    $this->hostname = validate([
      'type' => 'string',
    ], $hostname);
    $this->forwardHostHeaderIncomingHostname();
    $this->cacheKeyIncomingHostname();
    $this->compress();
    $this->sni();
    $this->enableTrueClientIp = false;
    $this->verificationMode = 'CUSTOM';
    $this->originCertsToHonor = 'COMBO';
    $this->standardCertificateAuthorities = [];
    $this->customCertificateAuthorities = [];
    $this->customCertificates = [];
    $this->httpPort = 80;
    $this->httpsPort = 443;
  }
  public function forwardHostHeaderOriginHostname() {
    $this->forwardHostHeader = 'ORIGIN_HOSTNAME';
    return $this;
  }
  public function forwardHostHeaderIncomingHostname() {
    $this->forwardHostHeader = 'REQUEST_HOST_HEADER';
    return $this;
  }
  public function forwardHostHeaderCustom($customForwardHostHeader) {
    $this->customForwardHostHeader = validate([
      'type' => 'string',
    ], $customForwardHostHeader);
    $this->forwardHostHeader = 'CUSTOM';
    return $this;
  }
  public function cacheKeyOriginHostname() {
    $this->cacheKeyHostname = 'ORIGIN_HOSTNAME';
    return $this;
  }
  public function cacheKeyIncomingHostname() {
    $this->cacheKeyHostname = 'REQUEST_HOST_HEADER';
    return $this;
  }
  public function compress($compress = true) {
    validate([
      'type' => 'boolean',
    ], $compress);
    $this->compress = $compress;
    return $this;
  }
  public function sni($originSni = true) {
    validate([
      'type' => 'boolean',
    ], $originSni);
    $this->originSni = $originSni;
    return $this;
  }
  public function customCNValues($customValidCnValues) {
    validate([
      'type' => 'array',
    ], $customValidCnValues);
    $this->customValidCnValues = $customValidCnValues;
    return $this;
  }
  public function standardCA() {
    if (!in_array('akamai-permissive', $this->standardCertificateAuthorities)) $this->standardCertificateAuthorities[] = 'akamai-permissive';
    return $this;
  }
  public function awsCA() {
    if (!in_array('THIRD_PARTY_AMAZON', $this->standardCertificateAuthorities)) $this->standardCertificateAuthorities[] = 'THIRD_PARTY_AMAZON';
    return $this;
  }
  public function customCA($ca) {
    $this->customCertificateAuthorities[] = [
      'pemEncodedCert' => $ca,
      'sha1Fingerprint' => static::fingerprint($ca),
    ];
    return $this;
  }
  public function customCert($cert) {
    $this->customCertificates[] = [
      'pemEncodedCert' => $cert,
      'sha1Fingerprint' => static::fingerprint($cert),
    ];
    return $this;
  }
  protected static function fingerprint($cert) {
    $cert = preg_replace('/^.*-----BEGIN CERTIFICATE-----\s*/', '', $cert);
    $cert = preg_replace('/\s*-----END CERTIFICATE-----.*$/', '', $cert);
    $cert = base64_decode($cert);
    return sha1($cert);
  }
  public function export($options = []) {
    $options['hostname'] = $this->hostname;
    $options['forwardHostHeader'] = $this->forwardHostHeader;
    if ($this->forwardHostHeader === 'CUSTOM') {
      $options['customForwardHostHeader'] = $this->customForwardHostHeader;
    }
    $options['cacheKeyHostname'] = $this->cacheKeyHostname;
    $options['compress'] = $this->compress;
    $options['originSni'] = $this->originSni;
    $options['enableTrueClientIp'] = $this->enableTrueClientIp;
    $options['verificationMode'] = $this->verificationMode;
    $options['customValidCnValues'] = $this->customValidCnValues;
    $options['originCertsToHonor'] = $this->originCertsToHonor;
    $options['standardCertificateAuthorities'] = $this->standardCertificateAuthorities;
    $options['customCertificateAuthorities'] = $this->customCertificateAuthorities;
    $options['customCertificates'] = $this->customCertificates;
    $options['httpPort'] = 80;
    $options['httpsPort'] = 443;
    return parent::export($options);
  }
}
