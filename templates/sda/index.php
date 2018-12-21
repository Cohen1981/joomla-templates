<?php
/**
 * @package    sda
 *
 * @author     abahl <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
JLoader::import('joomla.filesystem.file');


$app             = Factory::getApplication();
$doc             = Factory::getDocument();
$user            = Factory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Output as HTML5
$doc->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

// Add Stylesheets
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->baseurl . '/templates/system/css/general.css', array('version' => 'auto'));
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css', array('version' => 'auto'));

// Check for a custom CSS file
$userCss = JPATH_SITE . '/templates/' . $this->template . '/css/user.css';

$doc->addScriptVersion($this->baseurl . '/templates/' . $this->template . '/js/template.js', array('version' => 'auto'));

if (file_exists($userCss) && filesize($userCss) > 0)
{
	$this->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/user.css', array('version' => 'auto'));
}
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('siteTitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle')) . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
if ($this->params->get('topLabel'))
{
    $topLabel=$this->params->get('topLabel');
}
else
{
    $topLabel=false;
}
$top = ($this->countModules('top1') or $this->countModules('top2') or $this->countModules('top3') or $this->countModules('top4'));

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0;" />
</head>

<body>
    <!-- Top when needed -->
    <?php if ($top) : ?>
    <div id="top_container" class="horizontal-nav">
        <input type="checkbox" id="switch_top" class="hidden"/>
        <div class="switchable">
            <div  id="top_modules">
                <?php if ($this->countModules('top1')) : ?>
                <div id="top1">
                    <jdoc:include type="modules" name="top1" style="none" />
                </div>
                <?php endif; ?>
                <?php if ($this->countModules('top2')) : ?>
                <div id="top2">
                    <jdoc:include type="modules" name="top2" style="none" />
                </div>
                <?php endif; ?>
                <?php if ($this->countModules('top3')) : ?>
                <div id="top3">
                    <jdoc:include type="modules" name="top3" style="none" />
                </div>
                <?php endif; ?>
                <?php if ($this->countModules('top4')) : ?>
                <div id="top4">
                    <jdoc:include type="modules" name="top4" style="none" />
                </div>
                <?php endif; ?>
            </div>
        </div>
        <label id="mobile-top" class="css_switch bottom-rounded" for="switch_top">
            <span class="icon-menu-3" aria-hidden="true"> </span>
            <span class="">
                <?php if($topLabel)
                    {echo $topLabel;}
                else
                    {echo JText::_('TPL_SDA_INTERNALSWITCH');}
                ?>
            </span>
        </label>
    </div>
    <?php endif; ?>

    <div  class="site-grid">
        <nav class="horizontal-nav">
            <input type="checkbox" id="switch" class="hidden"/>
            <div class="switchable">
                <div id="menu_container">
                    <jdoc:include type="modules" name="menu" style="none" />
                </div>
            </div>
            <label id="mobile-nav" class="hide-on-desktop css_switch bottom-rounded" for="switch">
                <span class="icon-menu-3" aria-hidden="true"> </span>
                <span class=""><?php echo JText::_('TPL_SDA_MENUSWITCH'); ?></span>
            </label>
        </nav>
        <div class="navbar-brand">
            <a href="<?php echo $this->baseurl; ?>/">
                <?php echo $logo; ?>
            </a>
        </div>
        <div id="breadcrumb">
            <jdoc:include type="modules" name="breadcrumbs" style="none" />
        </div>

        <main>

            <?php if ($this->countModules('sidebar-left')) : ?>
                <div class="container-sidebar-left rounded">
                    <jdoc:include type="modules" name="sidebar-left" style="default" />
                </div>
            <?php endif; ?>

            <div class="container-component rounded">
                <jdoc:include type="modules" name="main-top" style="cardGrey" />
                <jdoc:include type="message" />
                <jdoc:include type="component" />
                <jdoc:include type="modules" name="main-bottom" style="cardGrey" />
            </div>

            <?php if ($this->countModules('sidebar-right')) : ?>
                <div class="container-sidebar-right rounded">
                    <jdoc:include type="modules" name="sidebar-right" style="default" />
                </div>
            <?php endif; ?>

        </main>

        <?php if ($this->countModules('footer')) : ?>
        <footer class="container-footer footer rounded">
            <p class="float-right hide-on-mobile">
                <a href="#top" id="back-top" class="back-top">
                    <span class="icon-arrow-up-4" aria-hidden="true"></span>
                    <span class=""><?php echo JText::_('TPL_SDA_BACKTOTOP'); ?></span>
                </a>
            </p>
            <jdoc:include type="modules" name="footer" style="none" />
            <jdoc:include type="modules" name="debug" style="none" />
            <div class="copyright">
                Copyright &copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
            </div>
        </footer>

        <?php endif; ?>
        <p id="top-arrow" class="float-right hide-on-desktop rounded">
            <a href="#top" id="back-top" class="back-top">
                <span class="icon-arrow-up-4" aria-hidden="true"></span>

            </a>
        </p>
    </div>

</body>
</html>
