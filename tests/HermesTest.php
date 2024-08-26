<?php
use Johnoye742\PhpHermes\Hermes;
use PHPUnit\Framework\TestCase;

class HermesTest extends TestCase {
  public function testClassConstructor() {
    $hermes = new Hermes("127.0.0.1", 2907);
    for($i = 0; $i < 10000; $i++) {
      $hermes -> set("key$i", "value$i");
      
      $this ->assertTrue($hermes -> get("key$i"), false);
    }
    

  }
}
