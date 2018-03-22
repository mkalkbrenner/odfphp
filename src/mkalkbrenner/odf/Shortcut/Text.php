<?php

namespace mkalkbrenner\odf\Shortcut;

use mkalkbrenner\odf\Attribute;
use mkalkbrenner\odf\Node;

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
   * @return \DOMElement
   */
  public static function getContentBody() {
    return self::$document->getElementsByTagName('body')->item(0)->getElementsByTagName('text')->item(0);
  }

  /**
   * Creates a Headline Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createHeading($content = NULL, $attributes = [], $namespace = null) {
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

    $h = self::createElement(Node::h, $content, false, $namespace);
    self::setAttributes($h, $attributes, $allowed_attributes);

    return $h;
  }

  /**
   * Creates a Paragraph Element
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createParagraph($content = NULL, $attributes = [], $namespace = null) {
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

    $p = self::createElement(Node::p, $content, false, $namespace);
    self::setAttributes($p, $attributes, $allowed_attributes);

    return $p;
  }

  /**
   * Creates a List Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createList($content = NULL, $attributes = [], $namespace = null) {
    static $allowed_attributes = [
      Attribute::continue_list,
      Attribute::continue_numbering,
      Attribute::style_name,
      Attribute::id,
    ];

    $list = self::createElement(Node::list_body, $content, false, $namespace);
    self::setAttributes($list, $attributes, $allowed_attributes);

    return $list;
  }

  /**
   * Creates a List-Header Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createListHeader($content = NULL, $attributes = [], $namespace = null) {
    static $allowed_attributes = [
      Attribute::id,
    ];

    $listheader = self::createElement(Node::list_header, $content, false, $namespace);

    self::setAttributes($listheader, $attributes, $allowed_attributes);

    return $listheader;
  }

  /**
   * Creates a List-Item Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createListItem($content = NULL, $attributes = [], $namespace = null) {
    static $allowed_attributes = [
      Attribute::start_value,
      Attribute::style_override,
      Attribute::id,
    ];

    if (is_string($content)) {
      $content = self::createParagraph($content, $attributes);
    }

    $listitem = self::createElement(Node::list_item, $content, false, $namespace);
    self::setAttributes($listitem, $attributes, $allowed_attributes);

    return $listitem;
  }

  /**
   * Creates a Numbered-Paragraph Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createNumberedParagraph($content = NULL, $attributes = [], $namespace = null) {
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

    $numberedp = self::createElement(Node::numbered_p, $content, false, $namespace);
    self::setAttributes($numberedp, $attributes, $allowed_attributes);

    return $numberedp;
  }

  /**
   * Creates a Page-Sequence Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createPageSequence($content = NULL, $attributes = [], $namespace = null) {
    static $allowed_attributes = [];

    $pagesequence = self::createElement(Node::page_sequence, $content, false, $namespace);
    self::setAttributes($pagesequence, $attributes, $allowed_attributes);

    return $pagesequence;
  }

  /**
   * Creates a Page Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createPage($content = NULL, $attributes = [], $namespace = null) {
    static $allowed_attributes = [
      Attribute::master_page_name,
    ];

    $page = self::createElement(Node::page, $content, false, $namespace);
    self::setAttributes($page, $attributes, $allowed_attributes);

    return $page;
  }

  /**
   * Creates a Section Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  public static function createSection($content = NULL, $attributes = [], $namespace = null) {
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

    $section = self::createElement(Node::section, $content, false, $namespace);
    self::setAttributes($section, $attributes, $allowed_attributes);

    return $section;
  }

}
