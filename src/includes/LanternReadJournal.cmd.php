<?php
/**
 * Command for reading a journal entry.
 */

/**
 * 
 */
class LanternReadJournal extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Reads a journal entry.')
      ->usesParam('entryId', 'The ID of the entry to retrieve.')
      ->withFilter('string')
      ->whichIsRequired()
      ->andReturns('An associative array with the journal entry.')
    ;
  }
  
  
  public function doCommand() {
    $id = $this->param('entryId');
    return $this->db()->journal->findOne(array('_id' => new MongoId($id)));
  }
}