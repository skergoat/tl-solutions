<?php
if ( et_theme_builder_overrides_layout( ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE ) || et_theme_builder_overrides_layout( ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE ) ) {
    // Skip rendering anything as this partial is being buffered anyway.
    // In addition, avoids get_sidebar() issues since that uses
    // locate_template() with require_once.
    return;
}

/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */
do_action( 'et_after_main_content' );

if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer" style="background:url('http://tl-solutions.be/wp-content/uploads/2020/05/bg-2.png') center top no-repeat;background-size:100% 9px;padding-top:30px;padding-bottom:30px;">
				<div class="container-custom">
					<div class="flex-custom">
						<div style="width:50%;">
							<img src="http://tl-solutions.be/wp-content/uploads/2020/05/footer-logo.jpg" width="100" alt="TL Logo" />
						</div>
						<div style="width:50%;display:flex;align-items: center;font-size:12px;">
							<p class="copyright">Copyright © 2020 TLPerformance. Tous droits réservés. Reprogrammation de la cartographie moteur sur banc de puissance</p>	
						</div>
					</div>
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
</body>
</html>
