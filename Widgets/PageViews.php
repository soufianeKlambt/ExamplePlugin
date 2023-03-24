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


class PageViews extends Widget {

  public static function configure(WidgetConfig $config) {
    $config->setCategoryId('Besucher');
    $config->setName('Seitenaufrufe (30 Min)');
    $config->setOrder(98);
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
    $sql="SELECT TIMESTAMPDIFF(Minute,UTC_TIMESTAMP(),matomo_log_link_visit_action.server_time) as timeinterval, count(matomo_log_action.name) as hits FROM matomo_log_link_visit_action INNER JOIN matomo_log_action ON matomo_log_link_visit_action.idaction_url = matomo_log_action.idaction WHERE matomo_log_link_visit_action.server_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 31 MINUTE)) AND matomo_log_link_visit_action.idsite = ".$idSite." GROUP BY timeinterval desc LIMIT 1,30";
    $cache=new WKCache();
    $result= $cache->getCacheData('PageView-'.$idSite,$sql);
    $xValues= array();
    $yValues= array();
    foreach($result as $values) {
      $xValues[]=$values['timeinterval'];
      $yValues[]=$values['hits'];
    }
    return $this->renderTemplate('PageviewsTemplate', [
      'xValues' => $xValues,
      'yValues' => $yValues,
    ]);
  }


}
