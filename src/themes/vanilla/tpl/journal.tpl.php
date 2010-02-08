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
<form action="<?php Util::url('edit-journal'); ?>" method="GET" class="utility-form">
  <input type="submit" name="create_entry" value="Edit" id="create_entry">
  <input type="hidden" name="ff" value="edit-journal">
  <input type="hidden" name="entryId" value="<?php print (string)$_id; ?>"/>
</form>
<div class="journal-entry">
  <h1 class="journal-entry-title"><?php print $title; ?></h1>
  <div class="journal-entry-body"><?php print $entry; ?></div>
  <div class="journal-tags"><?php print TPL::tags($tags); ?></div>
  <table class="metadata">
    <tr>
      <th>Created on</th>
      <td><?php print date(TPL::longDateTime, $createdOn->sec); ?></td>
    </tr>
    <tr>
      <th>Modified on</th>
      <td><?php print date(TPL::longDateTime, $modifiedOn->sec); ?></td>
    </tr>
    <tr>
      <th>Entry ID</th>
      <td><?php print $_id; ?></td>
    </tr>
  </table>
</div>

