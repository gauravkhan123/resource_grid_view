<!-- Background Image Section -->
<section class="bg-image">
    <div class="container text-center">
        <h1 class="text-white">Resource Library </h1>
        <p class="text-white">How to get most out of unified Communications</p>
    </div>
</section>

<!-- Blog Listing Section -->
<section class="py-5 grid-section">
    <div class="container">
        <div class="row">
            <?php

            $args = array(
                'post_type' => 'wp_resources',
                'post_status'   => 'publish',
                'post__in'  => $id,
                'orderby' => $orderby,
                'posts_per_page' => 3
            );

            $my_query = new WP_Query($args);
            // echo "<pre>";
            // print_r($my_query);
            // echo "</pre>";
            if ($my_query->have_posts()) :
                while ($my_query->have_posts()) : $my_query->the_post();

                    $button_text = get_post_meta(get_the_ID(), 'resource_grid_link_text', true);
                    $button_url = get_post_meta(get_the_ID(), 'resource_grid_link_url', true);

            ?>
                    <!-- Blog Post Box 1 -->
                    <div class="col-md-4 mb-4">
                    <div class="blog-post-box">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('full', array('class' => 'img-fluid'));
                            } else {
                                echo wp_resources_get_placeholder_image();
                            }

                            ?>
                            
                            <h3 class="mt-3"><?php the_title(); ?></h3>
                            <p><?php the_excerpt(); ?></p>
                            <a href="<?php echo the_permalink(); ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>
<style>
    /* Background Image Section Styles */
    .bg-image {
        background: url('<?php echo WP_RESOURCES_URL; ?>assets/images/Green-bg.png') no-repeat center center/cover;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* .grid-section
    {
        
    } */
    /* Blog Post Box Styles */
    .blog-post-box {
        border: 1px solid #ccc;
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .blog-post-box:hover {
        transform: scale(1.05);
    }
</style>