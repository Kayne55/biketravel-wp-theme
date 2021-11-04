<div class="bt-article-meta">
                    <span>
                        <i class="far fa-user-circle"></i>
                        <a href="#"> <?php the_author(); ?> </a>
                    </span>
                    <span>
                        <i class="far fa-clock"></i>
                        <a href="#"> <?php the_date(); ?> </a>
                    </span>
                    <span>
                        <i class="far fa-folder"></i>
                        <a href="#"> <?php the_category(', '); ?> </a>
                    </span>
                    <span>
                        <i class="far fa-comment"></i>
                        <a href="#"> <?php comments_number(); ?></a>
                    </span>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-12">

                <?php
                    the_content();
                ?>
            </div>
        </div>
        <div class="row py-4">
            <div class="col-12">
                <span class="bt-article-tags"><?php the_tags( $before = null, $sep = ', ', $after = '' ) ?></span>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-6">
                <?php previous_post_link( '<span><i class="fas fa-chevron-left"></i> %link</span>' ) ?>
            </div>
            <div class="col-6 text-right">
                <?php next_post_link( '<span>%link <i class="fas fa-chevron-right"></i></span>' ) ?>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-12">
                <?php
                    comments_template();
                ?>
            </div>
        </div>