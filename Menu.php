<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\WidgetKLAMBT;
use Piwik\Common;
use Piwik\Menu\MenuTop;
use Piwik\Piwik;

class Menu extends \Piwik\Plugin\Menu
{
  public function configureTopMenu(MenuTop $menu)
  {
    $idSite = Common::getRequestVar('idSite', 0, 'int');

    $urlParams = $this->urlForActionWithDefaultUserParams('index', ['segment' => false, 'idSite' => $idSite ?: false]);
    $tooltip   = Piwik::translate('MultiSites_TopLinkTooltip');

    $menu->addItem('My top item', null, $urlParams, 3, $tooltip);
  }
}