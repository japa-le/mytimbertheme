# WordPress Theme with Timber, Slick Carousel, NextGen Gallery, and Quform

This is a custom WordPress theme built with Timber, a powerful plugin that enables developers to use Twig templates to render WordPress themes. The theme uses the Slick carousel to display a post portfolio and a gallery created with the NextGen Gallery plugin. The contact form is built with the Quform plugin.<br>
Have a look at the website built with this theme (https://janosp.net).

## Getting Started

To use this theme, you will need to have WordPress on your web server with the timber plugin and the NextGEN gallery plugin installed and activated. Then you can install this theme by uploading the ZIP file to the Themes section of your WordPress dashboard. Make sure you select the Timber-enabled theme after you activate the plugin (https://timber.github.io/docs/getting-started/setup/).<br><br>
In the WordPress backend you will need to create the pages with the slugs home, about-me and contact in order to show up properly.<br> To display the proper header and footer navigation create the menus with the name "Main" and "Main Footer".<br>
To display the gallery slider edit the function in the `page.php` file with the correct gallery ID you have created with the NextGEN plugin.<br>

```
function my_custom_function()
{
	global $nggdb;
	$gallery = $nggdb->get_gallery(the_gallery_id, 'sortorder', 'ASC', true, 0, 0);
  	return $gallery;
}
```
To display the Forms the shortcode from the Quform plugin needs to be pasted in `footer.twig` file and in the `contact` page you created.

## Support

If you have any questions or issues with this theme, please contact us via the support forum on GitHub.

## Credits

This theme was developed by Janos Pantli and is based on the Timber Starter Theme (https://github.com/timber/starter-theme).
