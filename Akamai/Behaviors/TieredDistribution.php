<?php

namespace Akamai\Behaviors;

class TieredDistribution extends Enabled {
  protected $tieredDistributionMap = 'CH2';
  public function __construct($enabled) {
    parent::__construct('tieredDistribution', $enabled);
  }
  public function map($map) {
    validate([
      'type' => 'enum',
      'enum' => ['CH2', 'CHAPAC', 'CHEU2', 'CHEUS2', 'CHCUS2', 'CHWUS2', 'CHAUS', 'CH'],
    ], $map);
    $this->tieredDistributionMap = $map;
    return $this;
  }
  public function globe() {
    $this->map('CH2');
  }
  public function asiaPacific() {
    $this->map('CHAPAC');
  }
  public function europe() {
    $this->map('CHEU2');
  }
  public function eastUS() {
    $this->map('CHEUS2');
  }
  public function centralUS() {
    $this->map('CHCUS2');
  }
  public function westUS() {
    $this->map('CHWUS2');
  }
  public function export($options = []) {
    if ($this->tieredDistributionMap != 'CH2') $options['tieredDistributionMap'] = $this->tieredDistributionMap;
    return parent::export($options);
  }
}
