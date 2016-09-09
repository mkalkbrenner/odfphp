<?php

namespace mkalkbrenner\odf\Converter;

use mkalkbrenner\odf\Odf;
use mkalkbrenner\odf\Shortcut\Text;

/**
 * Shortcuts primarily for Text-documents.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
class HtmlToTemplate
{

  /**
   * @var Odf
   */
  protected $odf;

  /**
   * @var string[]
   */
  protected $replacements;

  /**
   * @param \mkalkbrenner\odf\Odf $odf
   */
  public function setTemplate(Odf $odf) {
    $this->odf = $odf;
    $this->importStyles();
  }

  public function getOdf() {
    return $this->odf;
  }

  /**
   * @param string $section
   * @param string $html
   */
  public function fillSection($section, $html) {
    Text::setDocument($this->odf->content);
    $section_node = Text::search("//text:section[@text:name='" . $section . "']")->item(0);
    foreach (Text::search('//', $section) as $trash) {
      $section_node->removeChild($trash);
    }
    foreach ($this->replacements as $pattern => $replacement) {
      $html = preg_replace($pattern, $replacement, $html);
    }
    // TODO handle entities;
    $document = new \DOMDocument();
    $document->loadXML($html);
    $body = $document->getElementsByTagName('body')->item(0);
    foreach ($body->childNodes as $child) {
      $section_node->appendChild($child);
    }
  }

  /**
   * @param \DOMDocument $content
   */
  protected function importStyles() {
    Text::setDocument($this->odf->content);
    $style_node = Text::search("//text:section[@text:name='styles']")->item(0);

    for ($i = 1; $i <= 6; $i++) {
      /** @var \DOMElement $h */
      $h = Text::search("//text:h[@text:outline-level='" . $i . "']", $style_node)->item(0);
      $this->replacements['@<h' . $i . '[^>]*?>@'] = '<text:h text:outline-level="' . $i . '" text:style-name="' . $h->getAttribute('text:style-name') . '">';
      $this->replacements['@</h' . $i . '[^>]*?>@'] = '</text:h>';
    }

    /** @var \DOMElement $p */
    $p = Text::search("//text:p[text()='Normal']", $style_node)->item(0);
    $this->replacements['@<p[^>]*?>@'] = '<text:p text:style-name="' . $p->getAttribute('text:style-name') . '">';
    $this->replacements['@</p>@'] = '</text:p>';

    /** @var \DOMElement $b */
    $b = Text::search("//text:p[text()='bold']", $style_node)->item(0);
    $this->replacements['@<b[^>]*?>@'] = $this->replacements['@<strong[^>]*?>@'] = '<text:p text:style-name="' . $b->getAttribute('text:style-name') . '">';
    $this->replacements['@</b>@'] = $this->replacements['@</strong>@'] = '</text:p>';

    /** @var \DOMElement $em */
    $em = Text::search("//text:p[text()='italic']", $style_node)->item(0);
    $this->replacements['@<i[^>]*?>@'] = $this->replacements['@<em[^>]*?>@'] = '<text:p text:style-name="' . $em->getAttribute('text:style-name') . '">';
    $this->replacements['@</i>@'] = $this->replacements['@</em>'] = '</text:p>';

    /** @var \DOMElement $sup */
    $sup = Text::search("//text:span[text()='Superscript']", $style_node)->item(0);
    $this->replacements['@<sup[^>]*?>@'] = '<text:span text:style-name="' . $sup->getAttribute('text:style-name') . '">';
    $this->replacements['@</sup>@'] = '</text:span>';

    /** @var \DOMElement $sub */
    $sub = Text::search("//text:span[text()='Superscript']", $style_node)->item(0);
    $this->replacements['@<sub[^>]*?>@'] = '<text:span text:style-name="' . $sub->getAttribute('text:style-name') . '">';
    $this->replacements['@</sub>@'] = '</text:span>';

    /** @var \DOMElement $li */
    $li = Text::search("//text:span[text()='Numbered list']", $style_node)->item(0);
    /** @var \DOMElement $ol */
    $ol = $li->parentNode->parentNode->parentNode;
    $this->replacements['@<ol[^>]*?>@'] = '<text:list text:style-name="' . $ol->getAttribute('text:style-name') . '">';
    $this->replacements['@</ol>@'] = '</text:list>';
    $this->replacements['@<ol-li[^>]*?>@'] = '<text:list-item><text:p text:style-name="' . $li->parentNode->getAttribute('text:style-name') . '"><text:span text:style-name="' . $li->getAttribute('text:style-name') . '">';
    $this->replacements['@</li>@'] = '</text:span></text:p></text:list-item>';

    /** @var \DOMElement $li */
    $li = Text::search("//text:span[text()='Bulleted list']", $style_node)->item(0);
    /** @var \DOMElement $ul */
    $ul = $li->parentNode->parentNode->parentNode;
    $this->replacements['@<ul[^>]*?>@'] = '<text:list text:style-name="' . $ul->getAttribute('text:style-name') . '">';
    $this->replacements['@</ul>@'] = '</text:list>';
    $this->replacements['@<ul-li[^>]*?>@'] = '<text:list-item><text:p text:style-name="' . $li->parentNode->getAttribute('text:style-name') . '"><text:span text:style-name="' . $li->getAttribute('text:style-name') . '">';
    // li is redundant and set above.

    // TODO table

    $style_node->parentNode->removeChild($style_node);
  }
}
