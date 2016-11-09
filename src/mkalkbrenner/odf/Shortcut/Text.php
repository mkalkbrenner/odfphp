<?php

namespace mkalkbrenner\odf\Shortcut;

use mkalkbrenner\odf\Attribute;
use mkalkbrenner\odf\Node;
use mkalkbrenner\odf\Odf;

/**
 * Shortcuts primarily for Text-documents.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
class Text extends Shortcut
{
  /**
   * Returns the Element /body/text.
   *
   * @param Odf $document
   *
   * @return \DOMElement
   */
  public static function getContentBody(Odf $document) {
    return $document->content->getElementsByTagName('body')->item(0)->getElementsByTagName('text')->item(0);
  }

  /**
   * Creates a Headline Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createHeading($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::class_names,
      Attribute::cond_style_name,
      Attribute::text_id,
      Attribute::is_list_header,
      Attribute::outline_level,
      Attribute::restart_numbering,
      Attribute::start_value,
      Attribute::style_name,
      Attribute::about,
      Attribute::content,
      Attribute::datatype,
      Attribute::property,
      Attribute::id,
    ];

    $h = self::createElement(Node::h, $content);
    self::setAttributes($h, $attributes, $allowed_attributes);

    return $h;
  }

  /**
   * Creates a Paragraph Element
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createParagraph($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::class_names,
      Attribute::cond_style_name,
      Attribute::text_id,
      Attribute::style_name,
      Attribute::about,
      Attribute::content,
      Attribute::datatype,
      Attribute::property,
      Attribute::id,
    ];

    $p = self::createElement(Node::p, $content);
    self::setAttributes($p, $attributes, $allowed_attributes);

    return $p;
  }

  /**
   * Creates a List Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createList($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::continue_list,
      Attribute::continue_numbering,
      Attribute::style_name,
      Attribute::id,
    ];

    $list = self::createElement(Node::list_body, $content);
    self::setAttributes($list, $attributes, $allowed_attributes);

    return $list;
  }

  /**
   * Creates a List-Header Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createListHeader($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::id,
    ];

    $listheader = self::createElement(Node::list_header, $content);

    self::setAttributes($listheader, $attributes, $allowed_attributes);

    return $listheader;
  }

  /**
   * Creates a List-Item Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createListItem($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::start_value,
      Attribute::style_override,
      Attribute::id,
    ];

    if (is_string($content)) {
      $content = self::createParagraph($content, $attributes);
    }

    $listitem = self::createElement(Node::list_item, $content);
    self::setAttributes($listitem, $attributes, $allowed_attributes);

    return $listitem;
  }

  /**
   * Creates a Numbered-Paragraph Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createNumberedParagraph($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::continue_list,
      Attribute::text_level,
      Attribute::list_id,
      Attribute::start_value,
      Attribute::style_name,
      Attribute::id,
    ];

    if (is_string($content)) {
      $content = self::createParagraph($content, $attributes);
    }

    $numberedp = self::createElement(Node::numbered_p, $content);
    self::setAttributes($numberedp, $attributes, $allowed_attributes);

    return $numberedp;
  }

  /**
   * Creates a Page-Sequence Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createPageSequence($content = NULL, $attributes = []) {
    static $allowed_attributes = [];

    $pagesequence = self::createElement(Node::page_sequence, $content);
    self::setAttributes($pagesequence, $attributes, $allowed_attributes);

    return $pagesequence;
  }

  /**
   * Creates a Page Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createPage($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::master_page_name,
    ];

    $page = self::createElement(Node::page, $content);
    self::setAttributes($page, $attributes, $allowed_attributes);

    return $page;
  }

  /**
   * Creates a Section Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createSection($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::text_condition,
      Attribute::text_display,
      Attribute::text_name,
      Attribute::text_protected,
      Attribute::text_protection_key,
      Attribute::text_protection_key_digest_algorithm,
      Attribute::style_name,
      Attribute::id
    ];

    $section = self::createElement(Node::section, $content);
    self::setAttributes($section, $attributes, $allowed_attributes);

    return $section;
  }

}
