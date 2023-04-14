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


class TopDayData extends Widget {



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
    Request::reloadAuthUsingTokenAuth();
    $idSite = $_GET['idSite'];
    $date = $_GET['date'];
    $sql = "select id,datum,url,pageimpressions as nb_visits,unique_pageimpressions as nb_uniq_visitors from klambt_day_data where site_id=".$idSite." and datum = '".$date."' group by url order by pageimpressions desc limit 20";
    $cache=new WKCache();
    $result= $cache->getCacheData('TopDayData-'.$idSite,$sql);
   return json_encode($result);

  }


}
