<?php

namespace WPDesk\FCF\Free\Field\Type;

use WPDesk\FCF\Free\Settings\Option\OptionIntegration;

/**
 * {@inheritdoc}
 */
abstract class TypeAbstract implements TypeInterface {

	/**
	 * {@inheritdoc}
	 */
	public function get_raw_field_type(): string {
		return $this->get_field_type();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_group() {
		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_reserved_field_names(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_icon(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_hidden(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options(): array {
		$options = [];
		foreach ( $this->get_options_objects() as $option_objects ) {
			foreach ( $option_objects as $option_object ) {
				$options[] = ( new OptionIntegration( $option_object ) )->get_field_settings();
			}
		}
		return $options;
	}
}
