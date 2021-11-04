<div class="container bt-archive">
    <div class="row my-5">
        <div class="col-sm-2">
            <img class="img-thumbnail img-fluid" src="<?php the_post_thumbnail_url( 'thumbnail' ); ?>" alt="<?php the_title(); ?>">
        </div>
        <div class="col-sm-10">
            <a href="<?php the_permalink(); ?>">
                <h2 class="bt-display-heading bt-fontprimary">
                    <?php the_title(); ?>
                </h2>
            </a>
            <small>
                <i class="far fa-user-circle"></i> <?php the_author(); ?> - <i class="far fa-clock"></i> <?php the_date(); ?> - <i class="far fa-folder"></i> <?php the_category(', '); //$category = get_the_category(); echo $category[0]->cat_name; ?> - <i class="far fa-comment"></i> <?php comments_number(); ?>
            </small>

            <p>
                <?php the_excerpt(); ?>
            </p>
            <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary">
                Read More
            </a>
        </div>
    </div>
</div>