<?php get_header(); ?>

<main id="main-content" role="main">
    <h1>Search Results</h1>

    <?php if (have_posts()) : ?>
        <ul class="search-results">
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="search-excerpt"><?php the_excerpt(); ?></div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>No results found.</p>
    <?php endif; ?>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
