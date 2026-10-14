<?php

namespace Akamai;

class BuiltinVars {
  protected function name($name) {
    return sprintf('{{builtin.%s}}', strtoupper($name));
  }
  public function path() {
    return $this->name('ak_path');
  }
  public function host() {
    return $this->name('ak_host');
  }
}
