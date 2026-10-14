<?php

namespace Akamai\Match;

class IsEmpty extends Match {
  public function __construct($positive) {
    parent::__construct($positive ? 'IS_EMPTY' : 'IS_NOT_EMPTY');
  }
}
