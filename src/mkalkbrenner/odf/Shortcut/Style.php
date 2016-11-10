<?php

namespace mkalkbrenner\odf\Shortcut;

use mkalkbrenner\odf\Node;
use mkalkbrenner\odf\Odf;

/**
 * Shortcuts primarily for Style-Elements.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
class Style extends Shortcut
{

  /**
   * Returns the Element /automatic-styles
   *
   * @param Odf $odf
   *
   * @return \DOMElement
   */
  public static function getContentAutomaticStyles(Odf $odf) {
    return $odf->content->getElementsByTagName('automatic-styles')->item(0);
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
   * Creates a GraphicProperties Element
   *
   * @param null $content
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
      'fo:clip',
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
      'style:vertical-pos' => 'from-top',
      'style:vertical-rel' => 'page',
      'style:horizontal-pos' => 'from-left',
      'style:horizontal-rel' => 'page',
      'style:mirror' => 'none',
      'fo:clip' => 'rect(0cm, 0cm, 0cm, 0cm)',
      'draw:luminance' => '0%',
      'draw:contrast' => '0%',
      'draw:red' => '0%',
      'draw:green' => '0%',
      'draw:blue' => '0%',
      'draw:gamma' => '100%',
      'draw:color-inversion' => 'false',
      'draw:image-opacity' => '100%',
      'draw:color-mode' => 'standard'
    ];

    $props = self::createElement(Node::graphic_properties, $content);
    self::setAttributes($props, $attributes, $allowed_attributes);

    return $props;
  }

  /**
   * Checks global Graphics style exists and inserts it if not exists
   *
   * @param Odf $odf
   *
   * @return bool
   */
  public static function hasGlobalGraphicsStyle(Odf $odf) {
    if($officeStyles = $odf->styles->getElementsByTagName('styles')->item(0)) {
      /** @var \DOMElement $styles */
      $styles = $officeStyles->childNodes;
      $found = false;
      /** @var \DOMElement $style */
      foreach($styles as $style) {
        if($style->hasAttribute('style:name') && 'Graphics' == ($name = $style->getAttribute('style:name'))) {
          $found = true;

          break;
        }
      }

      if(!$found) {
        $graphicsStyle = $odf->styles->createElement('style:style');
        $graphicsStyle->setAttribute('style:name', 'Graphics');
        $graphicsStyle->setAttribute('style:family', 'graphic');
        $graphicsProperties = $odf->styles->createElement('style:graphic-properties');
        $graphicsProperties->setAttribute('text:anchor-type', 'paragraph');
        $graphicsProperties->setAttribute('svg:x', '0cm');
        $graphicsProperties->setAttribute('svg:y', '0cm');
        $graphicsProperties->setAttribute('style:wrap', 'dynamic');
        $graphicsProperties->setAttribute('style:number-wrapped-paragraphs', 'no-limit');
        $graphicsProperties->setAttribute('style:wrap-contour', 'false');
        $graphicsProperties->setAttribute('style:vertical-pos', 'top');
        $graphicsProperties->setAttribute('style:vertical-rel', 'paragraph');
        $graphicsProperties->setAttribute('style:horizontal-pos', 'center');
        $graphicsProperties->setAttribute('style:horizontal-rel', 'paragraph');
        $graphicsStyle->appendChild($graphicsProperties);
        $officeStyles->appendChild($graphicsStyle);
      }

      return true;
    }

    return false;
  }

}
