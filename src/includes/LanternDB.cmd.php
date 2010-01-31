<?php
/**
 * Main lantern database.
 */
 
class LanternDB extends BaseFortissimoCommand {
  public function expects() {
    return $this
      ->description('Connect to a MongoDB database and store connection in context.')
      ->usesParam('server', 'The database server URL. If none is specified, connection is made to localhost.')
      ->withFilter('string')
      //->usesParam('database', 'The database. If none is specified, the default (test) is used.')
      //->withFilter('string')
      //->usesParam('user', 'The user name. If none is specified, none is used.')
      //->withFilter('string')
      //->usesParam('password', 'The user password. If none is specified, none is used.')
      //->withFilter('string')
      ->andReturns('A Mongo object.');
  }
  
  public function doCommand() {
    $server = $this->param('server', 'mongodb://localhost:27017');
    $mongo = new Mongo($server);
    return $mongo;
  }
}