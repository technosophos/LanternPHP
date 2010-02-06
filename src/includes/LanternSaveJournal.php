<?php
/**
 * Saves a journal entry.
 */
 
class LanternSaveJournal extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Takes data from parameters and saves them as a journal entry.')
      
      ->usesParam('title', 'The title of the journal entry.')
      ->withFilter('string')
      
      ->usesParam('entry', 'The journal entry.')
      ->withFilter('callback', $this->filterHTML)
      
      ->usesParam('tags', 'A comma-separated list of tags for this entry.')
      ->withFilter('string')
      
      ->usesParam('createdOn', 'Timestamp on which this was created (default: leave alone existing date, or add today for a new item.)')
      ->withFilter('int')
      ->whichHasDefault(0)
      
      ->usesParam('modifiedOn', 'Timestamp for last modification date (default: today)')
      ->withFilter('int')
      ->whichHasDefault(FORTISSIMO_REQ_TIME)
      
      ->usesParam('createdBy', 'ID of the user creating this entry.')
      ->withFilter('string')
      
      ->usesParam('entryID', 'The ID of an entry. If this is set, the existing entry will be modified. Otherwise one will be generated.')
      ->withFilter('string')
      
      ->usesParam('insertOnFailedModify', 'If an ID is passed and the record is not found, setting this to TRUE will cause '
        .' Lantern to save the record with a new ID. Otherwise, Lantern will raise a FortissimoException.')
      ->withFilter('boolean')
      
      ->andReturns('The full record, including the auto-generated ID')
    ;
  }
  
  public function doCommand() {

    $id = $this->param('entryID', NULL);
    
    if (!empty($id)) {
      $obj = $this->modifyExistingEntry($id);
    }
    else {
      $obj = $this->saveNewEntry();
    }
    
    return $obj;
  }
  
  public function saveNewEntry() {
    
    $created = $this->param('createdOn');
    $text = $this->param('entry', '');
    $entry = array(
      'title' => $this->param('title', 'Untitled'),
      'entry' => Markdown($text),
      'entry_mdown' => $text,
      'tags' => explode(',', $this->param('tags', '')),
      'createdOn' => $created > 0 ? $created : FORTISSIMO_REQ_TIME,
      'modifiedOn' => $this->param('modifiedOn'),
      'createdBy' => $this->param('createdBy', 1),
    );
    
    // This modifies $entry by ref, and adds _id.
    $this->db()->journal->insert($entry);
    
    return $entry;
  }
  
  public function modifyExistingEntry($id) {
    $entry = $this->db()->journal->findOne(array('_id' => new MongoId($id)));
    
    if (empty($entry)) {
      if ($this->param('insertOnFailedModify', FALSE)) {
        return $this->saveNewEntry();
      }
      else {
        throw new FortissimoException(sprintf('Modifying journal with ID %s failed: No such record found.', $id));
      }
    }
    
    $text = $this->param('entry', '');
    
    $entry['title'] = $this->param('title', 'Untitled');
    $entry['entry'] = Markdown($text);
    $entry['entry_mdown'] = $text;
    $entry['tags'] = explode(',', $this->param('tags', ''));
    $entry['modifiedOn'] = $this->param('modifiedOn', FORTISSIMO_REQ_TIME);
    
    $createdOn = $this->param('createdOn');
    if (!empty($createdOn)) $entry['createdOn'] = $createdOn;
    
    $this->db()->journal->save($entry);
    
    return $entry;
  }
}