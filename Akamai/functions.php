<?php

function validate($field, $value) {
  $type = $field['type'];
  if ($type === 'string') {
    return $value;
  } else if ($type === 'number') {
    if (is_numeric($value)) {
      if (isset($field['minimum']) && $value < $field['minimum']) {
        throw new Exception(sprintf('Value %d is too low, minimum is %d', $value, $field['minimum']));
      }
      if (isset($field['maximum']) && $value > $field['maximum']) {
        throw new Exception(sprintf('Value %d is too high, maximum is %d', $value, $field['maximum']));
      }
      return $value;
    } else {
      throw new Exception(sprintf('Value %s is not a number', $value));
    }
  } else if ($type === 'boolean') {
    if (is_bool($value)) {
      return $value;
    } else if (is_string($value) && in_array(strtolower($value), ['true', 'false'])) {
      return strtolower($value) === 'true';
    } else {
      throw new Exception(sprintf('Value %s is neither true or false', $value));
    }
  } else if ($type === 'array') {
    if (is_array($value)) {
      return $value; #FIXME
    } else {
      throw new Exception(sprintf('Value %s is not an array', $value));
    }
  } else if ($type === 'object') {
    if (is_array($value)) {
      return $value; #FIXME
    } else {
      throw new Exception(sprintf('Value %s is not an object', $value));
    }
  } else if ($type === 'enum') {
    $enum = $field['enum'];
    foreach ($enum as $element) {
      if (is_string($element)) {
        if (strtolower($value) === strtolower($element)) {
          return $element;
        }
      } else if (is_integer($element)) {
        if (intval($value) === $element) {
          return $element;
        }
      }
    }
    throw new Exception(sprintf('Value %s is not one of %s', $value, json_encode($enum)));
  } else {
    var_dump($field);
  }
}

function builtin() {
  static $builtin;
  if (!isset($builtin)) $builtin = new Akamai\BuiltinVars();
  return $builtin;
}

function user($name) {
  return sprintf('{{user.%s}}', strtoupper(sprintf('pmuser_%s', $name)));
}

function configuration() {
  return new Akamai\Configuration();
}

function defaultRule() {
  return new Akamai\DefaultRule();
}

function rule($name) {
  return new Akamai\Rule($name);
}

function cpCode($id) {
  return new Akamai\Behaviors\CPCode($id);
}

function gzipResponse() {
  return new Akamai\Behaviors\GzipResponse();
}

function edgeScape($enabled = true) {
  return new Akamai\Behaviors\EdgeScape($enabled);
}

function allowPost($enabled = true) {
  return new Akamai\Behaviors\AllowPost($enabled);
}

function allowPut($enabled = true) {
  return new Akamai\Behaviors\AllowPut($enabled);
}

function allowPatch($enabled = true) {
  return new Akamai\Behaviors\AllowPatch($enabled);
}

function allowDelete($enabled = true) {
  return new Akamai\Behaviors\AllowDelete($enabled);
}

function allowAllMethods($enabled = true) {
  return new Akamai\Behaviors\AllowAllMethods($enabled);
}

function allowTransferEncoding($enabled = true) {
  return new Akamai\Behaviors\AllowTransferEncoding($enabled);
}

function tieredDistribution($enabled = true) {
  return new Akamai\Behaviors\TieredDistribution($enabled);
}

function removeVary() {
  return new Akamai\Behaviors\RemoveVary();
}

function validateEntityTag() {
  return new Akamai\Behaviors\ValidateEntityTag();
}

function rewriteUrl() {
  return new Akamai\Behaviors\RewriteUrl();
}

function modifyOutgoingResponseHeader() {
  return new Akamai\Behaviors\ModifyOutgoingResponseHeader();
}

function downstreamCache() {
  return new Akamai\Behaviors\DownstreamCache();
}

function cacheKeyQueryParams() {
  return new Akamai\Behaviors\CacheKeyQueryParams();
}

function caching() {
  return new Akamai\Behaviors\Caching();
}

function http2() {
  return new Akamai\Behaviors\HTTP2();
}

function redirect($responseCode) {
  return new Akamai\Behaviors\Redirect($responseCode);
}

function baseDirectory($directory) {
  return new Akamai\Behaviors\BaseDirectory($directory);
}

function constructResponse($responseCode, $body) {
  return new Akamai\Behaviors\ConstructResponse($responseCode, $body);
}

function setVariable($variableName) {
  return new Akamai\Behaviors\SetVariable($variableName);
}

function customerOrigin($hostname) {
  return new Akamai\Behaviors\CustomerOrigin($hostname);
}

function requestHeader($headerName) {
  return new Akamai\Criteria\RequestHeader($headerName);
}

function requestProtocol() {
  return new Akamai\Criteria\RequestProtocol();
}

function variable($variableName) {
  return new Akamai\Criteria\MatchVariable($variableName);
}

function contentType() {
  return new Akamai\Criteria\ContentType();
}

function hostname() {
  return new Akamai\Criteria\Hostname();
}
