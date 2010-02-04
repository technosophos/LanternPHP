<?php
/**
 * Command for adding variables to context.
 */
 
/**
 * Command to add variables to the context.
 *
 * Takes all param name/value pairs and dumps them into the context.
 */
class LanternAddToContext implements FortissimoCommand {
  
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }
  
  public function execute($paramArray, FortissimoExecutionContext $cxt) {
    foreach ($paramArray as $key => $value) {
      $cxt->add($key, $value);
    } 
  }
}