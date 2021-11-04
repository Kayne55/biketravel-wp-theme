<?php
	global $post;
	$post_id     = $post->ID;
	$itineraries = get_post_meta( $post_id, 'wp_travel_trip_itinerary_data' );
if ( isset( $itineraries[0] ) && ! empty( $itineraries[0] ) ) : ?>
		
				<h2 class="bt-display-heading bt-fontprimary text-center"><?php esc_html_e( 'Tour Itinerary', 'wp-travel' ); ?></h2>
					<?php $index = 1; ?>
					<?php foreach ( $itineraries[0] as $key => $itinerary ) : ?>
		
						<?php

						$date_format = get_option( 'date_format' );
						$time_format = get_option( 'time_format' );

						$itinerary_label = '';
						$itinerary_title = '';
						$itinerary_desc  = '';
						$itinerary_date  = '';
						$itinerary_time  = '';
						if ( isset( $itinerary['label'] ) && '' !== $itinerary['label'] ) {
							$itinerary_label = stripslashes( $itinerary['label'] );
						}
						if ( isset( $itinerary['title'] ) && '' !== $itinerary['title'] ) {
							$itinerary_title = stripslashes( $itinerary['title'] );
						}
						if ( isset( $itinerary['desc'] ) && '' !== $itinerary['desc'] ) {
							$itinerary_desc = stripslashes( $itinerary['desc'] );
						}
						if ( isset( $itinerary['date'] ) && '' !== $itinerary['date'] ) {
							$itinerary_date = wp_travel_format_date( $itinerary['date'] );
						}
						if ( isset( $itinerary['time'] ) && '' !== $itinerary['time'] ) {
							$itinerary_time = stripslashes( $itinerary['time'] );
							$itinerary_time = date( $time_format, strtotime( $itinerary_time ) );
						}
						if ( isset( $itinerary['image'] ) && '' !== $itinerary['image'] ) {
							$image_id   = $itinerary['image'];
							$image_data = wp_get_attachment_image_src( $image_id, 'medium' );
						}
						?>
						<div class="card my-3">
							<div class="row">
								<div class="col-lg-4">
									<div class="bt-tripcard-list-image" style="background-image: url('<?php echo $image_data[0]; ?>');">
									</div>
								</div>
								<div class="col-lg-8">
									<div class="card-body" style="height: 100%;">
										<h3 class="bt-display-heading bt-fontprimary">
											<?php if ( '' !== $itinerary_label ) : ?>
												<?php echo esc_html( $itinerary_label ) . ' - '; ?>
											<?php endif; ?>
											<?php if ( '' !== $itinerary_title ) : ?>
												<?php echo esc_html( $itinerary_title ); ?>
											<?php endif; ?>
										</h3>
										<p class="bt-display-heading bt-itinerary-date">
											<?php if ( $itinerary_date ) : ?>
												<small><i class="far fa-calendar-alt"></i></small>&nbsp;<?php echo esc_html( $itinerary_date ) . ' | '; ?>
											<?php endif; ?>
											<?php if ( $itinerary_time ) : ?>
												<small><i class="far fa-clock"></i></small>&nbsp;<?php echo esc_html( $itinerary_time ); ?>
											<?php endif; ?>
										</p>
										<div class="bt-itinerary-desc">
											<i class="fas fa-chevron-up bt-fontprimary"></i>
											<p>
												<?php echo wp_kses_post( $itinerary_desc ); ?>
											</p>
											<i class="fas fa-chevron-down bt-fontprimary"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $index++; ?>
					<?php endforeach; ?>

	<?php endif; ?>
