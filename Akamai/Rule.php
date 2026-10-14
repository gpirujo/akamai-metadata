<?php

namespace Akamai;

class Rule extends AnyRule {
  protected $criteria = [];
  protected $criteriaMustSatisfy = 'all';
  public function criteria($criteria) {
    if (!is_array($criteria)) $criteria = func_get_args();
    foreach ($criteria as $criterion) {
      if (!$criterion instanceof Criteria\Criterion) {
        throw new \Exception('Not a criterion');
      }
    }
    $this->criteria = $criteria;
    return $this;
  }
  public function criteriaMustSatisfy($criteriaMustSatisfy) {
    $criteriaMustSatisfy = strtolower($criteriaMustSatisfy);
    if (!in_array($criteriaMustSatisfy, ['all', 'any'])) {
      throw new \Exception('Value %s must be "all" or "any"');
    }
    $this->criteriaMustSatisfy = $criteriaMustSatisfy;
    return $this;
  }
  public function export() {
    $result = parent::export();
    $criteria = [];
    foreach ($this->criteria as $criterion) $criteria[] = $criterion->export();
    $result['criteria'] = $criteria;
    $result['criteriaMustSatisfy'] = $this->criteriaMustSatisfy;
    return $result;
  }
}
