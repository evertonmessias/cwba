<?php

namespace WPDesk\FCF\Free\Service;

use FcfVendor\WPDesk\View\Renderer\Renderer;
use FcfVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FcfVendor\WPDesk\View\Resolver\ChainResolver;
use FcfVendor\WPDesk\View\Resolver\DirResolver;
use FcfVendor\WPDesk\View\Resolver\Exception\CanNotResolve;
use FcfVendor\WPDesk\View\Resolver\WPThemeResolver;
use WPDesk\FCF\Free\Exception\TemplateLoadingFailed;

/**
 * .
 */
class TemplateLoader {

	/**
	 * @var string
	 */
	private $plugin_path;

	/**
	 * @var string
	 */
	private $theme_templates_path;

	/**
	 * @var SimplePhpRenderer|null
	 */
	private $renderer = null;

	public function __construct( string $plugin_path, string $theme_templates_path ) {
		$this->plugin_path          = $plugin_path;
		$this->theme_templates_path = $theme_templates_path;
	}

	private function get_renderer(): Renderer {
		$resolver = new ChainResolver();
		$resolver->appendResolver( new WPThemeResolver( $this->theme_templates_path ) );

		foreach ( $this->get_template_directories() as $directory_path ) {
			$resolver->appendResolver( new DirResolver( $directory_path ) );
		}

		return new SimplePhpRenderer( $resolver );
	}

	private function get_template_directories(): array {
		$paths = [
			untrailingslashit( $this->plugin_path ) . '/templates',
		];

		return apply_filters( 'flexible_checkout_fields/templates_paths', $paths );
	}

	/**
	 * @throws TemplateLoadingFailed
	 */
	public function load_template( string $template_path, array $params ): string {
		$this->renderer = $this->renderer ?: $this->get_renderer();

		try {
			return $this->renderer->render( $template_path, $params );
		} catch ( CanNotResolve $e ) {
			throw new TemplateLoadingFailed( $e->getMessage() );
		}
	}
}
