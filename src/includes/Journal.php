<?php
/**
 * Describes a Journal content type.
 */
 
/**
 * Describes a Journal content type.
 */
class Journal implements LanternDataType {
  
  public function defaultFields() {
    return array(
      'title' => '',
      'tags' => array(),
      'entry' => '',
      'entry_raw' => 'default',
      'entry_format' => 'Markdown',
      'entryId' => 0,
      'createdOn' => '',
      'modifiedOn' => '',
      'createdBy' => 1,
      'locked' => 0,
    );
  }
  
  public function validateEntry($entry) {
    return;
  }
  
}