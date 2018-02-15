<?php


/**
 * @file
 * Settings forms
 */

/**
 * Create settings form in drupal configuration settings section for module.
 */
function arl_custom_admin_settings() {
  $form['arl_custom_header_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Header'),
    '#collapsible' => TRUE,
  );

  $form['arl_custom_header_settings']['arl_cust_header_set_login_btn_text'] = array(
    '#type' => 'textfield',
    '#title' => t('Button text'),
    '#default_value' => variable_get('arl_cust_header_set_login_btn_text', ""),
  );
  
  $form['arl_custom_header_settings']['arl_cust_header_set_login_url'] = array(
    '#type' => 'textfield',
    '#size' => 50,
    '#title' => t('Log in url'),
    '#default_value' => variable_get('arl_cust_header_set_login_url', ""),
  );

  $form['arl_custom_header_settings']['arl_cust_header_set_login_text'] = array(
    '#type' => 'textarea',
    '#size' => 50,
    '#title' => t('Log in text'),
    '#default_value' => variable_get('arl_cust_header_set_login_text', ""),
  );

  $form['arl_custom_contact_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Contact'),
    '#collapsible' => TRUE,
  );

  $form['arl_custom_contact_settings']['arl_cust_contact_set_tel'] = array(
    '#type' => 'textfield',
    '#size' => 50,
    '#title' => t('Telephone'),
    '#default_value' => variable_get('arl_cust_contact_set_tel', ""),
  );

  $form['arl_custom_contact_settings']['arl_cust_contact_set_email'] = array(
    '#type' => 'textfield',
    '#size' => 50,
    '#title' => t('Email'),
    '#default_value' => variable_get('arl_cust_contact_set_email', ""),
  );

  return system_settings_form($form);
}
