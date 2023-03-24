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
    $config->setName('Häufigste Verweise (30 Min)');
    $config->setOrder(97);
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
      $sql="SELECT referer_name, count(idvisit) as visits FROM matomo_log_visit WHERE idsite = ".$idSite." AND visit_last_action_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE)) AND referer_name is NOT NULL GROUP BY referer_name ORDER BY visits desc LIMIT 10";
      $cache=new WKCache();
      $result= $cache->getCacheData('Referer-'.$idSite,$sql);
    return $this->renderTemplate('RefererTemplate', [
      'rows' => $result,
    ]);


  }


}
