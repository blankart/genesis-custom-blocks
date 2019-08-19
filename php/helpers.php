<?php
/**
 * Helper functions.
 *
 * @package   Block_Lab
 * @copyright Copyright(c) 2019, Block Lab
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */

use Block_Lab\Blocks;

/**
 * Return the value of a block field.
 *
 * @param string|string[] $name The name of the field.
 * @param bool            $echo Whether to echo and return the field, or just return the field.
 *
 * @return mixed
 */
function block_field( $name, $echo = true ) {
	/*
	 * Defined in Block_Lab\Blocks\Loader->render_block_template().
	 *
	 * @var array
	 */
	global $block_lab_attributes, $block_lab_config;

	if ( ! isset( $block_lab_attributes ) || ! is_array( $block_lab_attributes ) ) {
		return null;
	}

	$default_fields = array( 'className' );

	if ( ! isset( $block_lab_config->fields[ $name ] ) && ! in_array( $name, $default_fields, true ) ) {
		return null;
	}

	$field   = $block_lab_config->fields[ $name ];
	$value   = false; // This is a good default, it allows us to pick up on unchecked checkboxes.
	$control = null;

	if ( array_key_exists( $name, $block_lab_attributes ) ) {
		// Get the value from the block attributes.
		$value = $block_lab_attributes[ $name ];

		// Cast the value with the correct type.
		$value = $field->cast_value( $value );

		$control = $field->control;
	}

	if ( in_array( $name, $default_fields, true ) ) {
		// Cast default Editor attributes appropriately.
		$value = strval( $value );
	}

	/**
	 * Filters the value to be made available or echoed on the front-end template.
	 *
	 * @param mixed       $value The value.
	 * @param string|null $control The type of the control, like 'user', or null if this is the 'className', which has no control.
	 * @param bool        $echo Whether or not this value will be echoed.
	 */
	$value = apply_filters( 'block_lab_field_value', $value, $control, $echo );

	if ( $echo ) {
		if ( is_array( $value ) ) {
			$value = implode( ', ', $value );
		}

		if ( true === $value ) {
			$value = __( 'Yes', 'block-lab' );
		}

		if ( false === $value ) {
			$value = __( 'No', 'block-lab' );
		}

		/**
		 * Escaping this value may cause it to break in some use cases.
		 * If this happens, retrieve the field's value using block_value(),
		 * and then output the field with a more suitable escaping function.
		 */
		echo wp_kses_post( $value );
	}

	return $value;
}

/**
 * Return the value of a block field, without echoing it.
 *
 * @param string $name The name of the field as created in the UI.
 *
 * @uses block_field()
 *
 * @return mixed
 */
function block_value( $name ) {
	return block_field( $name, false );
}

/**
 * Prepare a loop with the first or next row in a repeater.
 *
 * @param string $name The name of the repeater field.
 *
 * @return int
 */
function block_row( $name ) {
	return block_lab()->loop->increment( $name );
}

/**
 * Determine whether another repeater row exists to loop through.
 *
 * @param string $name The name of the repeater field.
 *
 * @return bool
 */
function block_rows( $name ) {
	global $block_lab_attributes;

	if ( ! isset( $block_lab_attributes[ $name ] ) ) {
		return false;
	}

	$current_row = block_lab()->loop->row( $name );

	if ( false === $current_row ) {
		$next_row = 0;
	} else {
		$next_row = $current_row + 1;
	}

	if ( isset( $block_lab_attributes[ $name ]['rows'][ $next_row ] ) ) {
		return true;
	}

	return false;
}

/**
 * Return the value of a sub-field.
 *
 * @param string|string[] $name The name of the sub-field.
 * @param bool            $echo Whether to echo and return the field, or just return the field.
 *
 * @return mixed
 */
function block_sub_field( $name, $echo = true ) {

}

/**
 * Return the value of a sub-field, without echoing it.
 *
 * @param string $name The name of the sub-field.
 *
 * @uses block_field()
 *
 * @return mixed
 */
function block_sub_value( $name ) {
	return block_sub_field( $name, false );
}

/**
 * Convenience method to return the block configuration.
 *
 * @return array
 */
function block_config() {
	global $block_lab_config;
	return (array) $block_lab_config;
}

/**
 * Convenience method to return a field's configuration.
 *
 * @param string $name The name of the field as created in the UI.
 *
 * @return array|null
 */
function block_field_config( $name ) {
	global $block_lab_config;
	if ( ! isset( $block_lab_config->fields[ $name ] ) ) {
		return null;
	}
	return (array) $block_lab_config->fields[ $name ];
}
