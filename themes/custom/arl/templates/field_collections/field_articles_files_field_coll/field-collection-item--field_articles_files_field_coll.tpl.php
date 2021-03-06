<?php

/**
 * @file
 * Default theme implementation for field collection items.
 *
 * Available variables:
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $title: The (sanitized) field collection item label.
 * - $url: Direct url of the current entity if specified.
 * - $page: Flag for the full page state.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. By default the following classes are available, where
 *   the parts enclosed by {} are replaced by the appropriate values:
 *   - entity-field-collection-item
 *   - field-collection-item-{field_name}
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */
?>
<a
  href="<?php print file_create_url($content['field_page_files']['#object']->field_page_files['und'][0]['uri']); ?>"
  target="_blank">
  <?php if (!empty($content['field_articles_files_img_fc_img'])): ?>
    <img class="file-icon"
         src="<?php print file_create_url($content['field_articles_files_img_fc_img']['#items'][0]['uri']) ?>">
  <?php endif; ?>

  <span class="ico"></span>
  <?php print $content['field_page_files']['#object']->field_page_files['und'][0]['description'] ?>
</a>
