<?php snippet_detect('html-head', array(
	// 'criticalcss' => 'other_than_default',
	'prev_next' => true
)); ?>

	<?php snippet('banner'); ?>
	<?php snippet('breadcrumb'); ?>

	<main class="copy copy--contain space-trailer-l">

		<h1><?php echo $page->title()->smartypants()->widont(); ?></h1>

		<?php if($page->date($format=true)): ?>
			<p><small><?php snippet('datetime'); ?></small></p>
		<?php endif; ?>

		<?php echo $page->intro()->kirbytext(); ?>
		<?php echo $page->text()->kirbytext(); ?>

		<?php /* if($page->hasImages()) : ?>

			<h2>Photo(s) form page</h2>

			<?php foreach($page->images() as $image): ?>
				<?php $caption = ($image->caption()->isNotEmpty()) ? $image->caption() : ''; ?>
				<figure class="figure-image">
					<?php echo $image->imageset('default'); ?>
					<?php if($caption): ?>
						<figcaption><?php echo $caption->smartypants(); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endforeach; ?>

		<?php endif; */ ?>

	</main>

	<?php snippet('nav-sub'); ?>

<?php snippet_detect('footer'); ?>
