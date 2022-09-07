<?php

require_once( dirname(__FILE__) . '/../../../wp-load.php' );

if( empty( $_POST['name'] ) || empty( $_POST['mail'] ) || empty( $_POST['message'] ) ) {

  wp_redirect( add_query_arg( 'status', 'error', site_url( 'contact' ) ) );
  exit;

} 
// else {

//   wp_redirect( add_query_arg( 'status', 'success', site_url( 'contact' ) ) );
//   exit;

// }

$to = get_option('admin_email');
$subject = 'Кто-то отправил форму';

if( !empty( $_POST['subject'] ) && $_POST['subject'] ) {
  $subject = $_POST['subject'];
}

$message = $_POST['message'];
$name = $_POST['name'];
$email = $_POST['mail'];

$headers = array(
  "From: $name <no-reply@original.com>",
  "Reply-To: $name <$email>",
);

if( wp_mail( $to, $subject, $message ) ){
  wp_redirect( add_query_arg( 'status', 'success', site_url( 'contact' ) ) );
  exit;
}

wp_redirect( add_query_arg( 'status', 'error-2', site_url( 'contact' ) ) );
  exit;

?>