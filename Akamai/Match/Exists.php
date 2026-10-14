<?php

namespace Akamai\Match;

class Exists extends Match {
  public function __construct($positive) {
    parent::__construct($positive ? 'EXISTS' : 'DOES_NOT_EXIST');
  }
}
