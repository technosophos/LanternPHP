<?php
/**
 * Parse a filter and prepare it for Mongo queries.
 */
 
/**
 * Parse a filter.
 * This parses a filter into something that MongoDB understands.
 */
class LanternParseFilter extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Parses a filter into an array for MongoDB.')
      ->usesParam('query', 'The query to be parsed into a filter')
      ->withFilter('string')
      ->usesParam('defaultAttr', 'The default attribute to match.')
      ->withFilter('string')
      ->usesParam('inputFormat', 'The format of the input data; one of text, json, serial. You are strongly encouraged to use JSON.')
      ->withFilter('string')
      ->whichUsesDefault('json')
      ->andReturns('An associative array fit for Mongo::find()')
    ;
  }
  
  public function doCommand() {
    $inputFormat = $this->param('inputFormat', 'text');
    $defaultAttr = $this->param('defaultAttr', NULL);
    $query = $this->param('query', '');
    
    switch ($inputFormat) {
      case 'json':
        return json_decode($query);
      case 'serial':
        return unserialize($query);
      case 'text':
      default:
        return $this->parseQuery($query);
    }
  }
  
  /**
   * Parse a very simple name/value list.
   *
   * Format:
   * name: value, name: value
   */
  public function parseQuery($query) {
    $nvPairs = explode(',', $query);
    $params = array();
    foreach ($nvPairs as $pair) {
      list($name,$value,) = explode(':', $pair);
      $params[$name] = $value;
    }
    
    return $params;
  }
  
}