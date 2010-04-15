<?php
/**
 * Import an RIS file or string.
 */

/**
 * The RIS parser.
 */
require 'lib/LibRIS';

/**
 * Import RIS data into Lantern.
 */
class LanternRISImport extends BaseLanternCommand {
  public function expects() {
    return $this
      ->description('Imports an RIS string.')
      ->usesParam('ris', 'The RIS data as a string.')
      ->withFilter('callback', array('option' => array($this, 'parseRIS')))
      ->andReturns('An associative array of data, with RIS fields transformed using the LanternRISMap.')
    ;
  }
  
  /**
   * Filter function for parsing RIS data.
   */
  public function parseRIS($input) {
    $parser = new LibRIS();
    try {
      $data = $parser->parseString($input);
    }
    catch (Exception $e) {
      return FALSE;
    }
    return $data;
  }
  
  public function doCommand() {
    $records = $this->param('ris', array());
    $convertedRecords = $this->convertRecords($records);
    $saved = array();
    foreach ($convertedRecords as $record) {
      $this->saveRecord($record);
      if (isset($record['_id'])) {
        $saved[(string)$record['_id']] = $record['title'];
      }
    }
    return $saved;
  }
  
  public function saveRecord(&$record) {
    $record['modifiedOn'] = new MongoDate(FORTISSIMO_REQ_TIME);
    $record['createdOn'] = new MongoDate(FORTISSIMO_REQ_TIME);
    $record['lanternType'] = self::TYPE_SOURCE;
    $record['title'] = LanternRISMap::getBestTitle($record);
    
    $this->collection()->insert($record);
  }
  
  /**
   * Convert records from RIS to Lantern format.
   *
   * This will return data in the following format:
   * 
   * Indexed array of records, where each record is an associative array of 
   * entry names and values.
   *
   * Ideally, any data returned from this should be suitable for a 
   * MongoDB save() operation.
   *
   * @param array $records
   *  An indexed array containing associative arrays of RIS data.
   * @return array 
   *  An indexed array containing associative arrays of Lantern data.
   */
  public function convertRecords($records) {
    $transform = array();
    
    // $source is an indexed array of 
    foreach ($records as $record) {
      $revisedRecord = array();
      foreach ($record as $risKey => $value) {
        $lKey = LanternRISMap::getLanternName($risKey);
        if (!empty($lKey)) {
          // Compress values.
          if (count($value) == 1) {
            $value = $value[0];
          }
          $revisedRecord[$lKey] = $value;
        }
      }
      $transform[] = $revisedRecord;
    }
    return $transform;    
  }
}