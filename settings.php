<?php

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * Settings Page for the Label Replacer Plugin
 */
function labelReplacer_settings_init() {
	// Register a new setting for "labelReplacer" page.
	register_setting( 'label-Replacer', 'labelReplacer_allowHTML' );

	// Register a new section in the "labelReplacer" page.
	add_settings_section(
		'labelReplacer_General_Settings',
		__( 'Plugin Settings', 'labelReplacer' ), 'labelReplacer_General_Settings_callback',
		'labelReplacer_General_Settings'
	);

	// Register a new field in the "labelReplacer_General_Settings" section, inside the "labelReplacer" page.
	add_settings_field(
		'labelReplacer_field_allowHTML', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
			__( 'Allow HTML', 'labelReplacer' ),
		'labelReplacer_field_allowHTML_cb',
		'labelReplacer_General_Settings',
		'labelReplacer_General_Settings',
		array(
			'label_for'         => 'labelReplacer_field_allowHTML',
			'class'             => 'labelReplacer_row',
			'labelReplacer_custom_data' => 'custom',
		)
	);
}

/**
 * Register labelReplacer_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'labelReplacer_settings_init' );


/**
 * General Settings section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
 function labelReplacer_General_Settings_callback( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'General Settings for the Label-Replacer Plugin', 'labelReplacer' ); ?></p>
	<?php
}

/**
 * allowHTML field callback function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 *
 * @param array $args
 */
function labelReplacer_field_allowHTML_cb( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'labelReplacer_allowHTML' );
	?>
        <input type="checkbox"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['labelReplacer_custom_data'] ); ?>"
            name="labelReplacer_allowHTML[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="1"
            <?php checked( isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '', 1 ); ?>
        />
        <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
            <?php esc_html_e( 'Enable HTML', 'labelReplacer' ); ?>
        </label>
        <?php
        echo '<p>Allows the usage of HTML elements like links as label value.</p><i style="color: red;">(Dangerous!)</i>';
}

/**
 * Add the top level menu page.
 */
function labelReplacer_options_page() {
	add_submenu_page(
        'options-general.php',
		'Label Replacer Plugin',
		'label-Replacer',
		'manage_options',
		'labelReplacer',
		'labelReplacer_options_page_html'
	);
}

/**
 * Register our labelReplacer_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'labelReplacer_options_page' );

/**
 * Top level menu callback function
 */
function labelReplacer_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages
	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'labelReplacer_messages', 'labelReplacer_message', __( 'Settings Saved', 'labelReplacer' ), 'updated' );
	}

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "labelReplacer"
			settings_fields( 'label-Replacer' );
            ?>
            <?php
            //Plugin description and usage
            ?>
            <p style="font-size: medium;"><?php esc_html_e( 'The Label Replacer Plugin is a simple WordPress plugin designed to automatically replace specific text labels on your website.', 'labelReplacer' ); ?>
            </br><?php esc_html_e( 'Please visit my ', 'labelReplacer' ); ?>
            <a href="<?php esc_html_e( 'https://github.com/OliverWeinhold/label-replacer' ) ?>"><?php esc_html_e( 'GitHub Page', 'labelReplacer' ); ?></a> <?php esc_html_e( 'for more documentation or if you like to support and contribute to the project. Thank you!'); ?>
            </p>
            <p style="border-top: 1px solid #bdbdbe;"></p>
            <h2> <?php esc_html_e( 'Usage', 'labelReplacer' ); ?></h2>
            <p> <?php esc_html_e( 'Define a label in your post:', 'labelReplacer' ); ?></p>
            <code> <?php esc_html_e( '{{label:YourLabel=YourReplacementText}}', 'labelReplacer' ); ?></code>
            <p> <?php esc_html_e( 'Use the label anywhere in your post:', 'labelReplacer' ); ?></p>
            <code> <?php esc_html_e( '{{label:YourLabel}}', 'labelReplacer' ); ?></code>
            <p style="border-bottom: 1px solid #bdbdbe;"></p>
            <?php
			// output setting sections and their fields
			// (sections are registered for "labelReplacer", each field is registered to a specific section)
			do_settings_sections( 'labelReplacer_General_Settings' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}