<?php
/**
 * Template part for displaying post cards
 */

?>
<div class="col-4">
    <div class="card">
        <div class="card-body">
            <?php the_title('<h4 class="card-title">', '</h2>'); ?>
            <div class="card-text"><?php the_excerpt();?></div>
            <?php echo sprintf( '<a class="btn btn-outline btn-success" href="%s">%s</a>', esc_url( get_permalink()), 'Go to the article'  ); ?>
        </div>
    </div>
</div>