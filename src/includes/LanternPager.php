<?php
/**
 * Create a pager.
 */

/**
 * Set offset and limit on a cursor.
 * This command takes a {@link MongoCursor}, like the one returned from 
 * {@link LanternFind}, and sets an offset and limit on it. It also 
 * places variables into the context that can be used to create a pager.
 */
class LanternPager extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Limit the number of items returned. Optionally skip some (as an offset).')
      ->usesParam('cursor', 'The cursor to modify. Often, cursor comes from LanternFind.')
      ->whichIsRequired()
      ->usesParam('limit', 'The limit on the number to display. (0 means no limit.)')
      ->whichHasDefault(0)
      ->withFilter('int')
      ->usesParam('skip', 'The number for records to skip before starting the count.')
      ->whichHasDefault(0)
      ->withFilter('int')
      ->andReturns('Nothing. The cursor is modified in place.')
    ;
  }
  
  public function doCommand() {
    $cursor = $this->param('cursor');
    $skip = $this->param('skip');
    $limit = $this->param('limit');
    
    if ($skip > 0) {
      $cursor->skip($skip);
    }
    if ($limit > 0) {
      $cursor->limit($limit);
    }
    
  }
  
}