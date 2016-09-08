<?php

namespace mkalkbrenner\odf\Shortcut;


/**
 * Shortcuts primarily for Spreadsheet-documents.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
class Spreadsheet extends Shortcut
{
  /**
   * Returns the Element /body/spreadsheet.
   *
   * @param DOMDocument $document
   *
   * @return DOMElement
   */
  public static function getContentBody($document)
  {
    return $document->content->getElementsByTagName("body")->item(0)->getElementsByTagName("spreadsheet")->item(0);
  }

  /**
   * Creates a Table Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createTable($content = null, $attributes = array())
  {
    $allowed_attributes = array();

    $table = self::createElement(ODF_Node::table, $content);
    self::setAttributes($row, $attributes, $allowed_attributes);

    return $table;
  }

  /**
   * Creates a Table-Row Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createTableRow($content = null, $attributes = array())
  {
    $allowed_attributes = array();

    $row = self::createElement(ODF_Node::table_row, $content);
    self::setAttributes($row, $attributes, $allowed_attributes);

    return $row;
  }

  /**
   * Create a Table-Cell Element.
   * If $content is a String, it creates a Paragrah containing this String.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createTableCell($content = null, $attributes = array())
  {
    $allowed_attributes = array();

    if (is_string($content))
      $content = ODF_Text::createParagraph($content, $attributes);

    $cell = self::createElement(ODF_Node::table_cell, $content);
    self::setAttributes($cell, $attributes, $allowed_attributes);

    return $cell;
  }
}
