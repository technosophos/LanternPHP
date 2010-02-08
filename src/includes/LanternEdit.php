<?php
/**
 * Handles editing a lantern entry.
 */
 
/**
 * Handle editing of a single lantern entry.
 *
 * Subclasses can make this specific enough for a particular data type.
 */
class LanternEdit extends BaseLanternCommand {
  
  protected $dataType = NULL;
  
  public function expects() {
    return $this
      ->description('Prepares a lantern entry to be edited or created.')
      ->usesParam('entryId', 'The ID of the entry to edit. If empty or 0, then a new entry is created.')
      ->withFilter('string')
      ->whichHasDefault(0)
      
      ->usesParam('lanternType', 'The type of document that should be retrieved. By default, no type is set.')
      ->withFilter('string')
      
      ->andReturns('An array of values to be placed into the editor.')
    ;
  }
  
  public function doCommand() {
    $id = $this->param('entryId');
    $type = $this->param('lanternType', NULL);
    
    $this->dataType = new $type();
    if (!($this->dataType instanceof LanternDataType)) {
      throw new FortissimoInterrupException('Unsupported Data Type: Not the right kind of class.');
    }
    
    if (empty($id)) {
      $retval = $this->initializeNewEntry();
    }
    else {
      $filter = array(
        '_id' => new MongoID($id),
      );

      if (isset($type)) {
        $filter['lanternType'] = $type;
      }
      
      $retval = $this->retrieveEntry($filter);
    }
    
    return $retval;
  }
  
  public function initializeNewEntry() {
    return $this->dataType->defaultFields();
  }
  
  public function retrieveEntry($filter) {
    
    // Auto-update entries so that they always have
    // all possible fields.
    $empty = $this->initializeNewEntry();
    
    // Get the existing entry.
    $entry = $this->loadEntry($filter);
    
    if (empty($entry)) {
      throw new FortissimoException('The requested record was not found.');
    }
    
    //$entry = array_merge_recursive($empty, $entry);
    $entry += $empty;
    return $entry;
  }
}