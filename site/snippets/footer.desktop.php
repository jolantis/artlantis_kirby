<?php ///////////////////////////////////////////////////////
// ----------------------------------------------------------
// PARTIAL :: DESKTOP
// ----------------------------------------------------------
////////////////////////////////////////////////////////// ?>

	<?php snippet('nav-main'); ?>

	<div role="contentinfo" class="contentinfo contain-padding">
		<footer>
			&copy; <?php echo '2002&ndash;' . date("Y"); ?> <a href="https://jonathanvanwunnik.com" rel="me"><?php echo $site->copyright()->smartypants(); ?></a>.
			<p><small>All contents licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" title="Creative Commons Attribution-Non-Commercial-No-Derivs 4.0 International">CC BY-NC-ND license</a>.</small></p>
			<p>desktop</p>
		</footer>
	</div>

	<?php // snippet('photoswipe-dom'); ?>
	<?php snippet('no-ctm-fallback'); ?>
	<?php snippet('google-analytics'); ?>
</body>
</html>
