<?php
define('__THEME_PATH', drupal_get_path('theme', 'arl'));
define('ARL_WEBFORM_REQUEST_QUOTE', 2);
define('ARL_SUBMIT_SAMPLE', 'http://www.arlokapps.com');
define('ARL_CAREERS', 54);
define('ARL_STAFF', 10);
define('ARL_LABORATORY_SERVICES', 4);
define('ARL_INDUSTRIES_SERVICES', 69);
define('ARL_ABOUT_US_MENU_PAGE', 70);
define('ARL_RESOURCES_MENU_PAGE', 71);
define('ARL_LIVE_INDUSTRIES_SERVICES', 72);
define('ARL_LIVE_RESOURCES_MENU_PAGE', 73);
define('ARL_LIVE_ABOUT_US_MENU_PAGE', 74);
define('ARL_NEWS_NID', 43);

/**
 * Implements template_preprocess_html().
 */
function arl_preprocess_html(&$vars) {

  $viewport = array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1, maximum-scale=1',
    ),
  );

  drupal_add_html_head($viewport, 'viewport');

  $view = views_get_page_view();
  if (is_object($view)) {
    switch ($view->name) {
      case 'home':
        $vars['classes_array'][] = '';
        break;
    }
  }

  $node = menu_get_object('node', 1);
  if ($node) {
    switch ($node->type) {
      case 'home':
        $vars['classes_array'][] = '';
        break;
    }
  }
}

/**
 * Implements template_preprocess_page().
 */
function arl_preprocess_page(&$vars) {

  if (isset($vars['node'])) {
    $node = $vars['node'];
  }
  else {
    $node = menu_get_object('webform_menu');
  }

  $vars['show_breadcrumbs'] = FALSE;
  $vars['wrap_class'] = 'content-wrapper';
  $vars['title_top'] = TRUE;

  if (!empty($node)) {
    $vars['theme_hook_suggestions'][] = 'page__' . $node->type;

    $top_fields = array(
      'field_common_subtitle',
      'field_top_image',
    );

    switch ($node->type) {
      case 'service':
        if ($node->nid != ARL_CAREERS) {
          $vars['show_breadcrumbs'] = TRUE;
        }
        $top_fields[] = 'field_service_icon';
        $top_fields[] = 'field_service_show_icon';
        break;
      case 'page':
        if ($node->nid == ARL_LABORATORY_SERVICES
          || $node->nid == ARL_NEWS_NID
          || $node->nid == ARL_INDUSTRIES_SERVICES
          || $node->nid == ARL_ABOUT_US_MENU_PAGE
          || $node->nid == ARL_RESOURCES_MENU_PAGE
          || $node->nid == ARL_LIVE_RESOURCES_MENU_PAGE
          || $node->nid == ARL_LIVE_ABOUT_US_MENU_PAGE
          || $node->nid == ARL_LIVE_INDUSTRIES_SERVICES) {
          $vars['wrap_class'] = '';
        }
        if ($node->nid == ARL_STAFF) {
          $vars['show_breadcrumbs'] = TRUE;
        }
        break;
      case 'webform':
      case 'forms':
      case 'contact':
        $vars['wrap_class'] .= ' style-a';
        $vars['title_top'] = FALSE;
        break;
      case 'staff':
        $vars['show_breadcrumbs'] = TRUE;
        $vars['breadcrumb'] = l(t('STAFF'), '/staff', array('attributes' => array('class' => array('btn', 'btn-back'))));
        break;
    }

    $top_fields_value = _arl_get_rows_from_node($node, $top_fields);

    if (!empty($top_fields_value)) {
      $vars['top_values'] = $top_fields_value;
    }
  }

  $options = array(
    'title' => t('Log in'),
    'attributes' => array(
      'class' => array('status', 'mobile-only'),
      'target' => '_blank',
    ),
  );
  $vars['login_mobile'] = theme('arl_custom__login_link', $options);

  $telephone = variable_get('arl_cust_contact_set_tel', '');
  $email = variable_get('arl_cust_contact_set_email', '');
  if ($telephone) {
    $vars['telephone'] = l($telephone, 'tel:' . $telephone, array('absolute' => TRUE));
  }
  if ($email) {
    $vars['email'] = l($email, 'mailto:' . $email, array('absolute' => TRUE));
  }
}

/**
 * Implements hook_preprocess_views_view().
 */
function arl_preprocess_views_view(&$vars) {
  switch ($vars['view']->name) {
    case 'staff_nav':
      if ($vars['view']->current_display == 'block') {
        $vars['classes_array'][] = 'navigation';
      } else {
        $vars['classes_array'][] = 'b-team';
      }
      break;
  }
}

/**
 * Implements template_preprocess_node().
 */
