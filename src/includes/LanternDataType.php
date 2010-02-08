<?php
/**
 * The base interface for all data types.
 */

interface LanternDataType {
  
  public function defaultFields();
  
  public function validateEntry($entry);
  
}