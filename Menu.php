<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\WidgetKLAMBT;

use Piwik\Archive;
use Piwik\DataTable;
use Piwik\Piwik;
use Piwik\Segment;

class Menu extends \Piwik\Plugin\Menu
{
  public function configureTopMenu(MenuTop $menu)
  {
    $menu->addItem('My top item', null, $this->urlForDefaultAction());
  }

  public function configureAdminMenu(MenuAdmin $menu)
  {
    // ...
  }
}