function arl_preprocess_node(&$vars) {
  $node = $vars['node'];
  if (!$vars['page']) {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__' . $vars['view_mode'];
  }

  switch ($node->type) {
    case 'homepage':
      $vars['services'] = views_embed_view('services', 'blockwithbtns');
      $vars['news'] = views_embed_view('news', 'block');
      break;
    case 'contact':
      $vars['classes_array'][] = 'section-inner';
      break;
    case 'news':
      try {
        $image = '';
        $node_wrapper = entity_metadata_wrapper('node', $node);
        if ($node_wrapper->__isset('field_news_image') && $node_wrapper->field_news_image->value() !== NULL) {
          $image = $node_wrapper->field_news_image->file->value();
        }
        if ($node_wrapper->__isset('field_news_video') && $node_wrapper->field_news_video->value() !== NULL) {
          $video = $node_wrapper->field_news_video->file->value();
        }
        if (isset($video) && $vars['view_mode'] != 'teaser') {
          $vars['content']['field_news_image']['#access'] = FALSE;
        }
        if (!$image) {
          $vars['add_class'] = 'no-img';
        }
      }
      catch (EntityMetadataWrapperException $exc) {
        watchdog('arl', 'See ' . __FUNCTION__ . '() <pre>' . $exc->getTraceAsString() . '</pre>', NULL, WATCHDOG_ERROR);
      }
      break;
  }
}

/**
 * Implements hook_form_alter().
 */
function arl_form_alter(&$form, &$form_state, $form_id) {
  switch ($form_id) {
    case 'webform_client_form_' . ARL_WEBFORM_REQUEST_QUOTE:
      $form['#attributes']['class'][] = 'form';
      $form['#attributes']['class'][] = 'form-quote';
      break;
    case 'search_form':
      unset($form['advanced']);
      $form['basic']['submit']['#prefix'] = '<div class="form-actions">';
      $form['basic']['submit']['#suffix'] = '</div>';
      break;
    case 'search_block_form':
      $form['search_block_form']['#attributes']['placeholder'] = t('HIT ENTER TO SEARCH');
      break;
  }
}

/**
 * Implements hook_preprocess_field().
 */
function arl_preprocess_field(&$vars) {
  $element = &$vars['element'];
  switch ($element['#field_name']) {
    case 'field_association_items_image':
    case 'field_association_items_title':
    case 'field_association_items_link':
    case 'field_accreditation_doc':
    case 'field_contact_items_text':
      $vars['theme_hook_suggestions'][] = 'field__no_wrapp';
      break;
    case 'field_staff_photo':
      $vars['classes_array'][] = 'img-staff';
      break;
    case 'field_contact_items':
      $vars['classes_array'][] = 'b-contact';
      break;
    case 'field_contact_items_social_fb':
      $vars['classes_array'][] = 'social-item ss-icon ss-social-regular ss-facebook';
      break;
    case 'field_contact_items_social_link':
      $vars['classes_array'][] = 'social-item ss-icon ss-social-regular ss-linkedin';
      break;
    case 'field_contact_logo':
      $vars['classes_array'][] = 'logo';
      break;
    case 'field_contact_items_icon':
      $vars['classes_array'][] = 'ico';
      break;
    case 'field_news_image':
      $vars['classes_array'][] = 'img';
      break;
    case 'field_forms_bottom_desc':
    case 'field_contact_text':
      $vars['classes_array'][] = 'text';
      break;
    case 'field_home_tabs':
      $field_array = array(
        'field_home_tabs_small_icon',
        'field_home_tabs_title',
      );
      $fc_rows = _arl_rows_from_field_collection($vars, $field_array);
      $fc_rows = !empty($fc_rows) ? $fc_rows : array();
      $list_items = array();
      foreach ($fc_rows as $key => $row) {
        $icon = !empty($row['field_home_tabs_small_icon']) ?
          $row['field_home_tabs_small_icon'] : '';
        if ($icon) {
          $icon_url = !empty($icon['uri']) ? file_create_url($icon['uri']) : '';
          if ($icon_url) {
            $icon_vars = array(
              'path' => $icon_url,
            );
            $icon = '<span class="ico">' . theme('image', $icon_vars) . '</span>';
          }
        }
        $title = !empty($row['field_home_tabs_title']) ?
          $icon . $row['field_home_tabs_title'] : '';
        if ($title) {
          $list_items[] = '<a href="#">' . $title . '</a>';
        }
      }
      $vars['tabs_list'] = theme('item_list', array('items' => $list_items));
      break;
    case 'field_home_forms':
    case 'field_page_files':
//      $vars['theme_hook_suggestions'][] = 'field__field_page_files';
      if ($element['#field_name'] == 'field_page_files') {
        $vars['classes_array'][] = 'list';
      }
      else {
        $vars['classes_array'][] = 'b-arl-forms';
      }
      $items = !empty($vars['items']) ? $vars['items'] : array();
      foreach ($items as $key => $item) {
        $description = !empty($item['#file']->description) ?
          $item['#file']->description : '';
        if ($description) {
          $vars['items'][$key]['#text'] = $description;
        }
      }
      break;
    case 'field_service_content_item':
      $vars['classes_array'][] = 'item-content';
      break;
    case 'field_service_content':
      $vars['classes_array'][] = 'b-collapsible';
      break;
    case 'field_articles_content':
      $vars['classes_array'][] = 'b-collapsible';
      $vars['classes_array'][] = 'style-a';
      break;
  }
}

/**
 * Implements template_preprocess_block().
 */
