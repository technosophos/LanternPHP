<?php
/**
 * Journal template.
 *
 * Expects variables:
 * - title
 * - entry
 * - author
 * - createdOn
 * - modifiedOn
 * - tags
 */
?>
<div class="journal-entry">
  <h1 class="journal-entry-title"><?php print $title; ?></h1>
  <div class="journal-created-on journal-date">Created on: <?php print $createdOn; ?></div>
  <div class="journal-modified-on journal-date">Last modified on: <?php print $modifiedOn; ?></div>
  <div class="journal-entry-body"><?php print $entry; ?></div>
  <div class="journal-tags"><?php implode($tags); ?></div>
</div>

