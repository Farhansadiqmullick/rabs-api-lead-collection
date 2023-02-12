<?php

/**
 * Preapre Example
 */
// $data = array(
//   'customername' => 'Phil Malius',
//   'address' => 'No Address Given',
//   'phone' => '+447851135715',
//   'email' => 'malius88@googlemail.com',
//   'timeoforder' => '10.02.2023, 6:33 pm',
//   'orderfulltime' => '10.02.2023, 7:30 pm',
//   'paymenttype' => 'CARD',
//   'orderitems' => 'Chicken Burger,Battered Sausage,Platform fee',
//   'itemoptions' => 'Regular,None,None,',
//   'itemprice' => '13.6 GBP',
//   'totalprice' => '13.9 GBP'
// );

// $table_name = $wpdb->prefix . "customer_data";

// $columns = implode(", ", array_keys($data));
// $placeholders = implode(", ", array_fill(0, count($data), "%s"));
// $query = $wpdb->prepare("INSERT INTO $table_name ($columns) VALUES ($placeholders)", array_values($data));

// $wpdb->query($query);


/**
 * wpdb insert example
 */
// $wpdb->insert(
//     $this->tablename,
//     array(
//       'customername' => $row['customername'],
//       'address' => $row['address'],
//       'phone' => $row['phone'],
//       'email' => $row['email'],
//       'timeoforder' => $row['timeoforder'],
//       'orderfulltime' => $row['orderfulltime'],
//       'paymenttype' => $row['paymenttype'],
//       'orderitems' => $row['orderitems'],
//       'itemoptions' => $row['itemoptions'],
//       'itemprice' => $row['itemprice'],
//       'totalprice' => $row['totalprice']
//     ),
//     array(
//       '%s',
//       '%s',
//       '%s',
//       '%s',
//       '%s',
//       '%s',
//       '%s',
//       '%s',
//       '%s',
//       '%s',
//       '%s'
//     )
//   );

?>