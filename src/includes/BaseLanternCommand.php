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
  
  const TYPE_UNKNOWN = 'unknown';
  const TYPE_NOTE = 'note';
  const TYPE_SOURCE = 'source';
  const TYPE_JOURNAL = 'journal';
  
  /**
   * User-defined types should use this type, and
   * should set a subtype for additional specification.
   */
  const TYPE_USER_DEFINED = 'user_defined';
  
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
  
  protected function collection($name = NULL) {
    
    // Get the default collection.
    if (empty($name)) {
      $name = $this->context->get('collection', NULL);
      if (empty($name)) {
        throw new FortissimoInterruptException('No default collection has been specified.');
      }
    }
    
    // Look up the named colleciton.
    $collection = $this->db()->selectCollection($name);
    if (!is_object($collection)) {
      throw new FortissimoInterruptException(
        sprintf('The named collection "%s" could not be found.', htmlentities($name))
      );
    }
    return $collection;
  }
  
  protected function basePath() {
    global $base;
    return $base;
  }
  
  protected function baseUri() {
    return $_SERVER['PHP_SELF'];
  }
  
  protected function explodeTags($string) {
    return array_map('trim', explode(',', $string));
  }
  
}