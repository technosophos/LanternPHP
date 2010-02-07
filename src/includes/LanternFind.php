<?php
/**
 * Execute a find operation against a collection in MongoDB.
 */

/**
 * Describe and execute a find operation.
 * This will perform a {@link MongoCollection::find()} operation against
 * a collection, and then push the results into the context.
 *
 * While this class stands on its own, you may also prefer to use it as a 
 * base for other classes.
 */
class LanternFind extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Search a Mongo collection and store the results in the context.')
      ->usesParam('collection', 'The name of the collection. If not specified, default is used.')
      ->withFilter('string')
      ->usesParam('filter', 'A JSON-formatted filter. See the mongodb.org documentation.')
      //->withFilter('callback', array('options' => 'json_decode'))
      ->withFilter('callback', array('options' => array($this, 'parseFilter')))
      ->whichHasDefault('{}')
      ->usesParam('fields', 'A comma-separated list of fields. If none is specified, all fields will be returned.')
      ->withFilter('string')
      ->andReturns('A MongoCursor object. Note that the query is not run until the cursor is traversed, so you can still sort or limit.')
    ;
  }
  
  public function parseFilter($data) {
    return json_decode($data, TRUE);
  }
  
  public function doCommand() {
    $filter = $this->param('filter');
    $fields = explode(',', $this->param('fields', NULL));
    $collection =  $this->param('collection', NULL);
    
    $c = empty($collection) ? $this->collection() : $this->db()->$collection;
    
    if (empty($filter)) {
      return $c->find();
    }
    
    // It is undocumented what is returned when $fields is empty.
    return (empty($fields) || empty($fields[0])) 
      ? $c->find($filter) 
      : $c->find($filter, $fields); 
  }
  
}