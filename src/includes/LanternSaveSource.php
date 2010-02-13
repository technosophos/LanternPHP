<?php
/**
 * Save RIS resource
 */


/**
 * Save a source.
 */
class LanternSaveSource extends BaseLanternCommand {
  
  protected $verifySourceType = array('option' => array($this, 'verifySourceType'));
  
  public function expects() {
    return $this
      ->description('Save a resource')
    
      ->usesParam('entryID', 'The ID of this source. If it is not given, one will be generated.')
      ->withFilter('string')
      
      ->usesParam('source_type', 'The RIS type of this source.')
      ->withFilter('callback', $this->verifySourceType)
      ->andIsRequired()
    
      ->usesParam('primary_title', 'The primary title of a work.')
      ->withFilter('string')
      
      ->usesParam('secondary_title', 'The secondary title of a work.')
      ->withFilter('string')
      
      ->usesParam('series_title', 'The series to which the work belongs.')
      ->withFilter('string')
      
      ->usesParam('primary_author', 'The primary author of a work.')
      ->withFilter('string')
      
      ->usesParam('secondary_author', 'The secondary author(s) of a work.')
      ->withFilter('string')
      
      ->usesParam('book_title', 'The title of a book.')
      ->withFilter('string')
      
      ->usesParam('title_of_unpublished_work', 'The title of an unpublished work.')
      ->withFilter('string')
      
      ->usesParam('publication_date', 'The date of publication.')
      ->withFilter('string')
      
      ->usesParam('publisher', 'The publisher.')
      ->withFilter('string')
      
      ->usesParam('city', 'The city of publication.')
      ->withFilter('string')
      
      ->usesParam('primary_date', 'The primary date of publication.')
      ->withFilter('string')
      
      ->usesParam('reprint_status', 'Whether or not this is a reprint.')
      ->withFilter('string')
      
      ->usesParam('journal_title', 'The title of the journal in which this article was found.')
      ->withFilter('string')
      
      ->usesParam('volume', 'The volume number for this journal.')
      ->withFilter('string')
      
      ->usesParam('issue', 'The issue number for this journal.')
      ->withFilter('string')
      
      ->usesParam('journal_standard_abbreviation', 'The standard abbreviation for this journal title.')
      ->withFilter('string')
      
      ->usesParam('article_title', 'The title of this article.')
      ->withFilter('string')
      
      ->usesParam('article_authors', 'The authors of this article.')
      ->withFilter('string')
      
      ->usesParam('pages_start', 'The first page')
      ->withFilter('string') // Pages can be in roman numerals, so string.
      
      ->usesParam('pages_end', 'The end page')
      ->withFilter('string')
      
      ->usesParam('periodical_name', 'The name of the periodical or journal.')
      ->withFilter('string')
      
      ->usesParam('sn', 'Serial number (ISBN, ISSN, ASIN)')
      ->withFilter('string')
      
      ->usesParam('doi', 'DOI Number')
      ->withFilter('string')
      
      ->usesParam('url', 'The DOI URL')
      ->withFilter('url')
      
      ->usesParam('full_text', 'URL to full text')
      ->withFilter('url')
      
      ->usesParam('pdf_text', 'URL to PDF text')
      ->withFilter('url')
      
      ->usesParam('related_records', 'URL to related records')
      ->withFilter('url')
      
      ->usesParam('image_link', 'URL to image')
      ->withFilter('url')
      
      ->usesParam('address', 'Address')
      ->withFilter('string')
      
      ->usesParam('tags', 'Tags or keywords')
      ->usesFilter('callback', array('option' => array($this, 'verifyTags')))
      
      ->usesParam('abstract', 'The abstract of this work')
      ->withFilter('string')
      
      ->usesParam('notes', 'Notes')
      ->withFilter('string')
      
      ->usesParam('user1', 'User field')
      ->withFilter('string')
      ->usesParam('user2', 'User field')
      ->withFilter('string')
      ->usesParam('user3', 'User field')
      ->withFilter('string')
      ->usesParam('user4', 'User field')
      ->withFilter('string')
      ->usesParam('user5', 'User field')
      ->withFilter('string')
      
      ->usesParam('misc1', 'Misc field')
      ->withFilter('string')
      ->usesParam('misc2', 'Misc field')
      ->withFilter('string')
      ->usesParam('misc3', 'Misc field')
      ->withFilter('string')
      
      ->usesParam('availability', 'This work\'s availability.')
      ->withFilter('string')
      
      ->andReturns('The saved record as an associative array.')
    ;
  }
  
  public function doCommand() {
    // Clone param array.
    $params = $this->params;
    
    // Check on ID
    if (!empty($params['entryID'])) {
      return $this->modifyEntry($params);
    }
    else {
      return $this->createEntry($params);
    }
  }
  
  protected function modifyEntry(&$record) {
    
  }
  
  protected function createEntry(&$record) {
    
  }
  
  protected function verifyTags($data) {
    $tags = $this->explodeTags($data);
    return $tags;
  }
  
  protected function verifySourceType($value) {
    if (isset(RISTags::$typeMap[$value])) {
      return $value;
    }
    return FALSE;
  }
  
}