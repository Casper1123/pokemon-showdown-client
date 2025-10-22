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
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/font-awesome.css?0.19879992609042052" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/panels.css?0.7239920896920957" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/main.css?0.7254089350010804" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/battle.css?0.4108776346777976" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/replay.css?0.8513616367301817" />
	<link rel="stylesheet" href="//showdown.casper1123.nl/style/utilichart.css?0.4999581347811457" />

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
				<li><a class="button nav-first<?php if ($panels->tab === 'home') echo ' cur'; ?>" href="//pokemonshowdown.com/"><img src="//pokemonshowdown.com/images/pokemonshowdownbeta.png?0.6204661395624589" alt="Pok&eacute;mon Showdown! (beta)" /> Home</a></li>
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
	<script src="//showdown.casper1123.nl/js/lib/jquery-1.11.0.min.js?0.9359273978973253"></script>
	<script src="//showdown.casper1123.nl/js/lib/lodash.core.js?0.8646269645944902"></script>
	<script src="//showdown.casper1123.nl/js/lib/backbone.js?0.07845510860620908"></script>
	<script src="//dex.pokemonshowdown.com/js/panels.js?0.0089981309143079"></script>
<?php
}

function ThemeFooterTemplate() {
	global $panels;
?>
<?php $panels->scripts(); ?>

	<script src="//showdown.casper1123.nl/js/lib/jquery-cookie.js?0.5546636114130887"></script>
	<script src="//showdown.casper1123.nl/js/lib/html-sanitizer-minified.js?0.3708945295100745"></script>
	<script src="//showdown.casper1123.nl/js/battle-sound.js?0.3379282381183659"></script>
	<script src="//showdown.casper1123.nl/config/config.js?0.8048596114308924"></script>
	<script src="//showdown.casper1123.nl/js/battledata.js?0.004511666336510345"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini.js?0.8510764943433387"></script>
	<script src="//showdown.casper1123.nl/data/pokedex-mini-bw.js?0.08412239575213798"></script>
	<script src="//showdown.casper1123.nl/data/graphics.js?0.5164726117487182"></script>
	<script src="//showdown.casper1123.nl/data/pokedex.js?0.78149275187962"></script>
	<script src="//showdown.casper1123.nl/data/items.js?0.33978439623818857"></script>
	<script src="//showdown.casper1123.nl/data/moves.js?0.2744443233573317"></script>
	<script src="//showdown.casper1123.nl/data/abilities.js?0.057956471304037915"></script>
	<script src="//showdown.casper1123.nl/data/teambuilder-tables.js?0.004150782493335559"></script>
	<script src="//showdown.casper1123.nl/js/battle-tooltips.js?0.0009245946905971358"></script>
	<script src="//showdown.casper1123.nl/js/battle.js?0.8441817579747923"></script>
	<script src="/js/replay.js?0.6355002497159281"></script>

</body></html>
<?php
}
