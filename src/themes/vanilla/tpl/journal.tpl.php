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
LanternRenderMainHTML::setTitle($title);
LanternRenderMainHTML::AddBodyClass('journal-entry-page');
?>
<div class="journal-entry">
  <h1 class="journal-entry-title"><?php print $title; ?></h1>
  <div class="journal-created-on journal-date">Created on: <?php print date('r', $createdOn); ?></div>
  <div class="journal-modified-on journal-date">Last modified on: <?php print date('r', $modifiedOn); ?></div>
  <div class="journal-entry-body"><?php print $entry; ?></div>
  <div class="journal-tags"><?php implode($tags); ?></div>
  <div class="journal-id">(<?php print $_id; ?>)</div>
</div>

