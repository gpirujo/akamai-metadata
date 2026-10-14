<?php

#"contractId": "ctr_1-ABC123",
#"groupId": "grp_11111",
#"propertyId": "prp_222222",

return configuration()
->comments('Brought in from managed-cdn-ima-etls.')
->hostnames([
  'www.oldgroup.com' => 'oldgroup.com.edgekey.net',
])
->rules(
  defaultRule()->isSecure(true)

  ->behaviors([

    # origin
    customerOrigin('live.oldgroup-website-2017.dpdk-cloud.com')
    ->forwardHostHeaderIncomingHostname()
    ->cacheKeyIncomingHostname()
    ->compress()
    ->sni()
    ->customCNValues(['{{Forward Host Header}}'])
    ->customCA(file_get_contents('managed-cdn.pem')),

    cpCode(123456),
    allowPost(),

    # caching
    tieredDistribution(),
    caching()->honorCacheControl()->mustRevalidate(),
    cacheKeyQueryParams()->sort(),
    downstreamCache()->allowLesser(),
    removeVary(),
    validateEntityTag(),

    edgeScape(),

  ])

  ->children([

    rule('Redirect to HTTPS')
    ->criteria([
      requestProtocol()->isHttp(),
    ])
    ->behaviors([
      redirect(301)->https(),
    ]),

    rule('Enable HTTP2')
    ->criteria([
      hostname()->isOneOf(['*']),
    ])
    ->behaviors([
      http2(),
      allowTransferEncoding(),
    ]),

    rule('Content Compression')
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
    ]),

  ])
);
