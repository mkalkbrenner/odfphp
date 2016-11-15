<?php

namespace mkalkbrenner\odf\Shortcut;

use mkalkbrenner\odf\Node;

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
   * @return \DOMElement
   */
  public static function getContentBody() {
    return self::$document->getElementsByTagName('body')->item(0)->getElementsByTagName('spreadsheet')->item(0);
  }

  /**
   * Creates a Table Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createTable($content = NULL, $attributes = []) {
    static $allowed_attributes = [];

    $table = self::createElement(Node::table, $content);
    self::setAttributes($table, $attributes, $allowed_attributes);

    return $table;
  }

  /**
   * Creates a Table-Row Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createTableRow($content = NULL, $attributes = []) {
    static $allowed_attributes = [];

    $row = self::createElement(Node::table_row, $content);
    self::setAttributes($row, $attributes, $allowed_attributes);

    return $row;
  }

  /**
   * Create a Table-Cell Element.
   * If $content is a String, it creates a Paragrah containing this String.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createTableCell($content = NULL, $attributes = []) {
    static $allowed_attributes = [];

    if (is_string($content)) {
      $content = Text::createParagraph($content, $attributes);
    }

    $cell = self::createElement(Node::table_cell, $content);
    self::setAttributes($cell, $attributes, $allowed_attributes);

    return $cell;
  }

}
