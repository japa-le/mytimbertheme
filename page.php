<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

function my_custom_function()
{
	// Your custom code here
	global $nggdb;
	$gallery = $nggdb->get_gallery(4, 'sortorder', 'ASC', true, 0, 0);
  return $gallery;
}

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
$context['allpost'] = Timber::get_posts(  array(
    'post_type' => array('post')
  ) );
$context['my_gallery'] = my_custom_function();
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
