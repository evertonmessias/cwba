<?php

namespace FcfVendor\WPDesk\DeactivationModal\Service;

use FcfVendor\WPDesk\DeactivationModal\Hookable;
use FcfVendor\WPDesk\DeactivationModal\Modal;
/**
 * Prints the needed contents of CSS and JS files on the plugin list page.
 */
class AssetsPrinterService implements \FcfVendor\WPDesk\DeactivationModal\Hookable
{
    const PLUGIN_NAME_VARIABLE = '{__PLUGIN_SLUG__}';
    /**
     * @var string
     */
    private $plugin_slug;
    public function __construct(string $plugin_slug)
    {
        $this->plugin_slug = $plugin_slug;
    }
    /**
     * {@inheritdoc}
     */
    public function hooks()
    {
        \add_action('admin_print_styles-plugins.php', [$this, 'load_styles']);
        \add_action('admin_print_footer_scripts-plugins.php', [$this, 'load_scripts']);
    }
    public function load_styles()
    {
        ?>
		<style id="<?php 
        echo \esc_attr($this->plugin_slug);
        ?>-deactivation-modal-css">
			<?php 
        $plugin_slug = $this->plugin_slug;
        include_once \FcfVendor\WPDesk\DeactivationModal\Modal::MODAL_ASSETS_PATH_CSS;
        ?>
		</style>
		<?php 
    }
    public function load_scripts()
    {
        ?>
		<script id="<?php 
        echo \esc_attr($this->plugin_slug);
        ?>-deactivation-modal-js">
			<?php 
        $plugin_slug = $this->plugin_slug;
        include_once \FcfVendor\WPDesk\DeactivationModal\Modal::MODAL_ASSETS_PATH_JS;
        ?>
		</script>
		<?php 
    }
}
