<?php
declare(strict_types=1);

namespace App;

class View
{
  public function render(string $page, array $params = []): void
  {
    $params = $this->escData($params);
    require_once("templates/layout.php");
  }

  private function escData(array $params): array
  {
    $valuesBox = [];

    foreach ($params as $key => $value) {
      if (is_array($value)) {
        
        $valuesBox[$key] = $this->escData($value);
      } else if ($value) {
        $valuesBox[$key] = htmlentities(($value.''));
      } else {
        $valuesBox[$key] = $value;
      }
    }

    return $valuesBox;
  }
}
