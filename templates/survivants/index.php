<?php
/**
 * @package    template
 *
 * @author     abahl <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

require_once JPATH_THEMES . '/' . $this->template . '/helper.php';

tplTemplateHelper::loadCss();
tplTemplateHelper::loadJs();
tplTemplateHelper::setMetadata();

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
</head>
<body class="<?php echo tplTemplateHelper::setBodySuffix(); ?>">
<?php echo tplTemplateHelper::setAnalytics(0, 'your-analytics-id'); ?>

<a href="#main" class="sr-only sr-only-focusable"><?php echo Text::_('TPL_TEMPLATE_SKIP_LINK_LABEL'); ?></a>

<a href="<?php echo $this->baseurl; ?>/">
    <?php if ($this->params->get('sitedescription')) : ?>
        <?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription'), ENT_COMPAT, 'UTF-8') . '</div>'; ?>
    <?php endif; ?>
</a>

<nav role="navigation" >
	<jdoc:include type="modules" name="position-0" style="none" />
</nav>

<main id="main">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</main>

<aside>
    <?php if ($this->countModules('position-1')) : ?>
		<jdoc:include type="modules" name="position-1" style="none" />
	<?php endif; ?>
</aside>

<templateter>
	<jdoc:include type="modules" name="templateter" style="none" />
	<p>
		&copy; <?php echo date('Y'); ?> <?php echo tplTemplateHelper::getSitename(); ?>
	</p>
</templateter>
<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
