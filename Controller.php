<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\WidgetKLAMBT;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Config;
use Piwik\Piwik;
use Piwik\DataTable;
use Piwik\Url;
use Piwik\View;
use Piwik\SettingsPiwik;
/**
 */
class Controller extends \Piwik\Plugin\Controller
{
  protected function getDefaultIndexView()
  {
    if (SettingsPiwik::isInternetEnabled() && Marketplace::isMarketplaceEnabled()) {
      $this->securityPolicy->addPolicy('img-src', '*.matomo.org');
      $this->securityPolicy->addPolicy('default-src', '*.matomo.org');
    }

    $view = new View('@WidgetKLAMBT/getDefaultIndexView');
    $this->setGeneralVariablesView($view);
    $view->showMenu = true;
    $view->dashboardSettingsControl = new DashboardManagerControl();
    $view->content = '';
    return $view;
  }
  public function index()
  {
    $view = $this->getDefaultIndexView();
    return $view->render();
  }
}
