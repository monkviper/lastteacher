<?php get_header(); ?>

<?php // Depending on the current state #mock will also have classes preparing, available/unavailable, test_active/test_paused/test_finished ?>
<div id="mock">
	<div id="placeholder">
		<noscript>Javascript is required to utilise the functionality of this website. Please enable it in your browser settings.</noscript>
		Please wait while we setup the test environment. If this message appears for very long, please check your network connection and browser settings.
		If it still doesn't work, please upgrade your browser to the latest version. This site works best in Firefox.
	</div>

	<div id="unavailable" style="display:none">
		This exam is currently running by you in another window. Multiple windows are not allowed.
		<button class="proceed" href="<?php echo home_url('/'); ?>">Go back to Homepage</button>
	</div>

	<div id="available" style="display:none">
		Exam Loaded. Please read the Instructions below and click proceed.
		<ul>
			<li>Please ensure you have a strong network connection for best results in the exam.</li>
			<li>We allow you to pause your exam(and timer), which may not be available to you on the real exam. Do not use the feature for best practice.</li>
			<li>The Exam will automatically submit once the timer expires.</li>
			<li>The next screen will have instructions about the user interface.</li>
		</ul>
		<button class="proceed">Proceed</button>
	</div>

	<div id="paused" style="display:none">
		The exam is paused. The timer is also paused. Please note that pausing a live exam may not be available to you during the real exam.
		<button class="proceed">Resume</button>
	</div>

	<div id="finished" style="display:none">
		The exam has been submitted. Please wait while we calculate the results.
		You can also view the results later in your account page. We will notify you when the results are ready.
		<button class="proceed" href="<?php echo home_url('/'); ?>">Go back to Homepage</button>
	</div>

	<div id="main" style="display:none">
		<div id="test">
			<div class="subjects"></div>
			<div id="instructions">
				<ul>
					<li>Your timer is available in top right.</li>
					<li>Go directly to a question by clicking it's marker in the right.</li>
					<li>Save your answer or mark it for review below.</li>
					<li>When done click "Submit Test" in the bottom right.</li>
					<li>You can revisit these instructions at any time by clicking "Instructions" below.</li>
				</ul>
			</div>
			<div class="question" style="display:none">
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
</div>

<?php ob_start(); ?>
	<script type="text/javascript">
		initiate_mock({
			ID:<?php echo get_post_meta( get_the_ID(), '_saved_ext_id', true ); ?>
		});
	</script>
<?php add_action( 'wp_footer', create_function( '', 'echo ' . var_export( ob_get_clean(), true ) . ';' ), 100 ); ?>

<?php get_footer(); ?>