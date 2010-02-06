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

$bc = TPL::breadcrumbs(array(
  Util::url('default') => 'Lantern',
  Util::url('journals') => 'Journal',
  Util::url('read-journal', array('entryId' => (string)$_id)) => $title,
));
print $bc;
?>
<div class="journal-entry">
  <h1 class="journal-entry-title"><?php print $title; ?></h1>
  <div class="journal-entry-body"><?php print $entry; ?></div>
  <div class="journal-tags"><?php implode($tags); ?></div>
  <table class="metadata">
    <tr>
      <th>Created on</th>
      <td><?php print date(TPL::longDateTime, $createdOn); ?></td>
    </tr>
    <tr>
      <th>Modified on</th>
      <td><?php print date(TPL::longDateTime, $modifiedOn); ?></td>
    </tr>
    <tr>
      <th>Entry ID</th>
      <td><?php print $_id; ?></td>
    </tr>
  </table>
</div>

