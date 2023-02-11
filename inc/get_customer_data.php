<?php

class GetCustomerData
{
  protected $args;
  protected $placeholders;
  public $customer_data;
  public $page;
  public $total;
  public $items_per_page;
  function __construct()
  {
    global $wpdb;
    $tablename = $wpdb->prefix . 'customer_data';

    $this->args = $this->getArgs();
    $this->placeholders = $this->createPlaceholders();

    $query = "SELECT * FROM $tablename ";
    $this->total = "SELECT COUNT(*) FROM $tablename ";
    $query .= $this->createWhereText();
    // var_dump($query);
    // die();
    // $this->items_per_page = 5;
    // $this->page =  isset($this->total) ? ($this->total / $this->items_per_page) : 1;
    // $offset = ($this->page *  $this->items_per_page) -  $this->items_per_page;

    $this->customer_data = $wpdb->get_results($wpdb->prepare($query, $this->placeholders));
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

  function createWhereText()
  {
    $whereQuery = "";

    if (count($this->args)) {
      $whereQuery = "WHERE ";
    }

    $currentPosition = 0;
    foreach ($this->args as $item) {
      if ($currentPosition != count($this->args) - 1) {
        $whereQuery .= " AND ";
      }
      $currentPosition++;
    }

    return $whereQuery;
  }
}
