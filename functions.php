<?php
/**
 * Curated
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'wp_ajax_nopriv_get_cars', array( $this, 'get_cars' ) );
		add_action( 'wp_ajax_get_cars', array( $this, 'get_cars' ) );
		add_action( 'wp_ajax_nopriv_get_journals', array( $this, 'get_journals' ) );
		add_action( 'wp_ajax_get_journals', array( $this, 'get_journals' ) );
		add_action( 'wp_ajax_nopriv_contact_us', array( $this, 'contact_us' ) );
		add_action( 'wp_ajax_contact_us', array( $this, 'contact_us' ) );
		parent::__construct();
	}

	/** This is where you can register custom post types. */
	public function register_post_types() {
		register_post_type( 'cars',
			// CPT Options
			array(
				'labels' => array(
				'name' => __( 'Cars' ),
				'singular_name' => __( 'Car' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'cars'),
				'taxonomies' => array( 'category' ),
			)
		);
		add_theme_support('post-thumbnails');
		add_post_type_support( 'cars', 'thumbnail' );

		register_post_type( 'firstlook',
			// CPT Options
			array(
				'labels' => array(
				'name' => __( 'First Looks' ),
				'singular_name' => __( 'First Look' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'first_look'),
				'taxonomies' => array( 'category' ),
			)
		);
		add_theme_support('post-thumbnails');
		add_post_type_support( 'firstlook', 'thumbnail' );
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {
		if( !is_admin() ) {
			wp_enqueue_style('my_assets' , StarterSite::get('assets/main.css'));
			wp_register_script('my_assets' , StarterSite::get('assets/main.js'));
			wp_enqueue_script('my_assets');
		}
	}

	protected static $assetManifest;

	function get($asset)
	{
		$distPath = get_template_directory() . '/dist';

		$manifestPath = $distPath . '/rev-manifest.json';

		if (!isset(StarterSite::$assetManifest)) {
			$manifestPath = $distPath . '/rev-manifest.json';
			if (is_file($manifestPath)) {
				StarterSite::$assetManifest = json_decode(file_get_contents($manifestPath), true);
			} else {
				StarterSite::$assetManifest = [];
			}
		}

		if (array_key_exists($asset, StarterSite::$assetManifest)) {
				$assetSuffix = StarterSite::$assetManifest[$asset];
		} else {
				$assetSuffix = $asset;
		}

		$distUrl = get_template_directory_uri() . '/dist';
		return $distUrl . '/' . $assetSuffix;
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['main_navigation']  = new Timber\Menu( 'main navigation' );
		$context['footer_menu_left']  = new Timber\Menu( 'left footer' );
		$context['footer_menu_right']  = new Timber\Menu( 'right footer' );
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		$twig->addFunction( new Timber\Twig_Function( 'slb_activate',  array( $this, 'slb_activate' ) ) );
		return $twig;
	}

	function get_cars() {
		$context = Timber::get_context();
		$context['limit'] = empty($_POST['limit']) ? 9 : $_POST['limit'];
		$context['page'] = empty($_POST['page']) ? 1 : $_POST['page'];
		$context['sort'] = empty($_POST['sort']) ? 'date-desc' : $_POST['sort'];
		$context['filter-category'] = empty($_POST['filter-category']) ? '' : $_POST['filter-category'];
		$orderby = array('date' => 'DESC');

		switch ($context['sort']) {
			case 'date-desc':
				$orderby = array('date' => 'DESC');
				break;
			case 'date-asc':
				$orderby = array('date' => 'ASC');
				break;
			case 'title-asc':
				$orderby = array('title' => 'ASC');
				break;
			case 'title-desc':
				$orderby = array('title' => 'DESC');
				break;
		}

		$args = array(
			// Get post type car
			'post_type' => 'cars',
			// Order by
			'orderby' => $orderby,
			// Limit posts
			'posts_per_page' => $context['limit'],
			// current page
			'paged' => $context['page']
		);

		if ($context['filter-category']) {
			$categoryID = get_categories(array('name' => $context['filter-category'], 'hide_empty' => 0))[0]->cat_ID;
			$args['category'] = array($categoryID);
		}

		$context['cars'] = Timber::get_posts( $args );

		Timber::render('partial/car-list.twig', $context);

		die();
	}

	function get_journals() {
		$context = Timber::get_context();
		$context['page'] = empty($_POST['page']) ? 1 : $_POST['page'];
		$context['limit'] = empty($_POST['limit']) ? 9 : $_POST['limit'];

		$args = array(
			// Order by post date
			'orderby' => array('date' => 'DESC'),
			// Limit posts
			'posts_per_page' => $context['limit'],
			// current page
			'paged' => $context['page']
		);

		$context['posts'] = Timber::get_posts( $args );

		Timber::render('partial/journal-list.twig', $context);

		die();
	}

	function contact_us() {
		$name = empty($_POST['name']) ? '' : $_POST['name'];
		$email = empty($_POST['email']) ? '' : $_POST['email'];
		$message = empty($_POST['message']) ? '' : $_POST['message'];

		$subject = 'Curated | New Contact Message';
    $headers = array('Content-Type: text/html; charset=UTF-8');

		$email_to = "jm@narralabs.com";
    $mail = wp_mail($email_to, $subject, Timber::compile(
			'views/email/contact-us.twig',
			[
				'name' => $name,
				'email' => $email,
				'message' => $message,
			]
    ), $headers);

		echo "OK";

		die();
	}

}

new StarterSite();
