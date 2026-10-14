<?php

namespace Akamai;

class AnyRule {
  protected $name = null;
  protected $behaviors = [];
  protected $children = [];
  protected $comments = null;
  protected function name($name) {
    $this->name = $name;
    return $this;
  }
  public function behaviors($behaviors) {
    if (!is_array($behaviors)) $behaviors = func_get_args();
    foreach ($behaviors as $behavior) {
      if (!$behavior instanceof Behaviors\Behavior) {
        throw new \Exception('Not a behavior');
      }
    }
    $this->behaviors = $behaviors;
    return $this;
  }
  public function children($children) {
    if (!is_array($children)) $children = func_get_args();
    foreach ($children as $child) {
      if (!$child instanceof Rule) {
        throw new \Exception('Not a rule');
      }
    }
    $this->children = $children;
    return $this;
  }
  public function comments($comments) {
    $this->comments = $comments;
    return $this;
  }
  public function __construct($name) {
    $this->name($name);
  }
  public function export() {
    $result = [];
    $result['name'] = $this->name;
    $behaviors = [];
    foreach ($this->behaviors as $behavior) $behaviors[] = $behavior->export();
    $result['behaviors'] = $behaviors;
    $children = [];
    foreach ($this->children as $child) $children[] = $child->export();
    $result['children'] = $children;
    if (isset($this->comments)) $result['comments'] = $this->comments;
    return $result;
  }
}
