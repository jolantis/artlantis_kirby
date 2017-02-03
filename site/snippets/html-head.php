<?php ///////////////////////////////////////////////////////
// ----------------------------------------------------------
// PARTIAL :: MOBILE
// ----------------------------------------------------------
/////////////////////////////////////////////////////////////

// Read assets json
$assets_css = f::read(server::get('document_root') . ((c::get('url') != '/') ? c::get('url') . '/' : c::get('url', '/')) . 'assets/stylesheets/min/hash.css.json');
$assets_js = f::read(server::get('document_root') . ((c::get('url') != '/') ? c::get('url') . '/' : c::get('url', '/')) . 'assets/javascript/min/hash.js.json');

// Set assets based on environment
if(c::get('environment') == 'local'):
	$env_suffix = 'dev';
	// $mobile_css = 'mobile.dev';
	$mobile_css = 'main.dev';
	$print_css = 'print.dev';
	$head_js = 'head.scripts.dev';
	$mobile_js = 'mobile.scripts.dev';
	// $photoswipe_js = 'photoswipe.scripts.dev';
else:
	$env_suffix = 'min';
	// $mobile_css = json_decode($assets_css)->mobile;
	$mobile_css = json_decode($assets_css)->main;
	$print_css = json_decode($assets_css)->print;
	$head_js = json_decode($assets_js)->head;
	$mobile_js = json_decode($assets_js)->mobile;
	// $photoswipe_js = json_decode($assets_js)->photoswipe;
endif;

// Variabel to set language locale on html element
$language_locale = (c::get('language.multi', false)) ? $site->language()->locale() : c::get('language.locale', 'en');

// Variable to set 'critical' css file name to link to on a template basis.
// By default the varibale is set to 'default'. To link to another 'critical'
// css file, add name of another file to the include snippet (at the top
// of the template), like this:
// `snippet_detect('html-head', array('criticalcss' => 'another_criticalss_file'));`
$criticalcss = (isset($criticalcss)) ? $criticalcss : 'default';

// Variable to set next and previous rel="next/prev" links (e.g. news item,
// project detail, blogpost, etc.). To enable add a 'prev_next' array to the
// include snippet (at top of the template), like this:
// 'snippet_detect('html-head', array('prev_next' => true));'
$prev_next = (isset($prev_next)) ? $prev_next : false;

// Variable to set page template name to html element for styling purpose.
$page_template = ($page->intendedTemplate()) ? ' template-' . $page->intendedTemplate() : '';

// Check for the presence of Font Face Observer cookie (e.g. `fonts-loaded`)
// and if so adds `fonts-loaded` class to html element, to avoid re-downloading
// web fonts over and over again.
$fontobserver = (isset($_COOKIE['fonts-loaded']) && $_COOKIE['fonts-loaded'] == 'true') ? ' fonts-loaded' : '';

////////////////////////////////////////////////////////// ?>

