<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\WidgetKLAMBT\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;


class GetInsightsOverview extends \Piwik\Widget\Widget
{
  public static function configure(WidgetConfig $config)
  {
    $config->setCategoryId('General_Visitors');
    $config->setSubcategoryId('DevicesDetection_Software');
    $config->setOrder(10);
  }
  public function render()
  {
    // it is not needed to check for permissions here again
    return 'Hello world!';
  }

}
