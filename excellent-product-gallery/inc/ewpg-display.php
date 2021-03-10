<?php 
/**
 * Single Product Page Display 
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global  $woocommerce, $post, $product;
 
/**
 * Get the value of a settings field
 */
$layout = ewpg_get_option( 'layout', 'genaral_options', 'horizontal');
$lightbox = ewpg_get_option( 'lightbox', 'genaral_options', 'false');
$thum2show = ewpg_get_option( 'thum2show', 'genaral_options', '4');
$thumscrollby = ewpg_get_option( 'thumscrollby', 'genaral_options', '3');
$infinite = ewpg_get_option( 'infinite', 'genaral_options', 'false');
$dragging = ewpg_get_option( 'dragging', 'genaral_options', 'false');
$rtl = ewpg_get_option( 'rtl', 'genaral_options', 'false');
$autoplay = ewpg_get_option( 'autoplay', 'genaral_options', 'false');
$autoplaySpeed = ewpg_get_option( 'autoplaySpeed', 'genaral_options', '3000');
$nav_icon_color = ewpg_get_option( 'nav_icon_color', 'genaral_options','#fff');
$nav_bg_color = ewpg_get_option( 'nav_bg_color', 'genaral_options','#000');


$single_hide_thumb = ewpg_get_option( 'hide_thumb', 'single_options','false');
$single_hide_nav = ewpg_get_option( 'hide_nav', 'single_options','true');
$single_fade = ewpg_get_option( 'fade', 'single_options','false');
$single_swipe = ewpg_get_option( 'swipe', 'single_options','true');
$resize_height = ewpg_get_option( 'resize_height', 'single_options','false');
$single_dots = ewpg_get_option( 'dots', 'single_options','false');
$single_hide_gallery = ewpg_get_option( 'hide_gallery', 'single_options','false');
$single_autoplaySpeed = ewpg_get_option( 'autoplaySpeed', 'single_options', '5000');


$disable_lightbox = ewpg_get_option( 'disable_lightbox', 'lightbox_options','false');
$lightbox_arrowsColor = ewpg_get_option( 'arrowsColor', 'lightbox_options','#fff');
$lightbox_bgcolor = ewpg_get_option( 'bgcolor', 'lightbox_options','#fff');
$lightbox_borderwidth = ewpg_get_option( 'borderwidth', 'lightbox_options','5');
$lightbox_spinColor = ewpg_get_option( 'spinColor', 'lightbox_options','#fff');
$lightbox_spinner = ewpg_get_option( 'spinner1', 'lightbox_options','double-bounce');
$lightbox_numeratio = ewpg_get_option( 'numeratio', 'lightbox_options','true');
$lightbox_titlePosition = ewpg_get_option( 'titlePosition', 'lightbox_options','bottom');
$lightbox_titleBackground = ewpg_get_option( 'titleBackground', 'lightbox_options','#000000');
$lightbox_titleColor = ewpg_get_option( 'titleColor', 'lightbox_options','#fff');
$lightbox_infinite = ewpg_get_option( 'lightbox_infinite', 'lightbox_options','false');
$lightbox_framewidth = ewpg_get_option( 'lightbox_framewidth', 'lightbox_options','1024');


$zoom_zoom_start = ewpg_get_option( 'zoom_start', 'single_options','false');


$lightbox_class = '';

if($lightbox == 'true'){
	$lightbox_class = 'venobox';
}

?>


<div class="images main-wrap">