function arl_preprocess_block(&$vars) {

  switch ($vars['block']->delta) {
    case '1':
      $vars['classes_array'][] = 'text';
      break;
    case 'user-info':
    case 'arl_custom_user_info':
      $vars['classes_array'][] = 'user-info';
      break;
    case 'client-block-' . ARL_WEBFORM_REQUEST_QUOTE:
      $vars['classes_array'][] = 'form';
      $vars['classes_array'][] = 'form-quote';
      break;
  }
}

/**
 * Get rows from node.
 *
 * @param $node
 * @param $field_array
 * @return array|void
 */
function _arl_get_rows_from_node($node, $field_array) {

  if (!is_object($node)) {
    return;
  }

  try {
    $node_wrapper = entity_metadata_wrapper('node', $node);
    $properties = $node_wrapper->getPropertyInfo();
    $rows = array();

    foreach ($field_array as $field) {
      if (array_key_exists($field, $properties)) {
        $rows[$field] = $node_wrapper->$field->value();
      }
    }
  }
  catch (EntityMetadataWrapperException $exc) {
    watchdog('arl', 'See ' . __FUNCTION__ . '() <pre>' . $exc->getTraceAsString() . '</pre>', NULL, WATCHDOG_ERROR);
  }

  return $rows;
}


function _arl_generate_links_list($links) {
  if (!$links) {
    return;
  }
  $list_items = array();

  foreach ($links as $title => $link) {
    if ($title) {
      $list_items[] = l($title, $link);
    }
  }
  return theme('item_list', array('items' => $list_items));
}
/**
 * Creates a simple text rows array from a field collections, to be used in a
 * field_preprocess function.
 *
 * @param $vars
 * An array of variables to pass to the theme template.
 * @param $field_array
 * Array of fields to be turned into rows in the field collection.
 * @return array
 */
function _arl_rows_from_field_collection(&$vars, $field_array) {
  $rows = array();
  if (isset($vars['element']['#items'])) {
    $items = $vars['element']['#items'];
  }
  elseif (isset($vars['#items'])) {
    $items = $vars['#items'];
  }
  else {
    $items = array();
  }

  foreach ($items as $key => $item) {
    $entity_id = $item['value'];
    $entity = field_collection_item_load($entity_id);
    try {
      $wrapper = entity_metadata_wrapper('field_collection_item', $entity);
      $row = array();
      $properties = $wrapper->getPropertyInfo();

      foreach ($field_array as $field) {
        if (array_key_exists($field, $properties)) {
          $row[$field] = $wrapper->$field->value();
        }
      }
      $rows[] = $row;
    }
    catch (EntityMetadataWrapperException $exc) {
      watchdog('arl', 'See ' . __FUNCTION__ . '() <pre>' . $exc->getTraceAsString() . '</pre>', NULL, WATCHDOG_ERROR);
    }
  }

  return $rows;
}

/**
 * Implements template_preprocess_entity().
 */
function arl_preprocess_entity(&$variables, $hook) {
  $function = 'arl_preprocess_' . $variables['entity_type'];
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}

/**
 * Field Collection-specific implementation of template_preprocess_entity().
 */
function arl_preprocess_field_collection_item(&$variables) {
  $bundle = isset($variables['elements']['#bundle']) ? $variables['elements']['#bundle'] : '';

  switch ($bundle) {
    case 'field_service_content':
    case 'field_contact_items':
    case 'field_articles_content':
      $variables['classes_array'][] = 'item';
      break;
  }
}

/**
 * Returns HTML for a breadcrumb trail.
 *
 * @param $variables
 *   An associative array containing:
 *   - breadcrumb: An array containing the breadcrumb links.
 */
function arl_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    $classes[] = 'inline';

    foreach ($breadcrumb as $k => $v) {
      if ($k == (count($breadcrumb) - 1)) {
        $classes[] = 'last';
      }
      $breadcrumb[$k] = '<span class="' . implode(' ', $classes) . '">' . $v . '</span>';
    }
    $output .= '<div class="breadcrumb">' . implode(' <span class="delimiter">»</span> ', $breadcrumb) . '</div>';
    return $output;
  }
}


function arl_block_view_alter(&$data, $block) {

  if ($block->module == 'menu_block' && $block->region == 'content_top') {
    $links = $data['content']['#content'];
    $content = '';
    foreach ($links as $link) {
      if (isset($link['#title']) && isset($link['#href'])) {
        if ($link['#title'] !='Request a quote') {
          $content .= '<li>' . l($link['#title'], $link['#href']) . '</li>';
        }
      }
    }
    $link_quote = l(t('REQUEST A QUOTE'), url('node/' . ARL_WEBFORM_REQUEST_QUOTE), array('attributes' => array('class' => array('btn'))));
    $link_sample = l(t('SUBMIT A SAMPLE'), ARL_SUBMIT_SAMPLE, array('attributes' => array('class' => array('btn'))));
    $buttons = '<div class="btn-wrap">' . $link_quote . ($data['subject'] != 'Resources' ? $link_sample : '') . '</div>';

    $data['content'] = '<div class="nav-wrap style-b"><ul>' . $content . '</ul></div>' . $buttons;
  }

}