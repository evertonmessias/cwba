<?php

namespace WPDesk\FCF\Free\Validator\Rule;

use WPDesk\FCF\Free\Validator\Error\InvalidUrlError;

/**
 * Checks that the URL value is valid.
 */
class UrlFormatRule implements ValidatorRule {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( string $value, array $field_data ) {
		$url_path     = parse_url( $value, PHP_URL_PATH );
		$encoded_path = array_map( 'urlencode', explode( '/', $url_path ) );
		$encoded_url  = str_replace( $url_path, implode( '/', $encoded_path ), $value );

		if ( ( $value === '' ) || filter_var( $encoded_url, FILTER_VALIDATE_URL ) ) {
			return null;
		}

		return new InvalidUrlError( $field_data, $value );
	}
}
