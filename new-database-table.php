<?php

/*
  Plugin Name: Rabs API Lead Collection
  Description: Ali express product importing
  Author Name: Farhan Mullick
  Author URIL: https://behance.net/farhanmullck
  Version: 1.0.0
  License: GPLv2 or later
  Text Domain: rabs_api
  Domain Path: /languages/
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly
require_once plugin_dir_path(__FILE__) . 'inc/rabs_api_calling.php';
class RabsAPILead
{
  public $charset;
  public $tablename;

  function __construct()
  {
    global $wpdb;
    $this->charset = $wpdb->get_charset_collate();
    $this->tablename = $wpdb->prefix . "customer_data";

    add_action('activate_api_recipe_calling/new-database-table.php', array($this, 'onActivate'));
    add_action('admin_head', array($this, 'onAdminRefresh'));
    add_action('wp_enqueue_scripts', array($this, 'loadAssets'));
    add_filter('theme_page_templates', array($this, 'rabs_api_template_dropdown'));
    add_filter('template_include', array($this, 'rabs_api_page_template'), 99);
  }

  function onActivate()
  {

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta("CREATE TABLE $this->tablename (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      customername varchar(60) NOT NULL DEFAULT '',
      address varchar(120) NOT NULL DEFAULT '',
      phone varchar(50) NOT NULL DEFAULT '',
      email varchar(60) NOT NULL DEFAULT '',
      timeoforder varchar(20) NOT NULL DEFAULT '',
      orderfulltime varchar(20) NOT NULL DEFAULT '',
      paymenttype varchar(20) NOT NULL DEFAULT '',
      orderitems varchar(200) NOT NULL DEFAULT '',
      itemoptions varchar(200) NOT NULL DEFAULT '',
      itemprice varchar(20) NOT NULL DEFAULT '',
      totalprice varchar(20) NOT NULL DEFAULT '',
      PRIMARY KEY  (id)
    ) $this->charset;");
  }

  function onAdminRefresh()
  {
    global $wpdb;
    // $values = implode(', ',rabs_get_data());
    $query = "INSERT INTO $this->tablename (`customername`, `address`, `phone`, `email`, `timeoforder`, `orderfulltime`, `paymenttype`, `orderitems`, `itemoptions`, `itemprice`, `totalprice`) VALUES ";
    $query .= rabs_get_data();
    // var_dump($query);
    $wpdb->insert($this->tablename, $wpdb->query($query));
    // die();
  }

  function loadAssets()
  {
    if (is_page_template('rabs-api-template')) {
      wp_enqueue_style('rabs-style', plugin_dir_url(__FILE__) . 'rabs_style.css');
    }
  }

  /**
   * Admin Template dropdown Item
   *
   * @param string $templates return the specific admin slug.
   */
  function rabs_api_template_dropdown($templates)
  {
    $rabs_api_template                   = [];
    $rabs_api_template['rabs-api-template'] = __('Rabs API Template', 'rabs_api');
    $templates                      = array_merge($templates, $rabs_api_template);
    return $templates;
  }

  /**
   * Admin Page Change Template
   *
   * @param string $template return all the template value.
   */
  function rabs_api_page_template($template)
  {
    if (is_page_template('rabs-api-template')) {
      global $post;
      $meta = get_post_meta($post->ID);
      if (!empty($meta['_wp_page_template'][0]) && $meta['_wp_page_template'][0] !== $template) {
        $template = plugin_dir_path(__FILE__) . 'inc/template-rabs.php';
        return $template;
      }
    }
    return $template;
  }
}

new RabsAPILead();
