<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <div class="input-group">
        <label class="screen-reader-text sr-only"><?php echo _x( 'Search for:', 'label' ) ?></label>
        <input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><?php echo esc_attr_x( 'Search', 'submit button' ) ?> <i class="fas fa-search"></i></button>
        </div>
    </div>
</form>