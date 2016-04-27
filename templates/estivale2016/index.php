<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 * 
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JLoader::import('joomla.filesystem.file');

// Check modules
$showTeaserRow = ($this->countModules('lineup_home')  or $this->countModules('left_block_home'));

JHtml::_('behavior.framework', true);

// Get params
$color          = $this->params->get('templatecolor');
$logo           = $this->params->get('logo');
$navposition    = $this->params->get('navposition');
$headerImage    = $this->params->get('headerImage');
$doc            = JFactory::getDocument();
$app            = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$config         = JFactory::getConfig();
$bootstrap      = explode(',', $templateparams->get('bootstrap'));
$jinput         = JFactory::getApplication()->input;
$option         = $jinput->get('option', '', 'cmd');

$doc->addStyleSheet($this->baseurl . '/templates/system/css/system.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/bootstrap.min.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css', $type = 'text/css', $media = 'screen,projection');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/jquery.backstretch.min.js', 'text/javascript');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/bootstrap.min.js', 'text/javascript');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/template.js', 'text/javascript');

$jinput = JFactory::getApplication()->input;
$pageId = $jinput->get('id');

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
		<meta name="HandheldFriendly" content="true" />
		<meta name="apple-mobile-web-app-capable" content="YES" />

		<jdoc:include type="head" />

		<!--[if IE 7]>
		<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
		<![endif]-->
		
		<script type="text/javascript">
			<?php $background_img = rand(1,9); ?>
			jQuery(document).ready(function() {
				  jQuery.backstretch('<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/estivale2016/templates/estivale2016/images/backgrounds/'.$background_img.'.jpg';?>');
				  
				  jQuery('.content img').addClass('img img-responsive');
				  jQuery("img").parents('a').css("background", "none");
			});
			
			jQuery(document).on('click','.navbar-collapse.in',function(e) {
				if( (jQuery(e.target).is('a') && jQuery(e.target).attr('class') != 'dropdown-toggle' ) ) {
					jQuery(this).collapse('hide');
				}
			});
			
		</script>
	</head>
	<body id="estivale2016">
		<div class="body">
			<div class="container">
				<header id="header">
					<div class="row">
						<div class="col-xs-2 logoheader">
							<a href="index.php">
								<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/logo_estivale.png"  alt="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" />
							</a>
						</div><!-- end logoheader -->
						<div class="col-xs-10 headline">
							<h1>29, 30, 31 JUILLET<br />01 AOÛT 2016</h1>
							<jdoc:include type="modules" name="social_media" />
							<div style=clear:both;></div>
							<jdoc:include type="modules" name="language_selector" />
						</div>
					</div>
					
					<div class="hidden-lg hidden-md">
						<nav class="navbar navbar-default">
						  <div class="container-fluid">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
								  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								  </button>
								  <a class="navbar-brand" href="#">Menu</a>
								</div>
								 <!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<jdoc:include type="modules" name="main_menu" />
							  </div><!-- /.navbar-collapse -->
						  </div><!-- /.container-fluid -->
						</nav>
					</div>
					<div class="hidden-sm hidden-xs">
					<jdoc:include type="modules" name="main_menu" />
					</div>
				</header><!-- end header -->

				<div id="breadcrumbs">
					<jdoc:include type="modules" name="breadcrumbs" />
				</div>	
				
				<?php if($pageId!=48 && $pageId!=49 && $pageId!=52 && $pageId!=53){ ?>
				<div id="main_content">
					<jdoc:include type="modules" name="second_nav_level" />
					<?php if($showTeaserRow){ ?>
						<div class="row teaser-line-up">
							<!--<div class="hidden-xs col-sm-4 col-md-3 hidden-xs left-block-home">
								<jdoc:include type="modules" name="left_block_home" />
							</div>
							<div class=" col-xs-12 col-sm-8 col-md-9 right-block-home">
								<jdoc:include type="modules" name="right_block_home" />
							</div>-->
							<div class="col-xs-12">
								<jdoc:include type="modules" name="lineup_home" />
							</div>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-xs-12 content">
							<jdoc:include type="component" />
						</div>
					</div>
					<div class="row bottom">
						<div class="col-md-6 col-xs-12 left-block-bottom">
							<jdoc:include type="modules" name="newsletter" style="xhtml" />
						</div>
						<div class="col-md-6 col-xs-12 right-block-bottom">
							<jdoc:include type="modules" name="youtube_teaser" style="xhtml" />
						</div>
					</div>
				</div>
				<?php }else{ ?>
						<div class="col-xs-12 prog-content">
							<jdoc:include type="component" />
						</div>	
				<?php } ?>
				
			</div>
			
			<div class="footer">
				<div class="container">
					<div class="col-sm-6 col-xs-12 left-block-footer">
						<jdoc:include type="modules" name="left_block_footer" style="xhtml" />
					</div>
					<div class="col-sm-6 col-xs-12 right-block-footer">
						<jdoc:include type="modules" name="right_block_footer" style="xhtml" />
					</div>
				</div>
			</div>
			<jdoc:include type="modules" name="debug" />
		</div>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-16467406-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</body>
</html>
