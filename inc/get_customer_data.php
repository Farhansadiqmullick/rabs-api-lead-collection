<?php

class GetCustomerData
{
  protected $args;
  public $customer_data;
  public $page;
  public $total;
  public $items_per_page;
  public $placeholders;
  public $tablename;
  function __construct()
  {
    global $wpdb;
    $this->tablename = $wpdb->prefix . 'customer_data';

    $this->args = $this->getArgs();
    $this->placeholders = $this->createPlaceholders();
    $this->items_per_page = 10; // Number of items to display per page

    if (get_query_var('paged')) {
      $current_page = intval(get_query_var('paged')); //Always use get_query_var
    } else {
      $current_page = 1;
    }
    $offset = ($current_page - 1) * $this->items_per_page; // Calculate the offset for the query
    $order = 'DESC';

    $query = "SELECT * FROM $this->tablename ORDER BY timeoforder $order LIMIT $offset, $this->items_per_page";
    $this->customer_data = $wpdb->get_results($wpdb->prepare($query));
  }


  function getArgs()
  {
    $temp = array(
      'customer_name' => sanitize_text_field($_GET['customername']),
      'address' => sanitize_text_field($_GET['address']),
      'phone' => sanitize_text_field($_GET['phone']),
      'email' => sanitize_text_field($_GET['email']),
      'time_of_order' => sanitize_text_field($_GET['timeoforder']),
      'order_full_time' => sanitize_text_field($_GET['orderfulltime']),
      'payment_type' => sanitize_text_field($_GET['paymenttype']),
      'order_items' => sanitize_text_field($_GET['orderitems']),
      'item_options' => sanitize_text_field($_GET['itemoptions']),
      'item_price' => sanitize_text_field($_GET['itemprice']),
      'total_price' => sanitize_text_field($_GET['totalprice']),
    );

    return array_filter($temp, function ($x) {
      return $x;
    });
  }

  function createPlaceholders()
  {
    return array_map(function ($x) {
      return $x;
    }, $this->args);
  }
}
