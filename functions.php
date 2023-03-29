<?php

/** 
 * Add theme support for title-tag and html5.
 */
    
add_theme_support( 'title-tag' );
add_theme_support( 'html5', ['style', 'script'] );

/**
 * Enqueue styles
 */

wp_enqueue_style( 'style', get_stylesheet_uri() );
wp_register_style( 'bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
wp_enqueue_style( 'bootstrap5' );

 /**
  * Enqueue scripts
  */
wp_enqueue_script( 'script', get_template_directory_uri() . 'src/js/script.js', ['jquery'], 1.1, true);
wp_enqueue_script( 'bootstrap5js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', [], true );


/**
 * Register post types
 */
function register_book_post_type() {
register_post_type( 'book', [
    'labels' => [
        'name'          => __('Books', 'gamelounge'),
        'singular_name' => __('Book', 'gamelounge'),
    ],
    'public' => true,
    'rewrite' => ['slug' => 'books' ],
    'supports' => ['title', 'editor', 'excerpt']
] );
}
add_action( 'init', 'register_book_post_type');

/**
 * Adding book metabox
 */

function add_book_tagline_meta_box() {
    add_meta_box(
        'book_tagline_meta_box',
        'Book Tagline',
        'show_book_tagline_meta_box',
        'book',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_book_tagline_meta_box');

//show
function show_book_tagline_meta_box($post) {
    $tagline = get_post_meta($post->ID, '_book_tagline', true);
    ?>
    <textarea name="book_tagline" id="book_tagline"><?php echo $tagline; ?></textarea>
    <?php
}

//save
function save_book_tagline_meta_box($post_id) {
    if (isset($_POST['book_tagline'])) {
        $tagline = sanitize_text_field($_POST['book_tagline']);
        update_post_meta($post_id, '_book_tagline', $tagline);
    }
}
add_action('save_post', 'save_book_tagline_meta_box');


/**
 * Change document title if book
 */
add_filter( 'the_title', 'custom_document_title_parts', 15, 1);
function custom_document_title_parts( $title ) {
    
    if ( get_post_type() === 'book' ) {
        $tagline = get_post_meta( get_the_ID(), '_book_tagline', true );
        if ( $tagline ) {
            $title = $tagline;
        }
    }
    return $title;
}


/**
 * Alter the main query to include "book" post type
 */
add_action( 'pre_get_posts', 'add_book_to_index_query' );
function add_book_to_index_query( $query ) {
    if ( $query->is_main_query() && $query->is_home() ) {
        $query->set( 'post_type', [ 'post', 'book' ] );
    }
}