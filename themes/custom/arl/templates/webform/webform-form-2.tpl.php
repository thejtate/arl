<?php

/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 *
 * If a preview is enabled, these keys will be available on the preview page:
 * - $form['preview_message']: The preview message renderable.
 * - $form['preview']: A renderable representing the entire submission preview.
 */
?>

<?php
if (!empty($form['submitted']['first_name']['#title'])) {
  $form['submitted']['first_name']['#title'] = '';
}
if (!empty($form['submitted']['last_name']['#title'])) {
  $form['submitted']['last_name']['#title'] = '';
}
if (!empty($form['submitted']['email']['#title'])) {
  $form['submitted']['email']['#title'] = '';
}
if (!empty($form['submitted']['phone']['#title'])) {
  $form['submitted']['phone']['#title'] = '';
}

// Print out the progress bar at the top of the page
print drupal_render($form['progressbar']);

?>
<div class="required">
  <span class="form-required">*</span> <?php print t('Required Field'); ?>
</div>
<?php
// Print out the preview message if on the preview page.
if (isset($form['preview_message'])) {
  print '<div class="messages warning">';
  print drupal_render($form['preview_message']);
  print '</div>';
}
?>

<div class="row">
  <?php print drupal_render($form['submitted']['first_name']); ?>
  <?php print drupal_render($form['submitted']['last_name']); ?>
  <?php print drupal_render($form['submitted']['suffix']); ?>
</div>
<div class="row">
  <?php print drupal_render($form['submitted']['company_name']); ?>
  <?php print drupal_render($form['submitted']['position']); ?>
</div>
<div class="row">
  <?php print drupal_render($form['submitted']['address']); ?>
</div>
<div class="row">
  <?php print drupal_render($form['submitted']['city']); ?>
  <?php print drupal_render($form['submitted']['state']); ?>
  <?php print drupal_render($form['submitted']['zip_code']); ?>
</div>
<div class="row">
  <?php print drupal_render($form['submitted']['phone']); ?>
  <?php print drupal_render($form['submitted']['fax']); ?>
  <?php print drupal_render($form['submitted']['email']); ?>
</div>
<div class="row">
  <?php print drupal_render($form['submitted']['description']); ?>
</div>
<div class="text">
  <?php print drupal_render($form['submitted']['how_did_you_hear_about_arl']); ?>
</div>
<?php print drupal_render($form['submitted']); ?>

<?php print drupal_render_children($form); ?>
