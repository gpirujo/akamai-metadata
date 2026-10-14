<?php

function managedOrigin($hostname, $incoming = true) {
  $origin = customerOrigin($hostname)
  ->cacheKeyIncomingHostname()
  ->compress()
  ->sni()
  ->customCNValues(['{{Forward Host Header}}', '{{Origin Hostname}}'])
  ->standardCA()
  ->customCA(file_get_contents('managed-cdn.pem'));
  if ($incoming) {
    $origin->forwardHostHeaderIncomingHostname();
  } else {
    $origin->forwardHostHeaderOriginHostname();
  }
  return $origin;
}

function ruleCaching() {
  return rule('Caching')
  ->behaviors([
    tieredDistribution(),
    caching()->honorCacheControl()->mustRevalidate(),
    cacheKeyQueryParams()->sort(),
    downstreamCache()->allowLesser(),
    removeVary(),
    validateEntityTag(),
  ]);
}

function ruleRedirectToHttps() {
  return rule('Redirect to HTTPS')
  ->criteria([
    requestProtocol()->isHttp(),
  ])
  ->behaviors([
    redirect(301)->https(),
  ]);
}

function ruleHttp2() {
  return rule('Enable HTTP2')
  ->criteria([
    hostname()->isOneOf(['*']),
  ])
  ->behaviors([
    http2(),
    allowTransferEncoding(),
  ]);
}

function ruleContentCompression() {
  return rule('Content Compression')
  ->criteria([
    contentType()->isOneOf([
      'application/javascript',
      'application/json',
      'application/rss+xml',
      'application/x-javascript',
      'application/x-json',
      'application/xml',
      'text/css',
      'text/html',
      'text/plain',
      'text/xml',
    ]),
  ])
  ->behaviors([
    gzipResponse()->always(),
  ]);
}
