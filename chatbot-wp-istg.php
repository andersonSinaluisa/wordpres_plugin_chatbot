<?php
/**
 * chatbot-wp-istg
 *
 * @package       CHATBOTWP
 * @author        Anderson Sinaluisa
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   chatbot-wp-istg
 * Plugin URI:    https://mydomain.com
 * Description:   Chat bot para ISTG
 * Version:       1.0.0
 * Author:        Anderson Sinaluisa
 * Author URI:    https://andersonsinaluisa.com
 * Text Domain:   chatbot-wp-istg
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with chatbot-wp-istg. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'CHATBOTWP_NAME',			'chatbot-wp-istg' );

// Plugin version
define( 'CHATBOTWP_VERSION',		'1.0.0' );

// Plugin Root File
define( 'CHATBOTWP_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'CHATBOTWP_PLUGIN_BASE',	plugin_basename( CHATBOTWP_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'CHATBOTWP_PLUGIN_DIR',	plugin_dir_path( CHATBOTWP_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'CHATBOTWP_PLUGIN_URL',	plugin_dir_url( CHATBOTWP_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once CHATBOTWP_PLUGIN_DIR . 'core/class-chatbot-wp-istg.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Anderson Sinaluisa
 * @since   1.0.0
 * @return  object|Chatbot_Wp_Istg
 */
function CHATBOTWP() {
	return Chatbot_Wp_Istg::instance();
}

CHATBOTWP();
