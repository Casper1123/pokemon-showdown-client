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
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/font-awesome.css?0.6072215614402019" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/panels.css?0.735993706572198" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/main.css?0.18416333582272837" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/battle.css?0.22808571587094328" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/replay.css?0.1381546510830809" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/utilichart.css?0.40376859827783074" />

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
				<li><a class="button nav-first<?php if ($panels->tab === 'home') echo ' cur'; ?>" href="//pokemonshowdown.com/"><img src="//pokemonshowdown.com/images/pokemonshowdownbeta.png?0.45821216018200706" alt="Pok&eacute;mon Showdown! (beta)" /> Home</a></li>
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
	<script src="//showdown.casper1123.nl/js/lib/jquery-1.11.0.min.js?0.18721929098973034"></script>
	<script src="//showdown.casper1123.nl/js/lib/lodash.core.js?0.561124543202886"></script>
	<script src="//showdown.casper1123.nl/js/lib/backbone.js?0.7497940211225249"></script>
	<script src="//dex.pokemonshowdown.com/js/panels.js?0.37389271700554105"></script>
<?php
}

function ThemeFooterTemplate() {
	global $panels;
?>
<?php $panels->scripts(); ?>

	<script src="//showdown.casper1123.nl/js/lib/jquery-cookie.js?0.5245472667977829"></script>
	<script src="//showdown.casper1123.nl/js/lib/html-sanitizer-minified.js?0.04212317765482543"></script>
	<script src="//showdown.casper1123.nl/js/battle-sound.js?0.8982005610306627"></script>
	<script src="//showdown.casper1123.nl/config/config.js?0.46039755404495875"></script>
	<script src="//showdown.casper1123.nl/js/battledata.js?0.23232384553783958"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini.js?0.6801861377999001"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini-bw.js?0.44205664305613257"></script>
	<script src="//showdown.casper1123.nl/data/graphics.js?0.41402849134392006"></script>
	<script src="//showdown.casper1123.nl/data/pokedex.js?0.177519346425006"></script>
	<script src="//showdown.casper1123.nl/data/items.js?0.22481196979295026"></script>
	<script src="//showdown.casper1123.nl/data/moves.js?0.6369516514021678"></script>
	<script src="//showdown.casper1123.nl/data/abilities.js?0.3030119943732168"></script>
	<script src="//showdown.casper1123.nl/data/teambuilder-tables.js?0.8129574351496549"></script>
	<script src="//showdown.casper1123.nl/js/battle-tooltips.js?0.9343407688419472"></script>
	<script src="//showdown.casper1123.nl/js/battle.js?0.370316312590361"></script>
	<script src="/js/replay.js?0.9692401037859664"></script>

</body></html>
<?php
}
