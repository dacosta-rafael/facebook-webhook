<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] ) {
	///add your custom  token to replace xxx
	define( 'VERIFY_TOKEN', 'xxx' );

	if ( isset( $_GET['hub_mode'] ) && isset( $_GET['hub_verify_token'] ) && isset( $_GET['hub_challenge'] ) ) {



		if ( '' !== sanitize_text_field( wp_unslash( $_GET['hub_mode'] ) ) && '' !== sanitize_text_field( wp_unslash( $_GET['hub_verify_token'] ) ) && '' !== sanitize_text_field( wp_unslash( $_GET['hub_challenge'] ) ) ) {
			$mode      = sanitize_text_field( wp_unslash( $_GET['hub_mode'] ) );
			$token     = sanitize_text_field( wp_unslash( $_GET['hub_verify_token'] ) );
			$challenge = sanitize_text_field( wp_unslash( $_GET['hub_challenge'] ) );

		}
	}


	if ( ! empty( $mode ) && ! empty( $token ) && ! empty( $challenge ) ) {

		if ( 'subscribe' === $mode && VERIFY_TOKEN === $token ) {

			header( 'HTTP/1.1 200 OK' );
			echo esc_js( $challenge );

		} else {

			header( 'HTTP/1.0 403 Forbidden' );

		}
	}
}


if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	if ( isset( $_SERVER['HTTP_X_HUB_SIGNATURE'] ) ) {
		$post = file_get_contents( 'php://input' );
		///add your facebook app   token to replace xxx
		define( 'APP_SECRET', 'xxx' );
		$calculated_hmac = hash_hmac( 'sha1', $post, APP_SECRET );

		$salt = 'sha1=';

		if ( $_SERVER['HTTP_X_HUB_SIGNATURE'] === $salt . $calculated_hmac ) {
			$json        = json_decode( $post, true );
			print_r($json );

		}
	}
}