<div class="ewpg-display" <?php if($rtl == 'true'): echo ' dir="rtl" '; endif; ?>>
<?php 

	if ( has_post_thumbnail() ) {
	$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );		
	$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
	$image = get_the_post_thumbnail( $post->ID,'shop_single', array( 'data-tzoom' => $image_link ));
	


	if($disable_lightbox == 'false'){

	echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '
				<div class="woocommerce-product-gallery__image single-product-main-image">
					<a  class="venobox %s" data-gallery="ewpg-thumbs" >%s</a>
				</div>',
				 $image_title, $image ), $post->ID );

	}else{
		
	echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '
				<div class="woocommerce-product-gallery__image single-product-main-image">
					<div class=" %s"  data-gallery="ewpg-thumbs" >%s</div>
				</div>',
				 $image_title, $image ), $post->ID );
	}
		

	if($lightbox == 'false') : // Setting lightbox Condition
			if ( $woocommerce->version >= '3.0' ){
				$attachment_ids = $product->get_gallery_image_ids();
			}else{
				$attachment_ids = $product->get_gallery_attachment_ids();
			}

			if ($attachment_ids) {

			
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					$shop_single_img = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
					$title           = get_post_field( 'post_title', $attachment_id );

					/**
				 * Check if Gallery have Video URL
				 */
				$ewpg_video = get_post_meta($attachment_id, 'ewpg_video_url', true); 
				$datatype = 'data-vbtype="video"';
				$watermark_class = 'ewpg-video-thumb';
				if(empty($ewpg_video)) {

					$ewpg_video = $full_size_image[0];
					$datatype = '';
					$watermark_class = '';
				}

					
			 		if($disable_lightbox == 'false'){
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '
						<div>
							<a class="venobox %s" href="%s" %s data-title="%s" data-gall="ewpg-thumbs" ><img data-lazy="%s" data-tzoom="%s" ></a>
						</div>',
						$watermark_class,$ewpg_video,$datatype, $title, $shop_single_img[0],$full_size_image[0]  ), $attachment_id );
					 }
					 else{
						 
								echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '
							<div>
								<div class="%s" ><img data-lazy="%s" data-tzoom="%s" ></div>
							</div>',
							$watermark_class,$shop_single_img[0],$full_size_image[0]  ), $attachment_id );
					 }
				
				}
			}
		endif; // Lightbox Condition 
		} 
		else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}
?>
</div>
<?php 
// Feature Image Hide thumbnail options 
if($single_hide_thumb == 'false') : ?>
			
		
<?php 
if ( $woocommerce->version >= '3.0' ){
		$attachment_ids = $product->get_gallery_image_ids();
	}else{
		$attachment_ids = $product->get_gallery_attachment_ids();
	}
?>
<div class="slider-nav" id="slide-nav-pgs" <?php if($rtl == 'true'): echo ' dir="rtl" '; endif; ?> >
<?php

if ( $attachment_ids && has_post_thumbnail() ) {

	$image_thumb = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' ), 'ewpg');

	if($lightbox == 'false') :
	
   /**
	 * Check if Gallery have Video URL
	 */
	$popup_link = get_post_meta(get_post_thumbnail_id(), 'ewpg_video_url', true);
	$datatype = 'data-vbtype="video"';
	$watermark_class = 'ewpg-video-thumb';
	$href = 'href';
	if(empty($popup_link)) {

		$popup_link = $image_link;
		$datatype = '';	
		$watermark_class = '';
	}
	if($lightbox == 'false'){
		$href = 'data-href';
	}
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '
				<div>
				<a class="product-gallery__image_thumb %s %s" data-title="%s" data-gall="pgs-thumbs" %s="%s" %s >%s</a>
				</div>',
				$lightbox_class,$watermark_class,$image_title,$href,$popup_link,$datatype, $image_thumb), $post->ID );
		

	endif; // Lightbox Condtion End
	foreach ( $attachment_ids as $attachment_id ) {
		$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		$title           = get_post_field( 'post_title', $attachment_id );

		$ewpg_video = get_post_meta($attachment_id, 'ewpg_video_url', true);
		$datatype = 'data-vbtype="video"';
		$watermark_class = 'ewpg-video-thumb';
		$href = 'href';

		
		if($lightbox == 'false'){
			$href = 'data-href';
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '
				<div><a class="%s %s" data-title="%s" data-gallery="ewpg-thumbs" %s="%s" %s><img src="%s"></a></div>',
				 $lightbox_class,$title,$watermark_class,$href,$ewpg_video, $datatype,$thumbnail[0] ), $attachment_id );
	}
	
}

?>
</div>

<?php

 endif; ?>

</div>
<?php 

if(count($attachment_ids) < $thum2show ){
	$thum2show = count($attachment_ids)+1;
}

?>

