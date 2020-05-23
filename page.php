<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>
			

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="entry-title main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $alttext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

	<?php if(is_page(29) || is_page(175) || is_page(249) || is_page(246) || is_page(388)) : ?>

	<div class="container-custom">
		<!-- list of logos (page 29) -->
		<?php 
			// if page manufacturers 
			if(is_page(29)) : 	
			// get manufacturers 
			$body = wp_php_api('manufacturers'); 
		?>
			<div class="card-custom">
				<ul class="flex-custom">
					<?php foreach($body['manufacturers'] as $models) { ?>
					<li id="list-logos">
						<a href="http://tl-solutions.be/index.php/models?id=<?= $models['id'] ?>" >
							<img <?= "src='https://www.olsx.lu/media/resized/100x100/manufacturers/" . $models['logo'] . "'" ?> data-retina="/media/1479124989/resized/100x100/manufacturers/6d9ff469b6adcadf22723b7129b87b2b.png">
							<span id="span-logos"><?= $models['name'] ?></span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>

		<!-- list of models (page 175) -->
		<?php 
			// if models page 
			elseif(is_page(175) || is_page(246) || is_page(388) || is_page(249)) :
				// if $_GET id is valid  
				if(isset($_GET['id'])) {
					if(!preg_match("#^[0-9]{1,}$#", $_GET['id'])) {
						wp_error_404();
					}
				}
				else {
					wp_error_404();
				}
				// if $_GET motor is valid  
				if(is_page(249)) {
					if(isset($_GET['motor'])) {
						if(!preg_match("#^(petrol|diesel)$#", $_GET['motor'])) {
							wp_error_404();
						}
					}
					else {
						wp_error_404();
					}
				}
				// then get models 
				if(is_page(175)) {
					$url = "manufacturer/".$_GET['id'];
				}
				else if(is_page(246)) {
					$url = "model/".$_GET['id'];
				}
				else if(is_page(388)) {
					$url = "version/".$_GET['id'];
				}
				else if(is_page(249)) {
					$url = "version/".$_GET['id'];
				}
				
				// function (in functions.php)
				if(wp_php_api($url) == NULL) {
					wp_error_404();
				}
				// send results to the page 
				$result = wp_php_api($url); 
				// if motor page, check if data exists in $result
				if(is_page(249)) { 
					$array = array(); 
					foreach($result['engines'] as $motors) { 	
						array_push($array,$motors['powerType']);	
					} 
					if(!in_array($_GET['motor'], $array)) { 
						wp_error_404();
					}
				}
		?>
		<div class="container-scratch">
			<h1 class="h1-scratch h1-custom">
				<!-- back button -->
				<i class="fas fa-chevron-right"></i>Reprogrammation
				<?php 
					if(is_page(175)) {
						echo '<a href="http://tl-solutions.be/index.php/reprogrammation/" id="back-link">';
					}
					else if(is_page(246)) {
						echo '<a href="http://tl-solutions.be/index.php/models/?id='.$result['manufacturer']['id'].'" id="back-link">';
					}
					else if(is_page(388)) {
						echo '<a href="http://tl-solutions.be/index.php/versions/?id='.$result['model']['id'].'" id="back-link">';
					}
					else if(is_page(249)) {
						echo '<a href="http://tl-solutions.be/index.php/motorisation/?id='.$result['id'].'" id="back-link">';
					}
				?>
					<i class="fas fa-chevron-left"></i>
					<?php 
						if(is_page(175)) {
							echo 'Choix de la marque';
						}
						else if(is_page(246)) {
							echo 'Choix du modèle';
						}
						else if(is_page(388)) {
							echo 'Choix de la version';
						}
						else if(is_page(249)) {
							echo 'Choix du carburant';
						}
					?>	
				</a>
			</h1>
			<div class="titles-scratch">
				<ol>
					<li>
					<!-- logo and name -->
						<a <?= 'href="http://tl-solutions.be/index.php/models/?id='.$result['manufacturer']['id'].'"' ?> >
						    <?php if(is_page(175)) { ?>
							<img <?= 'src="https://www.olsx.lu/media/resized/100x100/manufacturers/' . $result['logo'] . '"' ?> class="logo-model"/>
							<span class="span-models"><?= $result['name'] ?></span>
							<?php } else { ?>
							<img <?= 'src="https://www.olsx.lu/media/resized/100x100/manufacturers/' . $result['manufacturer']['logo'] . '"' ?> class="logo-model"/>
							<span class="span-models"><?= $result['manufacturer']['name'] ?></span>
							<?php } ?>
						</a>
					</li>
					<!-- breadcumb -->
					<li <?php if(is_page(175)) { echo 'class="lasts-child active"'; } else { echo 'class="lasts-child"'; } ?> >
						<a>Modèle</a>
					</li>
					<li <?php if(is_page(246)) { echo 'class="lasts-child active"'; } else { echo 'class="lasts-child"'; } ?> >
						<a>Version</a>
					</li>
					<li <?php if(is_page(388)) { echo 'class="lasts-child active"'; } else { echo 'class="lasts-child"'; } ?>>
						<a>Motorisation</a>
					</li>
					<li <?php if(is_page(249)) { echo 'class="lasts-child active"'; } else { echo 'class="lasts-child"'; } ?> >
						<a>Moteur</a>
					</li>
					<li class="lasts-child">
						<a>Configuration</a>
					</li>
				</ol>
				<!-- Model and Version -->
				<?php if(is_page(246)) { ?>
				<h2 class="h2-type"><?= $result['name'] ?></h2>
				<?php } elseif(is_page(388)) { 
					// powerType FR
					if($_GET['motor'] == "petrol") { $powerType = 'Essence'; } else if($_GET['motor'] == "diesel") { $powerType = 'Diesel'; } ?>
				<h2 class="h2-type"><?= $result['model']['name'] . ' <span style="font-size:40px;">' . $result['from'] ?></h2>
				<?php } elseif(is_page(249)) {
					// powerType FR 
					if($_GET['motor'] == "petrol") { $powerType = 'Essence'; } else if($_GET['motor'] == "diesel") { $powerType = 'Diesel'; } ?>
				<h2 class="h2-type"><?= $result['model']['name'] . ' <span style="font-size:40px;">' . $result['from'] . '</span> <span style="font-size:30px;">' . $powerType  . '</span>' ?></h2>
				<?php } ?>
				<span class="span-action">
					<i class="fas fa-chevron-down"></i><span class="span-chevron-bottom">Sélectionnez votre modèle</span>
				</span>
			</div>
		</div>
		<!-- display results -->
		<ul class="flex-custom flex-custom-models">
			<?php if(is_page(175)) { ?>
				<!-- models -->
				<?php foreach($result['models'] as $result) { ?>
					<li class="elements">	
						<a href="http://tl-solutions.be/index.php/versions/?id=<?= $result['id'] ?>" >
							<span><?= $result['name'] ?></span> 
						</a>
					</li>
				<?php } ?>
			<!-- version -->
			<?php } else if(is_page(246)) { ?>
				<?php foreach($result['versions'] as $versions) { ?>
					<li class="elements">
						<a href="http://tl-solutions.be/index.php/motorisation/?id=<?= $versions['id'] ?>">
							<span><?= $versions['from'] ?></span>
						</a>
					</li>
				<?php } ?>
			<!-- motorisation -->
			<?php } else if(is_page(388)) { ?>
				<?php 
					// check if one or more motorisation 
					$array = array(); 
					foreach($result['engines'] as $motors) { 	
						array_push($array,$motors['powerType']);	
					} 
					if(in_array('diesel', $array) && in_array('petrol', $array)) { ?>
					<!-- if several motorisation, then display choice -->
					<li class="elements">
						<!-- each time redirect to "moteurs" page with motorisation type -->
						<a href="http://tl-solutions.be/index.php/moteurs/?id=<?= $result['id'] ?>&amp;motor=petrol">
							<span>Essence</span>
						</a>
					</li>
					<li class="elements">
						<a href="http://tl-solutions.be/index.php/moteurs/?id=<?= $result['id'] ?>&amp;motor=diesel">
							<span>Diesel</span>
						</a>
					</li>
			  	<?php } elseif (in_array('diesel', $array) || in_array('petrol', $array)) { 
					if(in_array('diesel', $array)) { ?>
						<li class="elements">
							<a href="http://tl-solutions.be/index.php/moteurs/?id=<?= $result['id'] ?>&amp;motor=diesel">
								<span>Diesel</span>
							</a>
						</li>
					<?php } 
					else if(in_array('petrol', $array)) { ?>
						<li class="elements">
							<a href="http://tl-solutions.be/index.php/moteurs/?id=<?= $result['id'] ?>&amp;motor=petrol">
								<span>Essence</span>
							</a>
						</li>
					<?php } 
				   } ?>
			<!-- engine name -->
			<?php } else if(is_page(249)) { ?>
				<!-- display engine name result relativly to motorisation type -->
				<?php if($_GET['motor'] == 'diesel') { ?>
	
					<?php foreach($result['engines'] as $motors) { ?>
						<?php if($motors['powerType'] == 'diesel') { ?>
							<li class="elements">
								<a href="#">
									<?= $motors['uri'] ?>
								</a>
							</li>
						<?php } ?>
					<?php } ?>

				<?php } else if($_GET['motor'] == 'petrol') { ?>
					
					<?php foreach($result['engines'] as $motors) { ?>
						<?php if($motors['powerType'] == 'petrol') { ?>
							<li class="elements">
								<a href="#">
									<?= $motors['uri'] ?>
								</a>
							</li>
						<?php } ?>
					<?php } ?>

				<?php } ?>
				
            <?php } ?>

		</ul>		
    </div>

    <?php endif; ?>
    
<?php endif; ?>

</div> <!-- #main-content -->

<?php

get_footer();
