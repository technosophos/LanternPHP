<?php
/**
 * Sort a MongoCursor.
 */
 
/**
 * Support a MongoCursor.
 * Given specificity parameters, sort a mongo cursor. Since the object is 
 * modified by reference, this places nothing into the context.
 * 
 */
class LanternSort extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Sort database results by the criterion given. Results are sorted in place.')
      ->usesParam('cursor', 'The MongoCursor object (like that returned by LanternFind)')
      ->whichIsRequired()
      ->usesParam('criteria', 'A JSON object listing the keys to be sorted, and whether they are ascending (1) or descending (-1).')
      ->whichIsRequired()
      ->withFilter('callback', array('options' => array($this, 'filterCriteria')))
      ->andReturns('Nothing. Results are sorted in place.')
    ;
  }
  
  /**
   * Filter callback for parsing the list of items that should be used to sort.
   */
  public function filterCriteria($data) {
    
    if (strpos($data, '{') !== 0) {
      // This is not JSON. Assume it is a list of fields.
      $names = explode(',', $data);
      $pairs = array();
      foreach ($names as $name) {
        $pairs['name'] = 1;
      }
      return $pairs;
    }
    return json_decode($data, TRUE);
  }
  
  public function doCommand() {
    $cursor = $this->param('cursor');
    $criteria = $this->param('criteria');
    
    $cursor->sort($criteria);
  }
}
