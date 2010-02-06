<?php
/**
 * Command for adding variables to context.
 */
 
/**
 * Command to add variables to the context.
 *
 * Takes all param name/value pairs and dumps them into the context.
 */
class LanternAddToContext implements FortissimoCommand, Explainable {
  
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }
  
  public function execute($paramArray, FortissimoExecutionContext $cxt) {
    foreach ($paramArray as $key => $value) {
      $cxt->add($key, $value);
    } 
  }
  
  public function explain() {
    $out = 'CMD: %s (%s): %s' . PHP_EOL . PHP_EOL;
    $msg = 'Takes each param and stores it in the context for later use with cxt:NAME or $context->get().';
    
    return sprintf($out, $this->name, __CLASS__, $msg);
  }
}