		<div class="slider-wrapper theme-default">
			
			<div id="slider" class="nivoSlider <?php echo of_get_option('gamepress_color_scheme','red'); ?>">
		
			<?php
				
				$tmp = $wp_query;
				$cat = of_get_option('gamepress_slider_category');
				$wp_query = new WP_Query('cat='.$cat.'');
				if(have_posts()) :
					while(have_posts()) :
						the_post();
			?>
			
				<?php 
					if(wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'nivo-slide')) { 
						$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'nivo-slide');
					}else {
						$image[0] = get_template_directory_uri()."/images/nivo-slide-placeholder.jpg";
					} 
				?>
			

				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
					<img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="#htmlcaption_<?php the_ID(); ?>" />
				</a>
				
				<?php endwhile; ?>
				
			<?php endif; ?>
			</div>
			
			<?php
			if(have_posts()) :
				while(have_posts()) :
					the_post();
			?>
			
			<div id="htmlcaption_<?php the_ID(); ?>" class="nivo-html-caption">
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php gamepress_excerpt('gamepress_excerptlength_teaser', 'gamepress_morelink'); ?>
			</div>
			
			<?php endwhile; ?>

			<?php endif;
			$wp_query = $tmp;
			?>
		
		</div>