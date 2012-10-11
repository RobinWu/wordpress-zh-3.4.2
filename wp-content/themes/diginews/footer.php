
	<footer id="colophon" role="contentinfo">
		<div id="site-generator">
			<?php do_action( 'diginews_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'diginews' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'diginews' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'diginews' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<a href="<?php echo esc_url( __( 'http://citizenjournal.net/diginews-theme/', 'diginews' ) ); ?>" rel="designer"><?php printf( __( '%s Theme', 'diginews' ), 'Diginews' ); ?></a> 
		</div>
	</footer><!-- #colophon -->
</div><!-- #container -->

<?php wp_footer(); ?>

</body>
</html>