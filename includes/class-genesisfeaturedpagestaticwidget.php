<?php
/**
 * This is mostly the StudioPress code with some slight modifications to allow for sites using a static home page.
 *
 * @package GenesisFeaturedPageStaticWidget
 * @author  Robin Cornett
 * @license GPL-2.0+
 */

/**
 * Genesis Featured Page widget class.
 *
 * @since 0.1.8
 *
 * @package Genesis\Widgets
 */
class Genesis_Featured_Page_Static_Widget extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct() {

		$this->defaults = array(
			'title'             => '',
			'page_id'           => '',
			'show_image'        => 0,
			'image_alignment'   => '',
			'image_size'        => '',
			'show_title'        => 0,
			'show_content'      => 0,
			'content_limit'     => '',
			'more_text'         => '',
			'postspage'         => get_option( 'page_for_posts' ),
			'postspagelink'     => get_permalink( get_option( 'page_for_posts' ) )
		);

		$widget_ops = array(
			'classname'   => 'featured-content featuredpage',
			'description' => __( 'Displays featured page with thumbnails', 'genesis-featured-page-static-widget' ),
		);

		$control_ops = array(
			'id_base' => 'featured-page',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct( 'featured-page', __( 'Genesis - Featured Page', 'genesis-featured-page-static-widget' ), $widget_ops, $control_ops );

	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query Query object.
	 * @global integer  $more
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		global $wp_query;

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		//* Set up the author bio
		if ( ! empty( $instance['title'] ) )
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

		$wp_query = new WP_Query( array( 'page_id' => $instance['page_id'], 'posts_per_page' => 1, 'post__not_in' => get_option( 'sticky_posts' ) ) );

		if ( have_posts() ) : while ( have_posts() ) : the_post();

			genesis_markup( array(
				'html5'   => '<article %s>',
				'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
				'context' => 'entry',
			) );

			if ( $instance['page_id'] === $instance['postspage'] ) {
				$image = genesis_get_image( array(
					'post_id' => $instance['postspage'],
					'format'  => 'html',
					'size'    => $instance['image_size'],
					'context' => 'featured-page-widget',
					'attr'    => genesis_parse_attr( 'entry-image-widget' ),
				) );
			}
			else {
				$image = genesis_get_image( array(
					'format'  => 'html',
					'size'    => $instance['image_size'],
					'context' => 'featured-page-widget',
					'attr'    => genesis_parse_attr( 'entry-image-widget' ),
				) );
			}

			if ( ( $instance['page_id'] === $instance['postspage'] ) && $instance['show_image'] && $image )
				printf( '<a href="%s" title="%s" class="%s">%s</a>', $instance['postspagelink'], the_title_attribute( array( 'echo' => 0, 'post' => $instance['postspage'] ) ), esc_attr( $instance['image_alignment'] ), $image );
			elseif ( $instance['show_image'] && $image )
				printf( '<a href="%s" title="%s" class="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), esc_attr( $instance['image_alignment'] ), $image );

			$postspagecontent = get_post( get_option( 'page_for_posts' ) )->post_content;
			if ( ! empty( $instance['show_title'] ) ) {
				if ( ( $instance['page_id'] === $instance['postspage'] ) && ! empty( $postspagecontent ) ) {
					$title = get_the_title( $instance['postspage'] ) ? get_the_title( $instance['postspage'] ) : __( '(no title)', 'genesis-featured-page-static-widget' );
					if ( genesis_html5() )
						printf( '<header class="entry-header"><h2 class="entry-title"><a href="%s">%s</a></h2></header>', $instance['postspagelink'], esc_html( $title ) );
					else
						printf( '<h2><a href="%s">%s</a></h2>', $instance['postspagelink'], esc_html( $title ) );
				}
				else {
					$title = get_the_title() ? get_the_title() : __( '(no title)', 'genesis-featured-page-static-widget' );

					if ( genesis_html5() )
						printf( '<header class="entry-header"><h2 class="entry-title"><a href="%s">%s</a></h2></header>', get_permalink(), esc_html( $title ) );
					else
						printf( '<h2><a href="%s">%s</a></h2>', get_permalink(), esc_html( $title ) );
				}

			}

			if ( ! empty( $instance['show_content'] ) ) {

				echo genesis_html5() ? '<div class="entry-content">' : '';

				if ( empty( $instance['content_limit'] ) ) {

					global $more;

					$orig_more = $more;
					$more = 0;

					if ( ( $instance['page_id'] === $instance['postspage'] ) && ! empty( $postspagecontent ) ) {
						echo $postspagecontent;
					}
					else {
						the_content( $instance['more_text'] );
					}

					$more = $orig_more;

				} else {
					if ( ( $instance['page_id'] === $instance['postspage'] ) && ! empty( $postspagecontent ) ) {
						$this->get_the_home_content_limit( (int) $instance['content_limit'], esc_html( $instance['more_text'] ) );
					}
					else {
						the_content_limit( (int) $instance['content_limit'], esc_html( $instance['more_text'] ) );
					}
				}

				echo genesis_html5() ? '</div>' : '';

			}

			genesis_markup( array(
				'html5' => '</article>',
				'xhtml' => '</div>',
			) );

			endwhile;
		endif;

		//* Restore original query
		wp_reset_query();

		echo $args['after_widget'];

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'genesis-featured-page-static-widget' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'Page', 'genesis-featured-page-static-widget' ); ?>:</label>
			<?php wp_dropdown_pages( array( 'name' => $this->get_field_name( 'page_id' ), 'selected' => $instance['page_id'] ) ); ?>
		</p>

		<hr class="div" />

		<p>
			<input id="<?php echo $this->get_field_id( 'show_image' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_image' ); ?>" value="1"<?php checked( $instance['show_image'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Show Featured Image', 'genesis-featured-page-static-widget' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size', 'genesis-featured-page-static-widget' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="genesis-image-size-selector" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
				<?php
				$sizes = genesis_get_image_sizes();
				foreach ( (array) $sizes as $name => $size )
					echo '<option value="' . esc_attr( $name ) . '" ' . selected( $name, $instance['image_size'], FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . 'x' . absint( $size['height'] ) . ')</option>';
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment', 'genesis-featured-page-static-widget' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'image_alignment' ); ?>">
				<option value="alignnone">- <?php _e( 'None', 'genesis-featured-page-static-widget' ); ?> -</option>
				<option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'genesis-featured-page-static-widget' ); ?></option>
				<option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'genesis-featured-page-static-widget' ); ?></option>
				<option value="aligncenter" <?php selected( 'aligncenter', $instance['image_alignment'] ); ?>><?php _e( 'Center', 'genesis-featured-page-static-widget' ); ?></option>
			</select>
		</p>

		<hr class="div" />

		<p>
			<input id="<?php echo $this->get_field_id( 'show_title' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1"<?php checked( $instance['show_title'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Page Title', 'genesis-featured-page-static-widget' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'show_content' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_content' ); ?>" value="1"<?php checked( $instance['show_content'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Show Page Content', 'genesis-featured-page-static-widget' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'content_limit' ); ?>"><?php _e( 'Content Character Limit', 'genesis-featured-page-static-widget' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'content_limit' ); ?>" name="<?php echo $this->get_field_name( 'content_limit' ); ?>" value="<?php echo esc_attr( $instance['content_limit'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php _e( 'More Text', 'genesis-featured-page-static-widget' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
		</p>
		<?php

	}

	/**
	 * Home Content Limit function.
	 *
	 * @since 1.0.1
	 *
	 * @package GenesisFeaturedPageStaticWidget
	 */
	function get_the_home_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$postspage        = get_option( 'page_for_posts' );
		$postspagecontent = get_post( $postspage )->post_content;
		$postspagelink    = get_permalink( $postspage );

		//* Strip tags and shortcodes so the content truncation count is done correctly
		$content = strip_tags( strip_shortcodes( $postspagecontent ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		//* Remove inline styles / scripts
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		//* Truncate $content to $max_char
		$content = genesis_truncate_phrase( $content, $max_characters );

		//* More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '&#x02026; <a href="%s" class="more-link">%s</a>', $postspagelink, $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		echo apply_filters( 'get_the_home_content_limit', $output, $content, $link, $max_characters );

	}

}
