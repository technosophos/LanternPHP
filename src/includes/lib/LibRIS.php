<?php
/**
 * This is a library for parsing RIS files.
 *
 * This file holds three classes:
 * - {@link LibRIS}: The main parser library.
 * - {@link RISWriter}: Turns arrays into RIS records.
 * - {@link RISTags}: A descriptive class used by the other two.
 * 
 *
 * @see http://www.refman.com/support/risformat_intro.asp
 */
 
/**
 * The main class for parsing RIS files.
 *
 * The data structure generated by this class is of the form
 * <?php
 * array(
 *   [0] => array(
 *     'T1' => array('title one', 'title 2'),
 *     'TY' => array('JOUR'),
 *     // Other tags and their values.
 *   ),
 *   [1] => array(
 *     'T1' => array('another entry'),
 *     'TY' => array('JOUR'),
 *   ),
 * );
 * ?>
 */
class LibRIS {
  
  const RIS_EOL = "\r\n";
  const LINE_REGEX = '/^(([A-Z1-9]{2})  -(.*))|(.*)$/';
  
  protected $data = NULL;
  
  public function __construct($options = array()) {
    
  }
  
  /**
   * Parse an RIS file.
   *
   * This will parse the file and return a data structure representing the 
   * record.
   *
   * @param string $filename
   *  The full path to the file to parse.
   * @param StreamContext $context
   *  The stream context (in desired) for handling the file.
   * @return array
   *  An indexed array of individual sources, each of which is an 
   *  associative array of entry details. (See {@link LibRIS})
   */
  public function parseFile($filename, $context = NULL) {
    if (!is_file($filename)) {
      throw new Exception(sprintf('File %s not found.', htmlentities($filename)));
    }
    $flags = FILE_SKIP_EMPTY_LINES | FILE_TEXT;
    $contents = file($filename, $flags, $context);
    
    $this->parseArray($contents);
  }
  
  /**
   * Parse a string of RIS data.
   * 
   * This will parse an RIS record into a representative data structure.
   * @param string $string
   *  RIS-formatted data in a string.
   * @param StreamContext $context
   *  The stream context (in desired) for handling the file.
   * @return array
   *  An indexed array of individual sources, each of which is an 
   *  associative array of entry details. (See {@link LibRIS})
   */
  public function parseString($string) {
    $contents = explode ("\r\n", $string);
    $this->parseArray($contents);
  }
  
  /**
   * Take an array of lines and parse them into an RIS record.
   */
  protected function parseArray($lines) {
    $recordset = array();
    
    $record = array();
    $lastTag = NULL;
    foreach ($lines as $line) {
      $line = trim($line);
      $matches = array();
      preg_match(self::LINE_REGEX, $line, $matches);
      if (!empty($matches[3])) {
        $lastTag = $matches[2];
        $record[$matches[2]][] = trim($matches[3]);
      }
      // End record and prep a new one.
      elseif (!empty($matches[2]) && $matches[2] == 'ER') {
        $lastTag = NULL;
        $recordset[] = $record;
        $record = array();
      }
      elseif (!empty($matches[4])) {
        // Append to the last one.
        // We skip leading info (like BOMs).
        if (!empty($lastTag)) {
          $lastEntry = count($record[$lastTag]) - 1;
          // We trim because some encoders add tabs or multiple spaces.
          // Standard is silent on how this should be handled.
          $record[$lastTag][$lastEntry] .= ' ' . trim($matches[4]);
        }
      }
    }
    if (!empty($record)) $recordset[] = $record;
    
    $this->data = $recordset;
  }
  
  public function getRecords() {
    return $this->data;
  }
  
  public function printRecords() {
    $format = "%s:\n\t%s\n";
    foreach ($this->data as $record) {
      foreach ($record as $key => $values) {
        foreach ($values as $value) {
          printf($format, RISTags::describeTag($key), $value);
        }
      }
      
      print PHP_EOL;
    }
  }
  
}

class RISWriter {
  
  public function __construct() {}
  
  /**
   * Write a series of records to a single RIS string.
   *
   * @param array $records
   *  An array in the format generated by {@link LibRIS::parseFile()}
   * @return string
   *  The record as a string.
   */
  public function writeRecords($records) {
    $buffer = array();
    foreach ($records as $record) {
      $buffer[] = $this->writeRecord($record);
    }
    return implode(LibRIS::RIS_EOL, $buffer);
  }
  
  /**
   * Write a single record as an RIS string.
   *
   * The record should be an associative array of tags to values.
   *
   * @param array $tags
   *  An associative array of key => array(value1, value2,...).
   * @return string
   *  The record as a string.
   */
  public function writeRecord($tags) {
    $buffer = array();
    $fmt = '%s  - %s';
    
    foreach ($tags as $tag => $values) {
      foreach ($values as $value) {
        $buffer[] = sprintf($fmt, $tag, $value);
      }
    }
    $buffer[] = 'ER  - ';
    
    return implode(LibRIS::RIS_EOL, $buffer);
  }
  
}

/*
class RISBuilder {
  
  public function __construct() {
    
  }
  
}
*/

class RISTags {
  
  public static function getTags() {
    return array_keys(self::$tagMap);
  }
  
  public static function getTypes() {
    return array_keys(self::$typeMap);
  }
  
  public static function describeTag($tag) {
    return self::$tagMap[$tag];
  }
  
  public static function describeType($type) {
    return self::$typeMap[$type];
  }
  
