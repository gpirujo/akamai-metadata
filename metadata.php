<?php

array_shift($argv); // myself

$command = array_shift($argv);
if ($command === 'alias') {

  $name = array_shift($argv);
  printf("alias %s='%s %s'\n", $name, $_SERVER['_'], __FILE__);

} else if (in_array($command, ['hostnames', 'rules'])) {

  spl_autoload_register(function($classname) {
    $filename = __DIR__ . '/' . str_replace('\\', '/', $classname) . '.php';
    if (realpath($filename)) {
      require_once($filename);
    } else {
      throw new Exception(sprintf('File %s for class %s not found', $filename, $classname));
    }
  });

  require_once(__DIR__ . '/Akamai/functions.php');

  $file = array_shift($argv);
  $config = require_once($file);

  function json($php) {
    printf("%s\n", json_encode($php, JSON_PRETTY_PRINT));
  }

  if ($command === 'hostnames') {
    json($config->exportHostnames());
  } else if ($command === 'rules') {
    json($config->exportRules());
  }

} else {
  echo "Usage: php " . pathinfo(__FILE__, PATHINFO_BASENAME) . " hostnames|rules <configuration>\n";
}
