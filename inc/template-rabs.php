<?php

/**
 * Template Name: Rabs API Template
 * Template Post Type: page, post
 */

require_once plugin_dir_path(__FILE__) . 'get_customer_data.php';
$getCustomers = new GetCustomerData();

get_header(); ?>

<div class="page-banner__content container container--narrow">
  <h3 class="page-banner__title">Rabs Customer Accepted Order List</h3>
  <div class="page-banner__intro">
    <p>Rabs Customer Accepted Order List From GlobalFood API</p>
  </div>
</div>

<div class="container container--narrow page-section">

  <table class="rabs-adoption-table">
    <tr>
      <th>Customer Name</th>
      <th>Address</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Time of Order</th>
      <th>Order Fulfilment Time</th>
      <th>Payment Type</th>
      <th>Order Items</th>
      <th>Item Options</th>
      <th>Item price</th>
      <th>Total price</th>
    </tr>
    <?php
    $total_results = $wpdb->get_var("SELECT COUNT(*) FROM $getCustomers->tablename");
    $total_pages = ceil($total_results / $getCustomers->items_per_page);
    foreach ($getCustomers->customer_data as $data) : ?>
      <tr>
        <td><?php echo $data->customername; ?></td>
        <td><?php echo $data->address; ?></td>
        <td><?php echo $data->phone; ?></td>
        <td><?php echo $data->email; ?></td>
        <td><?php echo $data->timeoforder; ?></td>
        <td><?php echo $data->orderfulltime; ?></td>
        <td><?php echo $data->paymenttype; ?></td>
        <td><?php echo $data->orderitems; ?></td>
        <td><?php echo $data->itemoptions; ?></td>
        <td><?php echo $data->itemprice; ?></td>
        <td><?php echo $data->totalprice; ?></td>
      </tr>
    <?php endforeach;
    ?>
  </table>
  <div class="pagination">
    <?php
    $total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $getCustomers->tablename");
    $total_pages = ceil($total_rows / $getCustomers->items_per_page);
    $pagination_args = array(
      'base' => add_query_arg('paged', '%#%'),
      'format' => '?paged=%#%',
      'total' => $total_pages,
      'current' => $getCustomers->current_page,
      'show_all' => false,
      'prev_next' => true,
      'prev_text' => __('&laquo; Prev'),
      'next_text' => __('Next &raquo;'),
      'type' => 'plain'
    );

    echo paginate_links($pagination_args);
    ?>
  </div>
</div>

<?php get_footer(); ?>