<?php

namespace mkalkbrenner\odf\Shortcut;

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
   * @param DOMDocument $document
   *
   * @return DOMElement
   */
  public static function getContentBody($document)
  {
    return $document->content->getElementsByTagName("body")->item(0)->getElementsByTagName("text")->item(0);
  }

  /**
   * Creates a Headline Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createHeading($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::class_names, ODF_Attribute::cond_style_name, ODF_Attribute::text_id, ODF_Attribute::is_list_header, ODF_Attribute::outline_level, ODF_Attribute::restart_numbering, ODF_Attribute::start_value, ODF_Attribute::style_name, ODF_Attribute::about, ODF_Attribute::content, ODF_Attribute::datatype, ODF_Attribute::property, ODF_Attribute::id);

    $h = self::createElement(ODF_Node::h, $content);
    self::setAttributes($h, $attributes, $allowed_attributes);

    return $h;
  }

  /**
   * Creates a Paragraph Element
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createParagraph($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::class_names, ODF_Attribute::cond_style_name, ODF_Attribute::text_id, ODF_Attribute::style_name, ODF_Attribute::about, ODF_Attribute::content, ODF_Attribute::datatype, ODF_Attribute::property, ODF_Attribute::id);

    $p = self::createElement(ODF_Node::p, $content);
    self::setAttributes($p, $attributes, $allowed_attributes);

    return $p;
  }

  /**
   * Creates a List Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createList($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::continue_list, ODF_Attribute::continue_numbering, ODF_Attribute::style_name, ODF_Attribute::id);

    $list = self::createElement(ODF_Node::list_body, $content);
    self::setAttributes($list, $attributes, $allowed_attributes);

    return $list;
  }

  /**
   * Creates a List-Header Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createListHeader($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::id);

    $listheader = self::createElement(ODF_Node::list_header, $content);

    self::setAttributes($listheader, $attributes, $allowed_attributes);

    return $listheader;
  }

  /**
   * Creates a List-Item Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createListItem($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::start_value, ODF_Attribute::style_override, ODF_Attribute::id);

    if (is_string($content))
      $content = self::createParagraph($content, $attributes);

    $listitem = self::createElement(ODF_Node::list_item, $content);
    self::setAttributes($listitem, $attributes, $allowed_attributes);

    return $listitem;
  }

  /**
   * Creates a Numbered-Paragraph Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createNumberedParagraph($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::continue_list, ODF_Attribute::text_level, ODF_Attribute::list_id, ODF_attribute::start_value, ODF_Attribute::style_name, ODF_Attribute::id);

    if (is_string($content))
      $content = self::createParagraph($content, $attributes);

    $numberedp = self::createElement(ODF_Node::numbered_p, $content);
    self::setAttributes($numberedp, $attributes, $allowed_attributes);

    return $numberedp;
  }

  /**
   * Creates a Page-Sequence Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createPageSequence($content = null, $attributes = array())
  {
    $allowed_attributes = array();

    $pagesequence = self::createElement(ODF_Node::page_sequence, $content);
    self::setAttributes($pagesequnce, $attributes, $allowed_attributes);

    return $pagesequence;
  }

  /**
   * Creates a Page Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createPage($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::master_page_name);

    $page = self::createElement(ODF_Node::page, $content);
    self::setAttributes($page, $attributes, $allowed_attributes);

    return $page;
  }

  /**
   * Creates a Section Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createSection($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::text_condition, ODF_Attribute::text_display, ODF_Attribute::text_name, ODF_Attribute::text_protected, ODF_Attribute::text_protection_key, ODF_Attribute::text_protection_key_digest_algorithm, ODF_Attribute::style_name, ODF_Attribute::id);

    $section = selct::createElement(ODF_Node::section, $content);
    self::setAttributes($section, $attributes, $allowed_attributes);

    return $section;
  }
}
