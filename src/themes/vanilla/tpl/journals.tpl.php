<?php
/**
 * Takes a list of journal entries and prints them into a list.
 *
 * $journals - a Traversable or array of journal entries.
 */
?>
<div class="journal-list">
  <form action="<?php Util::url('edit-journal'); ?>" method="GET" class="utility-form">
    <input type="submit" name="create_entry" value="New Entry" id="create_entry">
    <input type="hidden" name="ff" value="edit-journal">
  </form>
  
  <h3>Found <?php print TPL::plural($journals->count(), '%d entry', ' %d entries');?></h3>
  <table>
  <tbody>
    <tr>
      <th>Title</th>
      <th>Date</th>
      <th>Tags</th>
    </tr>
    <?php
    $i = 0;
    foreach ($journals as $entry) {
      $stripe = ($i++ % 2) == 0 ? 'even' : 'odd';
      $url = Util::url('read-journal', array('entryId' => (string)$entry['_id']));
      ?>
    <tr class="<?php print $stripe; ?>">
      <td>
        <a href="<?php print $url; ?>"><?php print $entry['title']; ?></a>
        <p class="preview"><?php print TPL::snip($entry['entry'], 80); ?></p>
      </td>
      <td><?php print date(TPL::shortDate, $entry['modifiedOn']->sec); ?></td>
      <td><?php print TPL::tags($entry['tags']); ?></td>
      <!--
      <td><a href="">edit</a></td>
      -->
    </tr>
      <?php
    }
    ?>
  </tbody>
  </table>
</div>