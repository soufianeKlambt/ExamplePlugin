<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\WidgetKLAMBT\Widgets;

use Piwik\Plugins\WidgetKLAMBT\WKCache;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;


class Referer extends Widget {

  public static function configure(WidgetConfig $config) {
    $config->setCategoryId('Besucher');
    $config->setName('Nutzergeräte (30 Min)');
    $config->setOrder(96);
  }

  /**
   * This method renders the widget. It's on you how to generate the content of
   * the widget. As long as you return a string everything is fine. You can use
   * for instance a "Piwik\View" to render a twig template. In such a case
   * don't forget to create a twig template (eg. myViewTemplate.twig) in the
   * "templates" directory of your plugin.
   *
   * @return string
   */
  public function render() {
    $idSite = $_GET['idSite'];
    $sql = "SELECT CASE WHEN config_device_type = 1  THEN 'Smartphone' WHEN config_device_type = 0  THEN 'Tablet' WHEN config_device_type = 10 THEN 'Tablet' WHEN config_device_type = 2  THEN 'Desktop/Notebook' ELSE 'andere' END as devices, count(idvisit) as visits FROM matomo_log_visit WHERE idsite = ".$idSite." AND visit_last_action_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 5 MINUTE)) GROUP BY devices ORDER BY visits desc LIMIT 10";
    $cache=new WKCache();
    $result= null;//$cache->getCacheData('Devices-'.$idSite,$sql);
    $sum = 0;
    foreach($result as $values) {
      $sum += $values[ 'visits' ];
    }
    return $this->renderTemplate('DevicesTemplate', [
      'rows' => $result,
      'sumResult' => $sum,
    ]);

  }


}
