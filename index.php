<?php
/**
 * The main template file
 *
 */

get_header(); ?>
<div class="container">
    <div class="row">
        <?php 
        $query = new WP_Query(
            [
                'post_type' =>  [
                    'post', 
                    'book'
                ]
            ]
        );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) :
                $query->the_post();
                get_template_part( 'template-parts/card', get_post_type() );
            endwhile;
        } else {
            echo 'No posts!';
        }
        ?>
    </div>
</div>

<?php get_footer();