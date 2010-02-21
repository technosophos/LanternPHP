<?php
/**
 * Maps Lantern source fields to RIS fields.
 */

class LanternRISMap {
  public static $map = array(
    '_id' => 'ID',
    'source_type' => 'TY',
    'primary_title' => 'T1',
    'secondary_title' => 'T2',
    'series_title' => 'T3',
    'primary_author' => 'A1',
    'secondary_author' => 'A2',
    'book_title' => 'TI',
    'title_of_unpublished_work' => 'CT',
    'publication_date' => 'PY',
    'publisher' => 'PB',
    'city' => 'CY',
    'primary_date' => 'Y1',
    'reprint_status' => 'RP',
    'journal_title' => 'JF',
    'volume' => 'VL',
    'issue' => 'IS',
    'journal_standard_abbreviation' => 'JO',
    //'article_title'
    'article_authors' => 'AU',
    'pages_start' => 'SP',
    'pages_end' => 'EP',
    'periodical_name' => 'JA',
    'sn' => 'SN',
    'doi' => 'M3',
    'url' => 'UR',
    'full_text' => 'L2',
    'pdf_text' => 'L1',
    'related_records' => 'L3',
    'image_link' => 'L4',
    'address' => 'AD',
    'tags' => 'KW',
    'abstract' => 'N2',
    'notes' => 'N1',
    'user1' => 'U1',
    'user2' => 'U2',
    'user3' => 'U3',
    'user4' => 'U4',
    'user5' => 'U5',
    'misc1' => 'M1',
    'misc2' => 'M3',
    //'misc3'
    'availablility' => 'AV',
  );
  
  protected static $flippedMap = NULL;
  
  /**
   * Given the lantern name, get the RIS name for a field.
   *
   * The following Lantern fields are known to not have an RIS counterpart
   *
   * - entry
   * - entryID (though _id is transformed into RIS ID)
   * - createdOn
   * - modifiedOn
   * - userID
   *
   * @param string $lanternName
   *  The field name for a lantern sorce.
   * @return string
   *  The RIS name (or NULL if no name is found.)
   */
  public static function getRISName($lanternName) {
    // Avoid E_STRICT warning.
    return isset(self::$map[$lanternName]) ? self::$map[$lanternName] : NULL;
  }
  
  /**
   * Given the RIS field name, get the Lantern name.
   * Note that the ER field (end of record) has no Lantern counterpart.
   *
   * The following fields have no Lantern counterpart:
   * - ER (End of Record)
   * - J1 (user-assigned journal abbreviated name)
   * - J2 (user-assigned journal abbreviated name)
   * 
   * @param string $risName 
   *  The name of the RIS field.
   * @return string
   *  The name of the lantern field (or NULL if no lantern field is found.)
   */
  public static function getLanternName($risName) {
    // Lazily build flipped map because it is not used as often. The
    // flipped map is only used during imports.
    if (empty(self::$flippedMap)) {
      self::$flippedMap = array_flip(self::$map);
    }
    // Avoid E_STRICT warning.
    return isset(self::$flippedMap[$risName]) ? self::$flippedMap[$risName] : NULL;
  }
  
}