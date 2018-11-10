<?php
/**
 * Plugin Name: 4 Header Diagnostic
 */

// pbrocks
// add_action( 'wp_head', 'header_4_diagnostics' );
function header_4_diagnostics() {
	?>
	<style type="text/css">
		#grid-container {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
		}
	</style>
	<?php
	echo '<div id="grid-container">';
	echo '<div>';
	echo '<pre> $_GET';
	print_r( $_GET );
	echo '</pre>';
	echo '</div>';
	echo '<div>';
	echo '<pre>';
	print_r( $_POST );
	echo '</pre>$_GET';
	echo '</div>';
	echo '<div>';
	echo '<pre>';
	print_r( $_REQUEST );
	echo '</pre>$_GET';
	echo '</div>';
	echo '</div>';
	echo pmpro_start_up_session();
}

add_action( 'plugins_loaded', 'pmpro_check_sessions', 11 );
function pmpro_check_sessions() {
	if ( function_exists( 'pmpro_start_session' ) ) {
		pmpro_start_session();
	} else {
		start_session();
	}
}

function pmpro_start_up_session() {
	if ( session_status() == PHP_SESSION_NONE ) {
		$echo = 'Session NOT started';
	} else {
		$echo = 'Session started';
	}
	return $echo;
}
/*
  Add PMPro billing fields to the edit user profile page.
  You must Paid Memberships Pro and the Register Helper plugin installed:
  http://wordpress.org/extend/plugins/paid-memberships-pro
  https://github.com/strangerstudios/pmpro-register-helper
*/
function add_billing_fields_to_profile() {
	global $pmpro_countries;

	// check for register helper
	if ( ! function_exists( 'pmprorh_add_registration_field' ) ) {
		return;
	}

	// define the fields
	$fields = array();
	$fields[] = new PMProRH_Field(
		'pmpro_baddress1', 'text', array(
			'label' => 'Billing Address 1',
			'size' => 40,
			'profile' => true,
			'required' => false,
		)
	);
	$fields[] = new PMProRH_Field(
		'pmpro_baddress2', 'text', array(
			'label' => 'Billing Address 2',
			'size' => 40,
			'profile' => true,
			'required' => false,
		)
	);
	$fields[] = new PMProRH_Field(
		'pmpro_bcity', 'text', array(
			'label' => 'Billing City',
			'size' => 40,
			'profile' => true,
			'required' => false,
		)
	);
	$fields[] = new PMProRH_Field(
		'pmpro_bstate', 'text', array(
			'label' => 'Billing State',
			'size' => 10,
			'profile' => true,
			'required' => false,
		)
	);
	$fields[] = new PMProRH_Field(
		'pmpro_bzipcode', 'text', array(
			'label' => 'Billing Postal Code',
			'size' => 10,
			'profile' => true,
			'required' => false,
		)
	);
	$fields[] = new PMProRH_Field(
		'pmpro_bcountry', 'select', array(
			'label' => 'Billing Country',
			'profile' => true,
			'required' => false,
			'options' => array_merge( array( '' => '- choose one -' ), $pmpro_countries ),
		)
	);
	$fields[] = new PMProRH_Field(
		'pmpro_bphone', 'text', array(
			'label' => 'Billing Phone',
			'size' => 40,
			'profile' => true,
			'required' => false,
		)
	);

	// add the fields into a new checkout_boxes are of the checkout page
	foreach ( $fields as $field ) {
		pmprorh_add_registration_field( 'profile', $field );
	}
}
add_action( 'init', 'add_billing_fields_to_profile' );
