<?php
/**
 * Command for reading an entry.
 */

/**
 * Read a single entry from the database.
 */
class LanternRead extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Reads a lantern entry.')
      ->usesParam('entryId', 'The ID of the entry to retrieve.')
      ->withFilter('string')
      ->whichIsRequired()
      
      ->usesParam('lanternType', 'The type of document that should be retrieved. By default, no type is set (only entryId is used).')
      ->withFilter('string')
      
      ->andReturns('An associative array with the lantern entry.')
    ;
  }
  
  
  public function doCommand() {
    $id = $this->param('entryId');
    $type = $this->param('lanternType', NULL);
    
    $filter = array(
      '_id' => new MongoId($id),
    );
    
    if (!empty($type)) $filter['lanternType'] = $type;
    
    return $this->loadEntry($filter);
  }
}