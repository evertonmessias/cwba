<?php

class Gal_Keyfile_Uploader {

	protected $fileindex = '';
	protected $jsontext  = '';
	// JSON could have been submitted by a file or by text
	public function __construct( $fileindex, $jsontext ) {
		$this->fileindex = $fileindex;
		$this->jsontext  = $jsontext;
		$this->attempt_upload();
	}

	protected $contents = null;
	protected function attempt_upload() {
		// If there was an attempt to upload a file
		if ( isset( $_FILES[ $this->fileindex ] )
					&& ( ! isset( $_FILES[ $this->fileindex ]['error'] ) || 4 !== $_FILES[ $this->fileindex ]['error'] ) ) {
					// error 4 = no file chosen anyway

			if ( isset( $_FILES[ $this->fileindex ]['error'] ) && '' !== sanitize_text_field( wp_unslash( $_FILES[ $this->fileindex ]['error'] ) ) ) {
				error_log( 'JSON Key file upload error number ' . sanitize_text_field( wp_unslash( $_FILES[ $this->fileindex ]['error'] ) ) );
				// Some import errors have error explanations
				$this->error = 'file_upload_error' . ( in_array( $_FILES[ $this->fileindex ]['error'], array( 2, 6, 7 ), true ) ? sanitize_text_field( wp_unslash( $_FILES[ $this->fileindex ]['error'] ) ) : '' );
				return;
			}

			if ( isset( $_FILES[ $this->fileindex ]['size'] ) && $_FILES[ $this->fileindex ]['size'] <= 0 ) {
				$this->error = 'no_content';
				return;
			}

			$filepath       = isset( $_FILES[ $this->fileindex ]['tmp_name'] ) ? sanitize_text_field( wp_unslash( $_FILES[ $this->fileindex ]['tmp_name'] ) ) : null;
			$this->contents = @file_get_contents( $filepath );
		} elseif ( strlen( trim( $this->jsontext ) ) > 0 ) {
			$this->contents = strpos( $this->jsontext, '\\\\' ) !== false ? stripslashes( $this->jsontext ) : $this->jsontext;
		}
		if ( null !== $this->contents ) {
			$this->read_json();
		}
	}

	protected function read_json() {
		$fullkey = json_decode( $this->contents, true );
		if ( null === $fullkey || ! is_array( $fullkey ) ) {
			$this->error = 'decode_error';
			return;
		}
		if ( ! isset( $fullkey['client_id'] ) || ! isset( $fullkey['client_email'] ) || ! isset( $fullkey['private_key'] ) || ! isset( $fullkey['type'] )
			|| '' === $fullkey['client_id'] || '' === $fullkey['client_email'] || '' === $fullkey['private_key'] ) {
			$this->error = 'missing_values';
			return;
		}
		if ( isset( $fullkey['type'] ) && 'service_account' !== $fullkey['type'] ) {
			$this->error = 'not_serviceacct';
			return;
		}

		if ( ! $this->test_key( $fullkey['private_key'] ) ) {
			$this->error = 'bad_pem';
			return;
		}

		$this->key       = $fullkey['private_key'];
		$this->id        = $fullkey['client_id'];
		$this->email     = $fullkey['client_email'];
		$this->pkeyprint = isset( $fullkey['private_key_id'] ) ? $fullkey['private_key_id'] : '<unspecified>';
	}

	protected function test_key( $pemkey ) {
		$hash      = defined( 'OPENSSL_ALGO_SHA256' ) ? OPENSSL_ALGO_SHA256 : 'sha256';
		$data      = 'test data';
		$signature = '';
		if ( ! @openssl_sign( $data, $signature, $pemkey, $hash ) ) {
			return false;
		}
		return '' !== $signature ? true : false;
	}

	protected $email = '';
	public function get_email() {
		return $this->email;
	}

	protected $id = '';
	public function get_id() {
		return $this->id;
	}

	protected $key = '';
	public function get_key() {
		return $this->key;
	}

	protected $pkeyprint = '';
	public function get_print() {
		return $this->pkeyprint;
	}

	protected $error = '';
	public function get_error() {
		return $this->error;
	}
}
