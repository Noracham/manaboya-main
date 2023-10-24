<?php get_header(); ?>
<div class="question-all">
    <div id="question-title" class="message">
        <p class="message-txt"><?php the_title(); ?></p>
    </div>
    <?php get_template_part("single_problem"); ?>
</div>
<?php get_footer(); ?>