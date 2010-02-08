<?php
/**
 * Edit a journal entry.
 */
 
 //if (!empty($body)) print $body;
//LanternRenderMainHTML::setTitle($title);
?>
<form action="<?php print Util::url('save-journal')?>" method="POST" class="edit-journal-wrapper">
  <div class="edit-journal-title-wrapper">
    <label>Title</label>
    <input type="text" size="40" name="title" class="input-title" 
      value="<?php print $title; ?>"/>
  </div>
  <div class="edit-journal-entry-wrapper">
    <label>Entry</label>
    <textarea name="entry" cols="80" rows="30"><?php print_r($entry_raw); ?></textarea>
    <p class="help">The text of the entry. <a 
    href="http://michelf.com/projects/php-markdown/concepts/">markdown</a> 
    formatting can be used, along with certain <a 
    href="http://michelf.com/projects/php-markdown/extra/">extras</a>.</p>
  </div>
  <div class="edit-journal-tags-wrapper">
    <label>Tags</label>
    <input type="text" size="60" name="tags" 
      value="<?php print implode(', ', $tags); ?>"/>
    <p class="help">A comma-separated list of tags relating to this journal.</p>
  </div>
  <div class="edit-journal-submit-wrapper">
    <input type="hidden" name="entryId" value="<?php print (string)$_id; ?>" 
      id="entryId"/>
    <input type="submit" value="Save"/>
  </div>
</form>