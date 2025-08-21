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
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/font-awesome.css?0.1835000844407586" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/panels.css?0.06348840296938785" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/main.css?0.6870477876424865" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/battle.css?0.9927889413769362" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/replay.css?0.5269601154791759" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/utilichart.css?0.8969406622280354" />

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
				<li><a class="button nav-first<?php if ($panels->tab === 'home') echo ' cur'; ?>" href="//pokemonshowdown.com/"><img src="//pokemonshowdown.com/images/pokemonshowdownbeta.png?0.8484170112257514" alt="Pok&eacute;mon Showdown! (beta)" /> Home</a></li>
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
	<script src="//showdown.casper1123.nl/js/lib/jquery-1.11.0.min.js?0.2963628133044036"></script>
	<script src="//showdown.casper1123.nl/js/lib/lodash.core.js?0.7447521892752933"></script>
	<script src="//showdown.casper1123.nl/js/lib/backbone.js?0.7891263065142649"></script>
	<script src="//dex.pokemonshowdown.com/js/panels.js?0.5724308370387485"></script>
<?php
}

function ThemeFooterTemplate() {
	global $panels;
?>
<?php $panels->scripts(); ?>

	<script src="//showdown.casper1123.nl/js/lib/jquery-cookie.js?0.28829968779032766"></script>
	<script src="//showdown.casper1123.nl/js/lib/html-sanitizer-minified.js?0.205248586745423"></script>
	<script src="//showdown.casper1123.nl/js/battle-sound.js?0.02472132214681455"></script>
	<script src="//showdown.casper1123.nl/config/config.js?0.8460297483442756"></script>
	<script src="//showdown.casper1123.nl/js/battledata.js?0.009877784305812876"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini.js?0.4316466695494656"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini-bw.js?0.5622931588249787"></script>
	<script src="//showdown.casper1123.nl/data/graphics.js?0.9000078472682718"></script>
	<script src="//showdown.casper1123.nl/data/pokedex.js?0.5622297406569525"></script>
	<script src="//showdown.casper1123.nl/data/items.js?0.6719245638444751"></script>
	<script src="//showdown.casper1123.nl/data/moves.js?0.4376054200903299"></script>
	<script src="//showdown.casper1123.nl/data/abilities.js?0.27010054566373753"></script>
	<script src="//showdown.casper1123.nl/data/teambuilder-tables.js?0.44652417647891407"></script>
	<script src="//showdown.casper1123.nl/js/battle-tooltips.js?0.8534808070827167"></script>
	<script src="//showdown.casper1123.nl/js/battle.js?0.15617353459031147"></script>
	<script src="/js/replay.js?0.020398494205224216"></script>

</body></html>
<?php
}
