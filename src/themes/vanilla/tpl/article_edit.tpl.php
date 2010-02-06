<?php
/**
 * Editor for article pages.
 */
?>
<form action="#">
  
  <fieldset id="journal_details" class="">
    <legend>Journal/Periodical Details</legend>
    
    <label for="journal_title">Journal Name</label>
    <input type="text" name="journal_title" value="" id="journal_title" size="40" class="input-title">
    
    <label for="volume">Volume</label>
    <input type="text" name="volume" size="5" value="" id="volume">
    
    <label for="issue">Issue</label>
    <input type="text" size="5" name="issue" value="" id="issue">
    
    <label for="publication_date">Publication Date</label>
    <input type="text" name="publication_date" size="6" value="" id="publication_date">
    
    <label for="publisher">Publisher</label>
    <input type="text" name="publisher" value="" size="60" id="publisher">
    
    
    <label for="city">Publication City</label>
    <input type="text" name="city" value="" size="60" id="city">
    
    <label for="issn">ISSN</label>
    <input type="text" name="issn" value="" size="18" id="issn">
    
    
  </fieldset>
  
  <fieldset id="article_details" class="">
    <legend>Article Details</legend>
    
    <label for="article_title">Article Title</label>
    <input type="text" name="article_title" size="50" value="" id="article_title" class="input-title">
    
    <label>Author(s)</label>
    <textarea name="article_authors" rows="5" cols="40"></textarea>
    <p class="help">One author per line, in format LAST, FIRST, EXTRA</p>
    
    <label for="pages_start">Pages</label>
    <input type="text" name="pages_start" value="" size="5" id="pages_start">
    to
    <input type="text" name="pages_end" value="" size="5" id="pages_end">
    
    
  </fieldset>
  
  <fieldset id="links" class="">
    <legend>Links and IDs</legend>
    
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
    
    <label for="abstract">Abstract</label>
    <textarea name="abstract" rows="8" cols="60"></textarea>
    
  </fieldset>
  
  <label for="tags">Tags</label>
  <input type="text" name="tags" value="" size="60" id="tags">
  <p class="help">Separate tags with commas.</p>
  
  <label>About this entry</label>
  <textarea name="notes_on_reference" rows="8" cols="60"></textarea>
  <p class="help">Is there something you need to remember when citing this reference? 
    If so, note it here.</p>

  <fieldset id="" class="">
    <input type="submit" name="submit" value="Save" id="submit">
  
  </fieldset>
</form>