<?php
/**
 * Editor for any source type.
 *
 */

// Move this.
require 'lib/LibRIS.php';
function sourceTypeList($selected = 'BOOK') {
  $typeList = array();
  $optionFormat = '<option value="%s">%s</option>';
  foreach (RISTags::$typeMap as $id => $desc) {
    $sel = ($id == $selected) ? 'selected="selected"' : '';
    $typeList[] = sprintf($optionFormat, $id, $desc, $sel);
  }
  return implode("\n", $typeList);
}

?>
<form action="#">
  
  <fieldset id="general_information" class="">
    <legend>General Information</legend>
    
    <select name="source_type" id="source_type">
      <?php print sourceTypeList(); ?>
    </select>
    
    <label for="primary_title">Primary Title</label>
    <input type="text" name="primary_title" value="<?php print ''; ?>" 
      id="primary_title" size="60"/>
    
    <label for="secondary_title">Secondary Title</label>
    <input type="text" name="secondary_title" value="<?php print ''; ?>" 
      id="secondary_title" size="60"/>
      
    <label for="series_title">Series Title</label>
    <input type="text" name="series_title" value="<?php print ''; ?>" 
      id="series_title" size="60"/>
    
    <label for="primary_author">Primary Author</label>
    <input type="text" name="primary_author" value="<?php print ''; ?>" 
      id="primary_author" size="60"/>
    <p class="help">Format: <em>Last, First, Suffix</em></p>
    
    <label for="secondary_author">Secondary Author(s)</label>
    <textarea name="secondary_author" rows="8" cols="60"><?php print ''; ?></textarea>
    <p class="help">One author per line. Format: <em>Last, First, Suffix</em></p>
    
    
  </fieldset>
  
  <fieldset id="book_details" class="">
    <legend>Book Details</legend>
    
    <label for="book_title">Book Title</label>
    <input type="text" name="book_title" value="<?php print ''; ?>" id="book_title"
      size="60"/>
    
  </fieldset>
  
  <fieldset id="unpublished_work" class="">
    <legend>Unpublished Work</legend>
    
    <label for="title_of_unpublished_work">Title of Unpublished Work</label>
    <input type="text" name="title_of_unpublished_work" value="<?php print ''; ?>" 
     size="60" id="title_of_unpublished_work"/>
    
  </fieldset>
  
  <fieldset id="publishing_info" class="">
    <legend>Publishing Info</legend>
    
    <label for="publication_date">Publication Date</label>
    <input type="text" name="publication_date" size="6" value="" 
      id="publication_date"/>
    <p class="help">Format: <em>YYYY/MM/DD</em></p>
    
    <label for="publisher">Publisher</label>
    <input type="text" name="publisher" value="" size="60" id="publisher"/>
    
    
    <label for="city">Publication City</label>
    <input type="text" name="city" value="" size="60" id="city"/>
    
    <label for="primary_date">Primary Date</label>
    <input type="text" name="primary_date" size="8" value="<?php print ''; ?>" 
     id="primary_date"/>
     
    <label for="reprint_status">Reprint Status</label>
    <input type="text" name="reprint_status" value="<?php print ''; ?>" 
      size="10" id="reprint_status"/>
      
    
    
    
  </fieldset>
  
  <fieldset id="journal_details" class="">
    <legend>Journal/Periodical Details</legend>
    
    <label for="journal_title">Journal Name</label>
    <input type="text" name="journal_title" value="" id="journal_title" size="40" 
    class="input-title"/>
    
    <label for="volume">Volume</label>
    <input type="text" name="volume" size="5" value="" id="volume"/>
    
    <label for="issue">Issue</label>
    <input type="text" size="5" name="issue" value="" id="issue"/>
    
    <label for="journal_standard_abbreviation">Journal Standard Abbreviation</label>
    <input type="text" name="journal_standard_abbreviation" value="<?php print '';?>"
      size="20" id="journal_standard_abbreviation"/>
    
    
    
    
    
  </fieldset>
  
  <fieldset id="article_details" class="">
    <legend>Article Details</legend>
    
    <!--
    <label for="article_title">Article Title</label>
    <input type="text" name="article_title" size="50" value="" id="article_title" class="input-title">
    -->
    
    <label>Author(s)</label>
    <textarea name="article_authors" rows="5" cols="40"></textarea>
    <p class="help">One author per line, in format LAST, FIRST, EXTRA</p>
    
    <label for="pages_start">Pages</label>
    <input type="text" name="pages_start" value="" size="5" id="pages_start">
    to
    <input type="text" name="pages_end" value="" size="5" id="pages_end">
    
    <label for="periodical_name">Periodical Name</label><input type="text"
     name="periodical_name" value="<?php print ''; ?>" 
     size="60" id="periodical_name"/>
    <print class="help">Periodical/Journal in which this article appeared.</print>
    
  </fieldset>
  
  <fieldset id="links" class="">
    <legend>Links and IDs</legend>
    
    <label for="issn">ISBN/ISSN/ASIN</label>
    <input type="text" name="sn" value="" size="18" id="sn">
    
    <label for="doi">DOI</label>
    <input type="text" name="doi" value="" size="16" id="doi">
    <p class="help">The DOI for this article (e.g. <em>10.1007/s10676-009-9181-2</em>).</p>
    
    
    <label for="url">URL</label>
    <input type="text" name="url" value="" size="60" id="url">
    <p class="help">This should be the DOI URL, if possible (e.g. <a
       href="http://dx.doi.org/10.1007/s10676-009-9181-2"
       >http://dx.doi.org/10.1007/s10676-009-9181-2</a>).</p>
    
    <label for="full_text">URL to Full Text</label>
    <input type="text" name="full_text" value="" size="60" id="full_text">
    
    <label for="pdf_text">URL to PDF Text</label>
    <input type="text" name="pdf_text" value="" size="60" id="pdf_text">
    
    <label for="related_records">URL to Related Records</label>
    <input type="text" name="related_records" value="" size="60" id="related_records">
    
    <label for="image_link">URL to Image(s)</label>
    <input type="text" name="image_link" value="" size="60" id="image_link">
    
    <label for="address">Address</label>
    <textarea name="address" rows="8" cols="40"></textarea>
  </fieldset>
  
  <fieldset id="extra" class="">
    <legend>Extra</legend>
    
    <label for="tags">Tags (Keywords)</label>
    <input type="text" name="tags" value="" size="60" id="tags">
    <p class="help">Separate tags with commas.</p>
    
    <label for="abstract">Abstract</label>
    <textarea name="abstract" rows="8" cols="60"></textarea>
    
    <label>Notes About This Entry</label>
    <textarea name="notes" rows="8" cols="60"></textarea>
    <p class="help">Is there something you need to remember when citing this reference? If so, note it here.</p>
    
    <label for="user_1">User 1</label>
    <input type="text" name="user_1" value="<?php print ''; ?>" size="60" id="user_1"/>
    
    <label for="user_2">User 2</label>
    <input type="text" name="user_2" value="<?php print ''; ?>" size="60" id="user_2"/>
    
    <label for="user_3">User 3</label>
    <input type="text" name="user_3" value="<?php print ''; ?>" size="60" id="user_3"/>
    
    <label for="user_4">User 4</label>
    <input type="text" name="user_4" value="<?php print ''; ?>" size="60" id="user_4"/>
    
    <label for="user_5">User 5</label>
    <input type="text" name="user_5" value="<?php print ''; ?>" size="60" id="user_5"/>
    
    <label for="misc_1">Misc 1</label>
    <input type="text" name="misc_1" value="<?php print ''; ?>" size="60" id="misc_1"/>
    
    <label for="misc_2">Misc 2</label>
    <input type="text" name="misc_2" value="<?php print ''; ?>" size="60" id="misc_2"/>
    
    <!--
    <label for="misc_3">Misc 3</label>
    <input type="text" name="misc_3" value="<?php print ''; ?>" size="60" id="misc_3"/>
    -->
    
    <label for="availability">Availability</label>
    <input type="text" name="availability" value="<?php print '';?>" size="60" 
      id="availability">
    
    
  </fieldset>

  <fieldset id="" class="">
    <input type="submit" name="submit" value="Save" id="submit">
    <input type="hidden" name="entryID", value="<?php print ''; ?>">
  </fieldset>
</form>
