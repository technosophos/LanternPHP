<?php
/**
 * Select the appropriate database.
 */
 
class LanternSelectDB extends BaseFortissimoCommand {
  public function expects() {
    return $this
      ->description('Connect to a MongoDB database and store connection in context.')
      ->usesParam('databaseName', 'The database name.')
      ->whichIsRequired()
      ->withFilter('string')
      ->usesParam('databaseConnection', 'A Mongo object with an open connection')
      ->whichIsRequired()
      ->andReturns('A MongoDB object.');
  }
  
  public function doCommand() {
    $server = $this->param('databaseConnection');
    $name = $this->param('databaseName');
    $db = $server->selectDB($name);
    return $db;
  }
}
