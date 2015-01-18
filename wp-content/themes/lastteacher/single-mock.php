<?php get_header(); ?>

	<div id="placeholder">
		Please wait while we setup the test environment.
	</div>

	<div id="unavailable" style="display:none">
		This exam is currently running by you in another window. Multiple windows are not allowed.
	</div>

	<div id="main" style="display:none">
		<div id="test">
			<div class="subjects"></div>
			<div class="question">
				<span class="index"></span>) <span class="text"></span>
				<div class="options"></div>
			</div>
		</div>
		<div id="list">
			<div class="name"></div>
			<h3>Time Left</h3>
			<span class="timer">
				<span class="hours"></span>
				<span class="minutes"></span>
			</span>
			<div class="questions"></div>
		</div>
		<div id="actions">
			<div class="col1">
				<div class="action" data-action="mark-review">Mark Review and Next</div>
				<div class="action" data-action="question-paper">Not used</div>
			</div>
			<div class="col2">
				<div class="action" data-action="pause">Pause</div>
			</div>
			<div class="col3">
				<div class="action" data-action="save">Save and Next</div>
				<div class="action" data-action="instructions">Instructions</div>
			</div>
		</div>
		<div id="submit">
			<div class="keys">
				<div class="key">
					Answered <span class="marker green"></span>
					Not Answered <span class="marker red"></span>
					Mark For Review <span class="marker purple"></span>
					Not Visited <span class="marker white"></span>
				</div>
				<div class="submit">
					Submit Test
				</div>
			</div>
		</div>
	</div>

<?php ob_start(); ?>
	<script type="text/javascript">
		initiate_mock({
			ID:<?php echo get_post_meta( get_the_ID(), '_saved_ext_id', true ); ?>
		});
	</script>
<?php add_action( 'wp_footer', create_function( '', 'echo ' . var_export( ob_get_clean(), true ) . ';' ), 100 ); ?>

<?php get_footer(); ?>