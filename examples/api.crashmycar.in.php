<?php

#"contractId": "ctr_1-ABC123",
#"groupId": "grp_11111",
#"propertyId": "prp_333333",

require 'common.php';

return configuration()
#->comments()
->hostnames([
  'api.crashmycar.in' => 'crashmycar.in.edgekey.net',
  'api-staging.crashmycar.in' => 'crashmycar.in.edgekey.net',
])
->rules(
  defaultRule()->isSecure(true)
  ->behaviors([
    managedOrigin('api-example-1234567890.us-east-1.elb.amazonaws.com'),
    cpCode(123456),
    allowPost(),
  ])
  ->children([

    rule('Staging')
    ->criteria([
      hostname()->isOneOf(['api-staging.crashmycar.in']),
    ])
    ->behaviors([
      managedOrigin('staging-example-0987654321.us-east-1.elb.amazonaws.com'),
    ]),

    ruleCaching(),
    #redirectToHttps(),
    ruleHttp2(),
    ruleContentCompression(),
  ])
);