<script>
jQuery.noConflict();
(function( $ ) {
  $(function() {
    // More code using $ as alias to jQuery
    <?php if($single_hide_thumb == 'false') : ?>
    
    
    <?php endif; ?>
    $(document).ready(function(){
	    $('.venobox').venobox({
	    	framewidth: '<?php echo $lightbox_framewidth; ?>px',
	    	titleattr: 'data-title',
	    	titleBackground: '<?php echo $lightbox_titleBackground; ?>',
	    	titleBackground: '<?php echo $lightbox_titleBackground; ?>',
	    	titleColor: '<?php echo $lightbox_titleColor; ?>',
	    	numerationColor: '<?php echo $lightbox_titleColor; ?>',
	    	arrowsColor: '<?php echo $lightbox_borderwidth; ?>',
	    	titlePosition: '<?php echo $lightbox_titlePosition; ?>',
	    	numeratio: <?php echo $lightbox_numeratio; ?>,
	    	spinner : '<?php echo $lightbox_spinner; ?>',
	    	spinColor: '<?php echo $lightbox_spinColor; ?>',
	    	border: '<?php echo $lightbox_borderwidth; ?>px',
	    	bgcolor: '<?php echo $lightbox_bgcolor; ?>',
	    	infinigall: <?php echo $lightbox_infinite; ?>,
	    	numerationPosition: '<?php echo $lightbox_titlePosition; ?>'
	    });
	   
	    // go to next item in gallery clicking on .next
    $(document).on('click', '.vbox-next', function(e){
      $('.ewpg-display .btn-next').trigger( "click" );
    });
     

	  <?php if($lightbox == 'false'):  ?>

		  $('.ewpg-display').slick({
  		  accessibility: false,//prevent scroll to top
  		  lazyLoad: 'progressive',
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: true,
		  fade: <?php echo $single_fade; ?>,
		  swipe :<?php echo $single_swipe; ?>,
   		 
		 
		  <?php if($rtl == 'false'): ?>
	   		prevArrow: '<i class="btn-prev dashicons dashicons-arrow-left-alt2"></i>',
		  	nextArrow: '<i class="btn-next dashicons dashicons-arrow-right-alt2"></i>',
		  <?php ; endif; ?>
		  rtl: <?php echo $rtl; ?>,
		  infinite: <?php echo $infinite; ?>,
		  autoplay: <?php echo $autoplay; ?>,
		  pauseOnDotsHover: true,
			<?php if($resize_height == 'true'): ?>
	   	adaptiveHeight: true,
		  <?php ; endif; ?>
			
		  autoplaySpeed: '<?php echo $autoplaySpeed; ?>',

		  <?php if($single_hide_thumb == 'false') : ?>
		  asNavFor: '#slide-nav-pgs',
		  <?php endif; ?>
		  dots :<?php echo $single_dots; ?>,
  
			});

		  <?php endif; ?>
		

	    $('#slide-nav-pgs').slick({
			accessibility: false,//prevent scroll to top
			isSyn: false,//not scroll main image

		  slidesToShow: <?php echo $thum2show; ?>,
		  slidesToScroll: <?php echo $thumscrollby; ?> ,
		  infinite: <?php echo $infinite; ?>,
		  <?php if($lightbox == 'false'): echo 'asNavFor: \'.ewpg-display\',' ; endif; ?>

		  <?php if($rtl == 'false'): ?>
		   prevArrow: '<i class="btn-prev dashicons dashicons-arrow-left-alt2"></i>',
		  nextArrow: '<i class="btn-next dashicons dashicons-arrow-right-alt2"></i>',
		  <?php ; endif; ?>

		  dots: false,
		 	centerMode: false,
		 
	   	  rtl: <?php echo $rtl; ?>,
		  vertical: <?php if($layout == 'vertical' || $layout == 'vertical_r'): echo'true'; else : echo'false' ;endif; ?>,

		  draggable: <?php echo $dragging; ?>,
		  focusOnSelect: true,

		 responsive: [
		    {
		      breakpoint: 767,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 1,
		        vertical: false,
		        draggable: true,
		        autoplay: false,//no autoplay in mobile
				isMobile: true,// let custom knows on mobile
				arrows: false //hide arrow on mobile
		      }
		    },
		    ]
		});

	    

		<?php if($single_hide_thumb == 'true' or count($attachment_ids) == '0') : ?>
			$('#slide-nav-pgs').slick('unslick');
		<?php endif; ?>

	
	
	$('.woocommerce-product-gallery__image img').load(function() {

	    var imageObj = $('.woocommerce-product-gallery__image a');

	<?php if($zoom_zoom_start == 'true') : ?>
		
	    var variableIMG = imageObj.attr('href');
   		$('.woocommerce-product-gallery__image img').zoom({
				touch: false,
				url: variableIMG	
				
			});
	  
	<?php endif; ?> 

	    if (!(imageObj.width() == 1 && imageObj.height() == 1)) {
	    	$('.ewpg-display .woocommerce-product-gallery__image , #slide-nav-pgs .slick-slide .product-gallery__image_thumb').trigger('click');
	   			$('.woocommerce-product-gallery__image img').trigger('zoom.destroy');
	   				<?php if($zoom_zoom_start == 'true') : ?>
		
					   $('.woocommerce-product-gallery__image img').wrap('<span style="display:inline-block"></span>').parent().zoom({
							touch: false,
						});
					  
					<?php endif; ?> 
	   			


	    }
	});
	<?php if($zoom_zoom_start == 'true') : ?>

    	$('.ewpg-display img').load(function() {
			$(this).wrap('<span style="display:inline-block"></span>').parent().zoom({
				touch: false,
				url: this.getAttribute("data-tzoom")
				
			});

		});
		$('.ewpg-display img').wrap('<span style="display:inline-block"></span>').parent().zoom({
				touch: false,

			});
	<?php endif; ?> 

	});
  });
})(jQuery);	
</script>

