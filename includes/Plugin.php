<?PHP

namespace Pbr\Berpf;

use Pbr\Berpf\Admin;

class Plugin {
	protected static ?self $instance = null;
	protected ?string $entry_point = null;

	public static function get_instance(): self {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	protected static function display(): string {
        	return '<p> HELLO BIG MAN</p>';
	}


	public static function run(string $entry_point): self {
		add_shortcode('pbrberf_display', function (): string {
			 return self::display(); });
		add_action('admin_menu',  function () {
return Admin::adm_cfg_menu(); });
		add_action('admin_init', function () { Admin::rsettings(); });

		$plugin = self::get_instance();

		$plugin->entry_point = $entry_point;

		register_activation_hook($entry_point, function () {
			self::activate();
		});

		register_deactivation_hook($entry_point, function() {
			self::deactivate();
		});

		return $plugin;
	}

	protected static function activate(): void {
		flush_rewrite_rules();
	}

	protected static function deactivate(): void {
		flush_rewrite_rules();
	}
}