<!doctype html>
<html class="no-js<?php echo $page_template . $fontobserver ?>" lang="<?php echo $language_locale; ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<?php // Prefetch DNS for external assets (Typekit, Google APIs, etc). ?>
	<?php /* <link rel="dns-prefetch" href="https://maps.googleapis.com"> */ ?>
	<link rel="dns-prefetch" href="https://www.google-analytics.com">

	<?php // Preload assets (fonts, stylesheets, etc.) ?>
	<link rel="preload" href="<?php $site->url(); ?>/assets/fonts/kawak/kawak-bold.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="<?php $site->url(); ?>/assets/fonts/kawak/kawak-light.woff2" as="font" type="font/woff2" crossorigin>

	<?php // Page title and (meta) description ?>
	<?php snippet('page-title-description') ?>

	<meta name="robots" content="<?php if(c::get('environment') == 'local' || c::get('environment') == 'stage'): echo 'noindex, nofollow'; else: echo 'index, follow'; endif; ?>">
	<?php if($site->app_name()->isNotEmpty()): ?><meta name="apple-mobile-web-app-title" content="<?php echo $site->app_name()->smartypants(); ?>"><?php endif; ?><?php // Custom iOS bookmark title ?>
	<meta name="theme-color" content="<?php echo ($site->theme_color()->isNotEmpty()) ? $site->theme_color() : '#141414' ; ?>"><?php // Task bar backrgound collor in switcher, Chrome 39+ for Android (http://j.mp/1xVyGVc) ?>

	<link rel="home" href="<?php echo $site->url(); ?>">
	<?php if(c::get('tinyurl.enabled') && !$page->isHomepage()): ?><link rel="shortlink" href="<?php echo $page->tinyurl(); ?>"><?php endif; ?><?php // Shortlink, enable tinyurl in config.php ?>
	<link rel="author" href="<?php echo $site->url(); ?>/humans.txt">
	<link rel="sitemap" type="application/xml" title="<?php echo $site->title()->smartypants(); ?>: Sitemap" href="<?php echo (c::get('url') != '/') ? $site->url() . '/sitemap.xml' :  '/sitemap.xml'; ?>">
	<?php /* if(page('blog')): ?><link rel="alternate" type="application/rss+xml" title="<?php echo $site->title()->smartypants(); ?>: <?php echo page('blog')->title()->smartypants(); ?> Feed" href="<?php echo (c::get('url') != '/') ? $site->url() . '/blog.rss' : '/blog.rss'; ?>"><?php endif; */ ?>

	<link rel="apple-touch-icon" href="<?php echo url('/assets/images/apple-touch-icon.png'); ?>"><?php // Touch icons, iOS and Android, 180x180 pixels in size (http://j.mp/2fnrQmw, http://j.mp/2gpJVVF) ?>
	<link rel="icon" href="<?php echo url('/assets/images/favicon-192x192.png'); ?>"><?php // For Firefox, Chrome, Safari, IE 11+ and Opera, 192x192 pixels in size ?>
	<link rel="mask-icon" href="<?php echo url('/assets/images/pinned-icon.svg'); ?>" color="<?php echo ($site->theme_color()->isNotEmpty()) ? $site->theme_color() : '#141414' ; ?>"><?php // For Safari 9+ pinned tab (http://j.mp/2gpNiw9) ?>

	<?php // Next, previous and canonical rel links for all pages ?>
	<?php if(params()) : meta_prevnextcanonical_general($page); endif; ?>

	<?php // Next and previous rel links on specific pages (to use set $prev_next varibale in template) ?>
	<?php if($prev_next): meta_prevnextcanonical_single($page); endif; ?>

	<?php // Alternate language rel link(s) for matching languages in config and available text files (e.g. blogarticle.md, blogarticle.en.md) ?>
	<?php if(c::get('language.multi', false)): foreach($site->languages() as $language): if($site->languages()->count() > 1 && $site->language() != $language && isset($page->inventory()['content'][$language->code()])): ?><link rel="alternate" href="<?php echo $page->url($language->code()); ?>" hreflang="<?php echo $language->locale(); ?>"><?php endif; endforeach; endif; ?>

	<?php // Social meta tags ?>
	<?php snippet('social-meta-tags') ?>

	<!-- Scripts and Stylesheets -->
	<meta name="fullcss" content="<?php echo url('/assets/stylesheets/' . $env_suffix . '/' . $mobile_css . '.css'); ?>">
	<meta name="fulljs" content="<?php echo url('/assets/javascript/'. $env_suffix .'/' . $mobile_js . '.js'); ?>">
	<?php /* <meta name="photoswipejs" content="<?php echo url('/assets/javascript/'. $env_suffix .'/' . $photoswipe_js . '.js'); ?>"> */ ?>
	<script><?php include_once(server::get('document_root') . '/assets/javascript/'. $env_suffix .'/' . $head_js . '.js'); ?></script>
	<?php if(isset($_COOKIE['fullcss']) && $_COOKIE['fullcss'] == 'true'): ?>
		<link rel="stylesheet" href="<?php echo url('/assets/stylesheets/' . $env_suffix . '/' . $mobile_css . '.css'); ?>">
	<?php else: ?>
		<style><?php if(c::get('environment') == 'local' || c::get('environment') == 'stage'): echo '/* ' . $criticalcss . ' css */' . "\n"; endif; include_once(server::get('document_root') . '/assets/stylesheets/critical/' . $criticalcss . '_mobile.css'); ?></style>
		<noscript><link rel="stylesheet" href="<?php echo url('/assets/stylesheets/' . $env_suffix . '/' . $mobile_css . '.css'); ?>"></noscript>
	<?php endif; ?>
	<link rel="stylesheet" href="<?php echo url('/assets/stylesheets/' . $env_suffix . '/' . $print_css . '.css'); ?>" media="print">

	<?php // Initialize JS variables for use later on ?>
	<?php // <script>var push_message = [];</script> ?>

</head>
<body>
