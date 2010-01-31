<?php

class LanternInitialize extends BaseLanternCommand {
  
  
  public function expects() {
    return $this->description('Initialize the Lantern system.');
  }
  
  public function doCommand() {
    // Check if we need to force user into installer.
    if (count($this->db()->listCollections()) == 0) {
      throw new FortissimoForwardRequest('install', $this->context);
    }
  }
}