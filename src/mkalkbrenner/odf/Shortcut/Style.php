<?php

namespace mkalkbrenner\odf\Shortcut;

use mkalkbrenner\odf\Node;

/**
 * Shortcuts primarily for Style-Elements.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
class Style extends Shortcut
{

  /**
   * Returns the Element /styles of styles.xml
   *
   * @return \DOMElement
   */
  public static function getDocumentStyles() {
    return self::$document->getElementsByTagName('styles')->item(0);
  }


  /**
   * Returns the Element /automatic-styles
   *
   * @return \DOMElement
   */
  public static function getDocumentAutomaticStyles() {
    return self::$document->getElementsByTagName('automatic-styles')->item(0);
  }

  /**
   * Returns the Element /master-styles/master-page from styles.xml. There is always.
   *
   * @return mixed
   */
  public static function getDocumentMasterPage() {
    return self::$document->getElementsByTagName('master-styles')->item(0)->getElementsByTagName('master-page')->item(0);
  }

  /**
   * Creates a master header element
   *
   * @param mixed $content
   * @param array $attributes
   *
   * @return \DOMElement
   */
  public static function createMasterStyleHeader($content = NULL, $attributes = []) {
    static $allowed_attributes = [];

    $style = self::createElement(Node::style_header, $content);
    self::setAttributes($style, $attributes, $allowed_attributes);

    return $style;
  }

  /**
   * Creates a Style Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createStyle($content = NULL, $attributes = [])
  {
    static $allowed_attributes = [
      'style:auto-update',
      'style:class',
      'style:data-style-name',
      'style:default-outline-level',
      'style:display-name',
      'style:family',
      'style:list-level',
      'style:list-style-name',
      'style:master-page-name',
      'style:name',
      'style:next-style-name',
      'style:parent-style-name',
      'style:percentage-data-style-name',
    ];

    $style = self::createElement(Node::style, $content);
    self::setAttributes($style, $attributes, $allowed_attributes);

    return $style;
  }

  /**
   * Creates a ParagraphProperties Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createParagraphProperties($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      'fo:background-color',
      'fo:border',
      'fo:border-bottom',
      'fo:border-left',
      'fo:border-right',
      'fo:border-top',
      'fo:break-after',
      'fo:break-before',
      'fo:hyphenation-keep',
      'fo:hyphenation-ladder-count',
      'fo:keep-together',
      'fo:keep-with-next',
      'fo:line-height',
      'fo:margin',
      'fo:margin-bottom',
      'fo:margin-left',
      'fo:margin-right',
      'fo:margin-top',
      'fo:orphans',
      'fo:padding',
      'fo:padding-bottom',
      'fo:padding-left',
      'fo:padding-right',
      'fo:padding-top',
      'fo:text-align',
      'fo:text-align-last',
      'fo:text-indent',
      'fo:widows',
      'style:auto-text-indent',
      'style:background-transparency',
      'style:border-line-width',
      'style:border-line-width-bottom',
      'style:border-line-width-left',
      'style:border-line-width-right',
      'style:border-line-width-top',
      'style:font-independent-line-spacing',
      'style:join-border',
      'style:justify-single-word',
      'style:line-break',
      'style:line-height-at-least',
      'style:line-spacing',
      'style:page-number',
      'style:punctuation-wrap',
      'style:register-true',
      'style:shadow',
      'style:snap-to-layout-grid',
      'style:tab-stop-distance',
      'style:text-autospace',
      'style:vertical-align',
      'style:writing-mode',
      'style:writing-mode-automatic',
      'text:line-number',
      'text:number-lines'
    ];

    $props = self::createElement(Node::paragraph_properties, $content);
    self::setAttributes($props, $attributes, $allowed_attributes);

    return $props;
  }

  /**
   * Creates a TextProperties Element
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createTextProperties($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      'fo:background-color',
      'fo:color',
      'fo:country',
      'fo:font-family',
      'fo:font-size',
      'fo:font-style',
      'fo:font-variant',
      'fo:font-weight',
      'fo:hyphenate',
      'fo:hyphenation-push-char-count',
      'fo:hyphenation-remain-char-count',
      'fo:language',
      'fo:letter-spacing',
      'fo:script',
      'fo:text-shadow',
      'fo:text-transform',
      'style:country-asian',
      'style:country-complex',
      'style:font-charset',
      'style:font-charset-asian',
      'style:font-charset-complex',
      'style:font-family-asian',
      'style:font-family-complex',
      'style:font-family-generic',
      'style:font-family-generic-asian',
      'style:font-family-generic-complex',
      'style:font-name',
      'style:font-name-asian',
      'style:font-name-complex',
      'style:font-pitch',
      'style:font-pitch-asian',
      'style:font-pitch-complex',
      'style:font-relief',
      'style:font-size-asian',
      'style:font-size-complex',
      'style:font-size-rel',
      'style:font-size-rel-asian',
      'style:font-size-rel-complex',
      'style:font-style-asian',
      'style:font-style-complex',
      'style:font-style-name',
      'style:font-style-name-asian',
      'style:font-style-name-complex',
      'style:font-weight-asian',
      'style:font-weight-complex',
      'style:language-asian',
      'style:language-complex',
      'style:letter-kerning',
      'style:rfc-language-tag',
      'style:rfc-language-tag-asian',
      'style:rfc-language-tag-complex',
      'style:script-asian',
      'style:script-complex',
      'style:script-type',
      'style:text-blinking',
      'style:text-combine',
      'style:text-combine-end-char',
      'style:text-combine-start-char',
      'style:text-emphasize',
      'style:text-line-through-color',
      'style:text-line-through-mode',
      'style:text-line-through-style',
      'style:text-line-through-text',
      'style:text-line-through-text-style',
      'style:text-line-through-type',
      'style:text-line-through-width',
      'style:text-outline',
      'style:text-overline-color',
      'style:text-overline-mode',
      'style:text-overline-style',
      'style:text-overline-type',
      'style:text-overline-width',
      'style:text-position',
      'style:text-rotation-angle',
      'style:text-rotation-scale',
      'style:text-scale',
      'style:text-underline-color',
      'style:text-underline-mode',
      'style:text-underline-style',
      'style:text-underline-type',
      'style:text-underline-width',
      'style:use-window-font-color',
      'text:condition',
      'text:display',
    ];

    $props = self::createElement(Node::text_properties, $content);
    self::setAttributes($props, $attributes, $allowed_attributes);

    return $props;
  }

  /**
   * Creates global GraphicProperties Element
   *
   * @param mixed $content
   * @param array $attributes
   *
   * @return \DOMElement
   */
  public static function createGlobalGraphicProperties($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      'text:anchor-type',
      'svg:x',
      'svg:y',
      'style:wrap',
      'style:number-wrapped-paragraphs',
      'style:wrap-contour',
      'style:vertical-pos',
      'style:vertical-rel',
      'style:horizontal-pos',
      'style:horizontal-rel'
    ];

    $attributes += [
      'text:anchor-type'                => 'paragraph',
      'svg:x'                           => '0cm',
      'svg:y'                           => '0cm',
      'style:wrap'                      => 'dynamic',
      'style:number-wrapped-paragraphs' => 'no-limit',
      'style:wrap-contour'              => 'false',
      'style:vertical-pos'              => 'top',
      'style:vertical-rel'              => 'paragraph',
      'style:horizontal-pos'            => 'center',
      'style:horizontal-rel'            => 'paragraph'
    ];

    $props = self::createElement(Node::graphic_properties, $content);
    self::setAttributes($props, $attributes, $allowed_attributes);

    return $props;
  }

  /**
   * Creates a GraphicProperties Element
   *
   * @param mixed $content
   * @param array $attributes
   *
   * @return \DOMElement
   */
  public static function createGraphicProperties($content = NULL, $attributes = [])
  {
    static $allowed_attributes = [
      'style:vertical-pos',
      'style:vertical-rel',
      'style:horizontal-pos',
      'style:horizontal-rel',
      'style:mirror',
      'style:wrap',                         // none|left|right|parallel|dynamic|run-through
      'style:run-through',                  // foreground|background
      'style:number-wrapped-paragraphs',
      'fo:clip',
      'fo:border',
      'fo:margin-left',
      'fo:margin-top',
      'fo:margin-right',
      'fo:margin-bottom',
      'fo:padding',
      'fo:border',
      'draw:luminance',
      'draw:contrast',
      'draw:red',
      'draw:green',
      'draw:blue',
      'draw:gamma',
      'draw:color-inversion',
      'draw:image-opacity',
      'draw:color-mode',
    ];

    $attributes += [
      'style:vertical-pos'              => 'from-top',
      'style:vertical-rel'              => 'page',
      'style:horizontal-pos'            => 'from-left',
      'style:horizontal-rel'            => 'page',
      'style:mirror'                    => 'none',
      'style:number-wrapped-paragraphs' => 'no-limit',
      'fo:clip'                         => 'rect(0cm, 0cm, 0cm, 0cm)',
      'fo:border'                       => 'none',
      'draw:luminance'                  => '0%',
      'draw:contrast'                   => '0%',
      'draw:red'                        => '0%',
      'draw:green'                      => '0%',
      'draw:blue'                       => '0%',
      'draw:gamma'                      => '100%',
      'draw:color-inversion'            => 'false',
      'draw:image-opacity'              => '100%',
      'draw:color-mode'                 => 'standard'
    ];

    $props = self::createElement(Node::graphic_properties, $content);
    self::setAttributes($props, $attributes, $allowed_attributes);

    return $props;
  }

}
