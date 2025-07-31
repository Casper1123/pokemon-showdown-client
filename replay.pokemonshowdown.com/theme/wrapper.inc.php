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
	<link rel="stylesheet" href="//play.pokemonshowdown.com/style/font-awesome.css?0.0433316440117022" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/panels.css?0.01609675709559033" />
	<link rel="stylesheet" href="//pokemonshowdown.com/theme/main.css?0.5231317928461439" />
	<link rel="stylesheet" href="//play.pokemonshowdown.com/style/battle.css?0.5051379206813993" />
	<link rel="stylesheet" href="//play.pokemonshowdown.com/style/replay.css?0.6132616513750289" />
	<link rel="stylesheet" href="//play.pokemonshowdown.com/style/utilichart.css?0.09484815872924757" />

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
				<li><a class="button nav-first<?php if ($panels->tab === 'home') echo ' cur'; ?>" href="//pokemonshowdown.com/"><img src="//pokemonshowdown.com/images/pokemonshowdownbeta.png?0.26915606873516307" alt="Pok&eacute;mon Showdown! (beta)" /> Home</a></li>
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
	<script src="//play.pokemonshowdown.com/js/lib/jquery-1.11.0.min.js?0.9575346305505448"></script>
	<script src="//play.pokemonshowdown.com/js/lib/lodash.core.js?0.9845804338305766"></script>
	<script src="//play.pokemonshowdown.com/js/lib/backbone.js?0.991584891899141"></script>
	<script src="//dex.pokemonshowdown.com/js/panels.js?0.24217954099468275"></script>
<?php
}

function ThemeFooterTemplate() {
	global $panels;
?>
<?php $panels->scripts(); ?>

	<script src="//play.pokemonshowdown.com/js/lib/jquery-cookie.js?0.6681187651962499"></script>
	<script src="//play.pokemonshowdown.com/js/lib/html-sanitizer-minified.js?0.566732529499006"></script>
	<script src="//play.pokemonshowdown.com/js/battle-sound.js?0.7805893410842943"></script>
	<script src="//play.pokemonshowdown.com/config/config.js?c7da5f7a"></script>
	<script src="//play.pokemonshowdown.com/js/battledata.js?0.43169221531273605"></script>
	<script src="//play.pokemonshowdown.com/data/pokedex-mini.js?0.6252481502578595"></script>
	<script src="//play.pokemonshowdown.com/data/pokedex-mini-bw.js?0.8857423273498735"></script>
	<script src="//play.pokemonshowdown.com/data/graphics.js?0.9162300417054687"></script>
	<script src="//play.pokemonshowdown.com/data/pokedex.js?0.5840934057654164"></script>
	<script src="//play.pokemonshowdown.com/data/items.js?0.033260520334502"></script>
	<script src="//play.pokemonshowdown.com/data/moves.js?0.007907822267202436"></script>
	<script src="//play.pokemonshowdown.com/data/abilities.js?0.480115466018336"></script>
	<script src="//play.pokemonshowdown.com/data/teambuilder-tables.js?0.7532937192463631"></script>
	<script src="//play.pokemonshowdown.com/js/battle-tooltips.js?0.9320513404194632"></script>
	<script src="//play.pokemonshowdown.com/js/battle.js?0.0616530336071186"></script>
	<script src="/js/replay.js?0.4590086437882761"></script>

</body></html>
<?php
}
