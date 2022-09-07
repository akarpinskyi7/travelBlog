<?php

add_theme_support( 'post-thumbnails', array( 'post', ) );

add_image_size( 'bigfeatured', 888, 578, true );
add_image_size( 'smallsidebar', 88, 69, true );



add_filter( 'show_admin_bar', 'disable_admin_bar' );

function disable_admin_bar() {
    return false;
}


// включаем дополнительные инфо в контакты
function true_add_contacts( $contactmethods ) {
	$contactmethods['instagram'] = 'Акаунт в Instagram';
	$contactmethods['facebook'] = 'Ссылка на профиль в Facebook';
	$contactmethods['twitter'] = 'Акаунт в Twitter';
	$contactmethods['pinterest'] = 'Pinterest';
	return $contactmethods;
}
add_filter('user_contactmethods', 'true_add_contacts', 10, 1);


// включение виджетов на сайте
add_action( 'widgets_init', 'widgets_on' );

function widgets_on() {

	register_sidebar(
		array(
			'id' => 'rightside',
			'name' => 'Right sidebar',
			'description' => 'some text',
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<div class="heading-lines"><h3 class="widget-title heading">',
			'after_title' => '</h3></div>',

		)
	);

	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Search' );

}

//  подключаем стили для Gutenberg
add_action( 'after_setup_theme', 'gutenberg_css' );

function gutenberg_css() {
	
	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/style-gutenberg.css' );

}


// позволяет изменить стандартный HTML коментария
function my_comment( $comment, $args, $depth ) {
	?><li <?php comment_class() ?> id="comment-<?php comment_ID() ?>">
	<div class="comment-body">
		<?php echo get_avatar( $comment, 70, '', '', array( 'class' => 'comment-avatar' ) ) ?>
		<div class="comment-content">
			<span class="comment-author"><?php comment_author() ?></span>
			<span class="comment-date"><?php comment_date( 'j F Y H:i ' ) ?></span>
			<?php comment_text() ?>
			<?php comment_reply_link( array_merge(
				$args,
				array(
					'depth' => $depth,
					'max_depth' => $args['max_depth']
				)
			) ); ?>
		</div>
	</div>
<?php // без закрывающего </li>
}

//  подключаем стили и скрипты

add_action( 'wp_enqueue_scripts', 'add_css_and_js' );

function add_css_and_js() {

    wp_enqueue_style( 'gfonts', 'http://fonts.googleapis.com/css?family=Montserrat:300,400%7COpen+Sans:400,400i,700%7CMerriweather:400ii?subset=cyrillic', array(), null );

    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '1.0' );
    wp_enqueue_style( 'font-icons', get_stylesheet_directory_uri() . '/css/font-icons.css', array(), '1.0' );
    wp_enqueue_style( 'sliders', get_stylesheet_directory_uri() . '/css/sliders.css', array(), null );
    wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/css/style.css', array(), filemtime( dirname( __FILE__ ) . '/css/style.css' ) );
    wp_enqueue_style( 'responsive', get_stylesheet_directory_uri() . '/css/responsive.css', array(), null );
    wp_enqueue_style( 'spacings', get_stylesheet_directory_uri() . '/css/spacings.css', array(), null );
    wp_enqueue_style( 'animate', get_stylesheet_directory_uri() . '/css/animate.min.css', array(), null );


    // wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/js/jquery.min.js', array(), null, true );
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', site_url() . '/wp-includes/js/jquery/jquery.js', array(), null, true );
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'plugins', get_stylesheet_directory_uri() . '/js/plugins.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), null, true );

		if( is_single() ) {
			wp_enqueue_script( 'comment-reply' );
		}

}


//  подключаем навигационное меню

register_nav_menus( array(
    'head_menu' => 'Меню в header',
    'footer_menu' => 'Меню в footer',
) );


// Замена класов выпадающего меню

class Second_Menu extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'dropdown-menu' );

		
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;

        if( in_array('menu-item-has-children', $classes ) ) {
            $classes[] = 'dropdown';
        }


		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';

		
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;


		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}




