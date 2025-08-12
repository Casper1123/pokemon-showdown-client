<?php

// NOTE: this is Old Replays. Mostly unused except for `/manage`

if ((substr($_SERVER['REMOTE_ADDR'],0,11) === '69.164.163.') ||
		(substr(@$_SERVER['HTTP_X_FORWARDED_FOR'],0,11) === '69.164.163.')) {
	die('website disabled');
}

/********************************************************************
 * Header
 ********************************************************************/

function ThemeHeaderTemplate() {
	global $panels;
?>
<!DOCTYPE html>
<html><head>

	<meta charset="utf-8" />

	<title><?php if ($panels->pagetitle) echo htmlspecialchars($panels->pagetitle).' - '; ?>Pok&eacute;mon Showdown</title>

<?php if ($panels->pagedescription) { ?>
	<meta name="description" content="<?php echo htmlspecialchars($panels->pagedescription); ?>" />
<?php } ?>

	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=IE8" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/font-awesome.css?0.8251308867613547" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/panels.css?0.34371305230387694" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/main.css?0.5322358666572697" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/battle.css?0.6633296564443687" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/replay.css?0.6052875199737529" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/utilichart.css?0.7592889002321481" />

	<!-- Workarounds for IE bugs to display trees correctly. -->
	<!--[if lte IE 6]><style> li.tree { height: 1px; } </style><![endif]-->
	<!--[if IE 7]><style> li.tree { zoom: 1; } </style><![endif]-->

	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-26211653-1']);
		_gaq.push(['_setDomainName', 'pokemonshowdown.com']);
		_gaq.push(['_setAllowLinker', true]);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head><body>

	<div class="pfx-topbar">
		<div class="header">
			<ul class="nav">
				<li><a class="button nav-first<?php if ($panels->tab === 'home') echo ' cur'; ?>" href="//pokemonshowdown.com/"><img src="//pokemonshowdown.com/images/pokemonshowdownbeta.png?0.7003596927356115" alt="Pok&eacute;mon Showdown! (beta)" /> Home</a></li>
				<li><a class="button<?php if ($panels->tab === 'pokedex') echo ' cur'; ?>" href="//dex.pokemonshowdown.com/">Pok&eacute;dex</a></li>
				<li><a class="button<?php if ($panels->tab === 'replay') echo ' cur'; ?>" href="/">Replay</a></li>
				<li><a class="button purplebutton" href="//smogon.com/dex/" target="_blank">Strategy</a></li>
				<li><a class="button nav-last purplebutton" href="//smogon.com/forums/" target="_blank">Forum</a></li>
			</ul>
			<ul class="nav nav-play">
				<li><a class="button greenbutton nav-first nav-last" href="http://play.pokemonshowdown.com/">Play</a></li>
			</ul>
			<div style="clear:both"></div>
		</div>
	</div>
<?php
}

/********************************************************************
 * Footer
 ********************************************************************/

function ThemeScriptsTemplate() {
?>
	<script src="//showdown.casper1123.nl/js/lib/jquery-1.11.0.min.js?0.5608415597697802"></script>
	<script src="//showdown.casper1123.nl/js/lib/lodash.core.js?0.4127102296314773"></script>
	<script src="//showdown.casper1123.nl/js/lib/backbone.js?0.8797093662451398"></script>
	<script src="//dex.pokemonshowdown.com/js/panels.js?0.15591701095703692"></script>
<?php
}

function ThemeFooterTemplate() {
	global $panels;
?>
<?php $panels->scripts(); ?>

	<script src="//showdown.casper1123.nl/js/lib/jquery-cookie.js?0.1833144315521471"></script>
	<script src="//showdown.casper1123.nl/js/lib/html-sanitizer-minified.js?0.9918838687799643"></script>
	<script src="//showdown.casper1123.nl/js/battle-sound.js?0.3098258507989067"></script>
	<script src="//showdown.casper1123.nl/config/config.js?0.7354230950446627"></script>
	<script src="//showdown.casper1123.nl/js/battledata.js?0.13338766302654737"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini.js?0.3814173935786547"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini-bw.js?0.07747141287139758"></script>
	<script src="//showdown.casper1123.nl/data/graphics.js?0.647659998264386"></script>
	<script src="//showdown.casper1123.nl/data/pokedex.js?0.24465483833371038"></script>
	<script src="//showdown.casper1123.nl/data/items.js?0.6615449423988435"></script>
	<script src="//showdown.casper1123.nl/data/moves.js?0.5408904690070144"></script>
	<script src="//showdown.casper1123.nl/data/abilities.js?0.5972155015038154"></script>
	<script src="//showdown.casper1123.nl/data/teambuilder-tables.js?0.8016438333659124"></script>
	<script src="//showdown.casper1123.nl/js/battle-tooltips.js?0.43329575435160717"></script>
	<script src="//showdown.casper1123.nl/js/battle.js?0.8608699439598038"></script>
	<script src="/js/replay.js?0.5505947165622693"></script>

</body></html>
<?php
}
