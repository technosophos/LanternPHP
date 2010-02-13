<?php
/**
 * Takes a list of journal entries and prints them into a list.
 *
 * $recent - a Traversable or array of recent items.
 */
?>
<div class="home-list">
  <h3>Recent Activity</h3>
  <table>
  <tbody>
    <tr>
      <th>Type</th>
      <th>Title</th>
      <th>Date</th>
      <th>Tags</th>
    </tr>
    <?php
    $i = 0;
    foreach ($recent as $item) {
      $stripe = ($i++ % 2) == 0 ? 'even' : 'odd';
      $url = Util::url('read-' . strtolower($item['lanternType']), array('entryId' => (string)$item['_id']));
      ?>
    <tr class="<?php print $stripe; ?>">
      <td><?php print ucfirst($item['lanternType']); ?></td>
      <td>
        <a href="<?php print $url; ?>"><?php print $item['title']; ?></a>
        <p class="preview"><?php //print TPL::snip($item['item'], 80); ?></p>
      </td>
      <td><?php print date(TPL::shortDate, $item['modifiedOn']->sec); ?></td>
      <td><?php print TPL::tags($item['tags']); ?></td>
      <td><a href="">edit</a></td>
    </tr>
      <?php
    }
    ?>
  </tbody>
  </table>
</div>