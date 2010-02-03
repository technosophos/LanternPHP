<?php
/**
 * An abstract base command specific to Lantern.
 *
 * This provides some utility methods for LanternNotes commands.
 */

/**
 * Base class for Lantern commands.
 */
abstract class BaseLanternCommand extends BaseFortissimoCommand {
  
  /**
   * @var array
   * Convenience filter array definition to provide HTML filtering. Causes a
   * callback filter to execute {@link Util::filterHTML()}.
   */
  protected $filterHTML = array('options' => array('Util', 'filterHTML'));

  /**
   * Get the current Mongo database (not the connection).
   *
   * A convenience method to access the MongoDB instance. The database is fetched
   * out of the context, where it is assumed that an object named 'db' exists,
   * and is a valid database instance.
   *
   * Technically, no class check is done, so one could return some other object
   * that merely conforms to the public interface for a MongoDB object. In other
   * words, one should be able to easily mock a MongoDB returned from this.
   *
   * @return MongoDB
   *  A handle to the currently active MongoDB database.
   */
  protected function db() {
    $db = $this->context->get('db', NULL);
    
    if (!is_object($db)) {
      throw new FortissimoInterruptException('A database connection does not exist.');
    }
    
    return $db;
  }
  
  protected function basePath() {
    global $base;
    return $base;
  }
  
  protected function baseUri() {
    return $_SERVER['PHP_SELF'];
  }
  
}