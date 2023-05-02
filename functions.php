<?php

/**
 * Timber starter-theme
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
if (file_exists($composer_autoload)) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {



	add_action(
		'admin_notices',
		function () {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function ($template) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site
{
	/** Add timber support. */
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types()
	{
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies()
	{
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context)
	{
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = new Timber\Menu();
		$context['menu_footer']  = new Timber\Menu('Main Footer');
		$context['site']  = $this;
		$context['logo_url']  = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
		$context['jpgallery'] = new Timber\Twig_Function('add_gallery', function () {


			global $nggdb;
			$gallery = $nggdb->get_gallery(4, 'sortorder', 'ASC', true, 0, 0);
			echo $gallery;
			/* foreach ($gallery as $image) {
				echo $image->imageURL;
				echo $image->alttext;
				echo $image->description;
			}
			*/
		});


		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');


		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

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

		add_theme_support('menus');

		$defaults = array(
			'height'               => 100,
			'width'                => 400,
			'flex-height'          => true,
			'flex-width'           => true,
			'header-text'          => array('site-title', 'site-description'),
			'unlink-homepage-logo' => true,
		);

		add_theme_support('custom-logo', $defaults);
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo($text)
	{
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */



	public function add_to_twig($twig)
	{
		/*
		$function = new Twig_SimpleFunction('enqueue_style_ext', function ($handle, $src) {
			wp_enqueue_style( $handle, $src);
		}); 
		$twig->addFunction($function); */
		$twig->addExtension(new Twig\Extension\StringLoaderExtension());
		$twig->addFilter(new Twig\TwigFilter('myfoo', array($this, 'myfoo')));
		$twig->addFunction(new Timber\Twig_Function('add_script', function () {



			wp_register_script(
				'jqueryscri',
				'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js',
				array('jquery'),
				'3.6.3'
			);

			wp_enqueue_script('jqueryscri');

			wp_register_script(
				'jqueryscrit',
				'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js',
				array('jquery'),
				'3.6.3'
			);

			wp_enqueue_script('jqueryscrit');



			wp_register_script(
				'sitejs',
				get_template_directory_uri() . '/static/site.js',
				['jquery']
			);
			wp_enqueue_script('sitejs');


			wp_register_script(
				'slickcar',
				'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
				array('sitejs'),
				'1.9.0',
				true
			);

			wp_enqueue_script('slickcar');

			wp_register_script(
				'slickcart',
				'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js',
				array('sitejs'),
				'1.9.0',
				true
			);

			wp_enqueue_script('slickcart');



			wp_register_script(
				'fancybox',
				'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js',
				array('jquery'),
				'3.5.7',
				true
			);

			wp_enqueue_script('fancybox');
		}));

		$twig->addFunction(new Timber\Twig_Function('add_style', function () {




			wp_register_style(
				'slicksty',
				'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css',
				array(),
				'1.9.0'
			);

			wp_enqueue_style('slicksty');



			wp_register_style(
				'slickstyl',
				'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css',
				array(),
				'1.9.0'
			);

			wp_enqueue_style('slickstyl');


			wp_register_style(
				'fontawesome',
				'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css',
				array(),
				'6.3.0'
			);

			wp_enqueue_style('fontawesome');

			wp_register_style(
				'fancyboxstyle',
				'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css',
				array(),
				'3.5.7'
			);

			wp_enqueue_style('fancyboxstyle');
		}));


		$twig->addFunction(new Timber\Twig_Function('add_gallery', function () {


			global $nggdb;
			$gallery = $nggdb->get_gallery(4, 'sortorder', 'ASC', true, 0, 0);
			echo $gallery[0]->imageURL;
			/* foreach ($gallery as $image) {
				echo $image->imageURL;
				echo $image->alttext;
				echo $image->description;
			}
			*/
		}));

		return $twig;
	}
}

new StarterSite();