<style>


<?php
if($single_hide_nav == 'true') : ?>

.ewpg-display .btn-prev, .slider-nav .btn-prev { opacity: 1 !important; margin-left: 0; }
.ewpg-display .btn-next, .slider-nav .btn-next { margin-right: 0; opacity: 1 !important; }

<?php endif; ?>
<?php if($layout == 'vertical_r' && $single_hide_thumb == 'false') : ?>
.ewpg-display {
width: 79%;
float: left;
margin-right: 1%;
}
.slick-vertical:hover .btn-prev, .slick-vertical:hover .btn-next{
	margin-left: -15px !important;
}
@media only screen and (max-width: 767px) {
   .ewpg-display {
	 width: 100%;
    float: none;
    margin-left: 0%;

}
.slider-nav .btn-next,.slider-nav .btn-prev{
	margin: 0px;
}
}
<?php endif; ?>

<?php if($layout == 'vertical' && $single_hide_thumb == 'false') : ?>
	.ewpg-display {
	 width: 79%;
    float: right;
    margin-left: 1%;

}
@media only screen and (max-width: 767px) {
   .ewpg-display {
	 width: 100%;
    float: none;
    margin-left: 0%;

}
.slider-nav .btn-next,.slider-nav .btn-prev{
	margin: 0px;
}
}
<?php elseif($layout == 'vertical' && $single_hide_thumb == 'true') : ?>
.ewpg-display {
	 width: 100%;
}
<?php else : ?>

.slider-nav:hover .btn-prev,.slider-nav:hover .btn-next {  
    margin: 0px;
	}
<?php endif; ?>
<?php if($single_hide_gallery == 'true'){ ?>

#slide-nav-pgs {
    display: none;
}
.ewpg-display{
	width: 100%;
	margin: 0px;
}
<?php } ?>

<?php if(count($attachment_ids) == '0') : ?>

/* If Product don't have any Gallery Image*/
#slide-nav-pgs{
	display: none;
}
.ewpg-display{
	width: 100%;
}
<?php endif; ?>

<?php if($lightbox == 'true'){
	?>
	.slick-slide {    
       opacity: 1;       
		}
	<?php
}
?>
<?php if($single_dots == 'true') : ?>
.slick-dotted.slick-slider {
    margin-bottom: 10px;
}

<?php endif; ?>


	.btn-prev, .btn-next{
		color: <?php echo $nav_icon_color; ?>;
		background:<?php echo $nav_bg_color; ?>;
	}
	.slick-prev:before, .slick-next:before{
		color: <?php echo $nav_icon_color; ?>;
		
	}

#slide-nav-pgs img {width: auto;}

</style>