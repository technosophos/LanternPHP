<?php
/**
 * Output contents to STDOUT (the browser, presumably).
 */
 
 
/**
 * Flush buffered content into the output stream.
 *
 * In lantern, rendering is separate from outputting. A rendering agent is responsible
 * for taking data and formatting it for display. An output agent is responsible
 * for sending the content to the client.
 *
 * <b>Why is this needed?</b>
 * The goal of structuring the output system in this way is twofold:
 *  * First, it makes it possible to fully-render content, then post-process it
 *    before sending it. 
 *  * Second, it makes it possible to easily direct rendered output to another 
 *    location, such as a flat file, a cache, or a database.
 *
 * To send output directly to the Standard Output, use this class. You can replace
 * this command with any custom output class, should you so choose. So, for example,
 * you could write a caching output buffer that might be paired with a cache interceptor
 * command.
 * @see LanternRender The main rendering class.
 */
class LanternOutput extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Send the contents of the given buffer(s) to STD OUT.')
      ->usesParam('buffer', 'The buffer to send to Standard Out')
      //->withFilter('string') // FIXME: Needs to allow HTML.
      ;
  }
  
  public function doCommand() {
    $buffer = $this->param('buffer', '');
    
    print $buffer;
  }
  
}