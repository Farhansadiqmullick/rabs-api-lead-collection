<?php

class GetCustomerData
{
  public $customer_data;
  public $current_page;
  public $page;
  public $total;
  public $items_per_page;
  public $tablename;
  function __construct()
  {
    global $wpdb;
    $this->tablename = $wpdb->prefix . 'customer_data';
    $this->items_per_page = 10; // Number of items to display per page

    if (get_query_var('paged')) {
      $this->current_page = intval(get_query_var('paged')); //Always use get_query_var
    } else {
      $this->current_page = 1;
    }
    $offset = ($this->current_page - 1) * $this->items_per_page; // Calculate the offset for the query
    $order = 'DESC';

    $query = "SELECT * FROM $this->tablename ORDER BY timeoforder $order LIMIT $offset, $this->items_per_page";
    $this->customer_data = $wpdb->get_results($wpdb->prepare($query));
  }

}
