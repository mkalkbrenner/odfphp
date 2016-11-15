<?php

namespace mkalkbrenner\odf;

/**
 * Collection of ODF Attributetypes.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
interface Attribute
{
  const visibility = "office:visibility";

  const href = "xlink:href";

  const image_width   = "svg:width";
  const image_height  = "svg:height";
  const image_x       = "svg:x";
  const image_y       = "svg:y";

  const id = "xml:id";

  const about = "xhtml:about";
  const content = "xhtml:content";
  const datatype = "xhtml:datatype";
  const property = "xhtml:property";

  const class_names = "text:class-names";
  const cond_style_name = "text:cond-style-name";
  const continue_list = "text:continue-list";
  const continue_numbering = "text:continue-numbering";
  const is_list_header = "text:is-list-header";
  const list_id = "text:list-id";
  const master_page_name = "text:master-page-name";
  const outline_level = "text:outline-level";
  const restart_numbering = "text:restart-numbering";
  const start_value = "text:start-value";
  const style_name = "text:style-name";
  const style_override = "text:style-override";
  const text_id = "text:id";
  const text_condition = "text:condition";
  const text_display = "text:display";
  const text_level = "text:level";
  const text_name = "text:name";
  const text_protected = "text:protected";
  const text_protection_key = "text:protection-key";
  const text_protection_key_digest_algorithm = "text:protection_key_digest_algorithm";
}
