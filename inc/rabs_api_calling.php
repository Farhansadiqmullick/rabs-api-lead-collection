<?php
function rabs_api_calling()
{
  $data = '';
  $url = 'https://pos.globalfoodsoft.com/pos/order/pop';
  $args = array(
    'method'      => 'POST',
    'timeout'     => 45,
    'headers' => array(
      'Content-Type' => 'application/json',
      'Glf-Api-Version' => '2',
      'Authorization' => 'Dd4o8CaeJHwaZ5M1B',
    )
  );
  $response = wp_remote_post($url, $args);
  try {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
  } catch (Exception $ex) {
    echo 'Error' . $ex . ': Please contact with the developer for debugging the issue.';
    $data = null;
  }

  // $data = file_get_contents(plugin_dir_path(__DIR__) . 'response3.json');
  // $data = json_decode($data, true);
  return $data;
}

function rabs_get_data()
{
  $customer_data = rabs_api_calling();
  if (isset($customer_data)) {
    $countNumber = $customer_data['count'];
    if ($countNumber > 0) {
      $values = [];
      /**
       * Order Duplication Check
       */
      $customer_data = array_column($customer_data['orders'], null, 'client_first_name');
      // var_dump($customer_data);
      foreach ($customer_data as $key => $data) {
        // var_dump($data);
        // die();
        if (isset($data) && (is_array($data) || is_object($data)) && $data != null) {
          if ($data) {
            $values[] = array(
              'customername' => isset($data['client_first_name']) ? sanitize_text_field($data['client_first_name'] . ' ' . $data['client_last_name']) : '',
              'address' => isset($data['client_address']) ? sanitize_text_field($data['client_address']) : 'No Address Given',
              'phone' => isset($data['client_phone']) ? sanitize_text_field($data['client_phone']) : 'No. Not Given',
              'email' => isset($data['client_email']) ? sanitize_text_field($data['client_email']) : 'Email not Given',
              'timeoforder' => isset($data['updated_at']) ? date('d.m.Y, g:i a', strtotime($data['updated_at'])) : 'Null',
              'orderfulltime' => isset($data['fulfill_at']) ? date('d.m.Y, g:i a', strtotime($data['fulfill_at'])) : 'Null',
              'paymenttype' => isset($data['used_payment_methods']) ? sanitize_text_field($data['used_payment_methods'][0]) : 'Not Found',
              'orderitems' => order_items($data['items']),
              'itemoptions' => item_options($data['items']),
              'itemprice' => isset($data['sub_total_price']) ? $data['sub_total_price'] . ' ' . $data['currency'] : 'Price Not Found',
              'totalprice' => isset($data['total_price']) ? $data['total_price'] . ' ' . $data['currency'] : 'Price Not Found'
            );
          } else {
            return false;
          }
        } else {
          return false;
        }
      }
      // foreach ($values as $v_key => $value) {
      //   $fields .= "('{$value['customername']}', '{$value['address']}', '{$value['phone']}', '{$value['email']}', '{$value['timeoforder']}', '{$value['orderfulltime']}', '{$value['paymenttype']}', '{$value['orderitems']}', '{$value['itemoptions']}', '{$value['itemprice']}', '{$value['totalprice']}')";
      //   if ($v_key != (count($values) - 1)) {
      //     $fields .= ", ";
      //   }
      // }
      return $values;
    } else {
      return false;
    }
  }
  return false;
}

// var_dump(rabs_get_data());
// die();


function order_items($items)
{

  if (isset($items)) {
    if (is_array($items)) {
      $total_items = count($items);
      $multiple_items = '';
      foreach ($items as $key => $item) {
        if ($key != ($total_items - 1)) {
          $multiple_items .= sanitize_text_field($item['name'] . ', ');
        } else {
          $multiple_items .= sanitize_text_field($item['name']);
        }
      }
      return $multiple_items;
    } elseif (is_string($items)) {
      return sanitize_text_field($items['name']);
    } else {
      return 'No Order data found';
    }
  }
}

function item_options($options)
{

  if (isset($options)) {
    if (is_array($options)) {
      $total_items = count($options);
      $multiple_items = '';
      $values = '';
      foreach ($options as $key => $option) {
        $multiple_items = $option['options'];
        foreach ($multiple_items as $item) {
          $values .= sanitize_text_field($item['name'] . ', ');
        }
      }
      // var_dump($multiple_items);
      return $values;
    } elseif (is_string($items)) {
      return sanitize_text_field($options[0]['options'][0]['name']);
    } else {
      return 'No Order data found';
    }
  }
}