  /**
   * The definitive list of all fields.
   * @var array
   * @see http://en.wikipedia.org/wiki/RIS_%28file_format%29
   * @see http://www.refman.com/support/risformat_intro.asp
   */
   public static $tagMap = array(
     'TY' => 'Type',
     'ID' => 'Reference ID',
     'T1' => 'Title',
     'TI' => 'Book title',
     'CT' => 'Title of unpublished reference',
     'A1' => 'Primary author',
     'A2' => 'Secondary author',
     'AU' => 'Author',
     'Y1' => 'Primary date',
     'PY' => 'Publication year',
     'N1' => 'Notes',
     'KW' => 'Keywords',
     'RP' => 'Reprint status',
     'SP' => 'Start page',
     'EP' => 'Ending page',
     'JF' => 'Periodical full name',
     'JO' => 'Periodical standard abbreviation',
     'JA' => 'Periodical in which article was published',
     'J1' => 'Periodical name - User abbreviation 1',
     'J2' => 'Periodical name - User abbreviation 2',
     'VL' => 'Volume',
     'IS' => 'Issue',
     'T2' => 'Title secondary',
     'CY' => 'City of Publication',
     'PB' => 'Publisher',
     'U1' => 'User 1',
     'U2' => 'User 2',
     'U3' => 'User 3',
     'U4' => 'User 4',
     'U5' => 'User 5',
     'T3' => 'Title series',
     'N2' => 'Abstract',
     'SN' => 'ISSN/ISBN/ASIN',
     'AV' => 'Availability',
     'M1' => 'Misc. 1',
     'M2' => 'Misc. 2',
     'M3' => 'Misc. 3',
     'AD' => 'Address',
     'UR' => 'URL',
     'L1' => 'Link to PDF',
     'L2' => 'Link to Full-text',
     'L3' => 'Related records',
     'L4' => 'Images',
     'ER' => 'End of Reference',
   ); 
  
  public static $tagDescriptions = array(
    'TY' => 'Type of reference (must be the first tag)',
    'ID' => 'Reference ID (not imported to reference software)',
    'T1' => 'Primary title',
    'TI' => 'Book title',
    'CT' => 'Title of unpublished reference',
    'A1' => 'Primary author',
    'A2' => 'Secondary author (each name on separate line)',
    'AU' => 'Author (syntax. Last name, First name, Suffix)',
    'Y1' => 'Primary date',
    'PY' => 'Publication year (YYYY/MM/DD)',
    'N1' => 'Notes ',
    'KW' => 'Keywords (each keyword must be on separate line preceded KW -)',
    'RP' => 'Reprint status (IN FILE, NOT IN FILE, ON REQUEST (MM/DD/YY))',
    'SP' => 'Start page number',
    'EP' => 'Ending page number',
    'JF' => 'Periodical full name',
    'JO' => 'Periodical standard abbreviation',
    'JA' => 'Periodical in which article was published',
    'J1' => 'Periodical name - User abbreviation 1',
    'J2' => 'Periodical name - User abbreviation 2',
    'VL' => 'Volume number',
    'IS' => 'Issue number',
    'T2' => 'Title secondary',
    'CY' => 'City of Publication',
    'PB' => 'Publisher',
    'U1' => 'User definable 1',
    'U2' => 'User definable 2',
    'U3' => 'User definable 3',
    'U4' => 'User definable 4',
    'U5' => 'User definable 5',
    'T3' => 'Title series',
    'N2' => 'Abstract',
    'SN' => 'ISSN/ISBN (e.g. ISSN XXXX-XXXX)',
    'AV' => 'Availability',
    'M1' => 'Misc. 1',
    'M2' => 'Misc. 2',
    'M3' => 'Misc. 3',
    'AD' => 'Address',
    'UR' => 'Web/URL',
    'L1' => 'Link to PDF',
    'L2' => 'Link to Full-text',
    'L3' => 'Related records',
    'L4' => 'Images',
    'ER' => 'End of Reference (must be the last tag)',
  );
  
  /**
   * Map of all types (tag TY) defined for RIS.
   * @var array
   * @see http://en.wikipedia.org/wiki/RIS_%28file_format%29
   * @see http://www.refman.com/support/risformat_intro.asp
   */
  public static $typeMap = array(
    'ABST' => 'Abstract',
    'ADVS' => 'Audiovisual material',
    'ART' => 'Art Work',
    'BOOK' => 'Whole book',
    'CASE' => 'Case',
    'CHAP' => 'Book chapter',
    'COMP' => 'Computer program',
    'CONF' => 'Conference proceeding',
    'CTLG' => 'Catalog',
    'DATA' => 'Data file',
    'ELEC' => 'Electronic Citation',
    'GEN' => 'Generic',
    'HEAR' => 'Hearing',
    'ICOMM' => 'Internet Communication',
    'INPR' => 'In Press',
    'JFULL' => 'Journal (full)',
    'JOUR' => 'Journal',
    'MAP' => 'Map',
    'MGZN' => 'Magazine article',
    'MPCT' => 'Motion picture',
    'MUSIC' => 'Music score',
    'NEWS' => 'Newspaper',
    'PAMP' => 'Pamphlet',
    'PAT' => 'Patent',
    'PCOMM' => 'Personal communication',
    'RPRT' => 'Report',
    'SER' => 'Serial publication',
    'SLIDE' => 'Slide',
    'SOUND' => 'Sound recording',
    'STAT' => 'Statute',
    'THES' => 'Thesis/Dissertation',
    'UNPB' => 'Unpublished work',
    'VIDEO' => 'Video recording',
  );
}

