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


class PageImpressionsByDateChild extends Widget {

  public static function configure(WidgetConfig $config) {
    $config->setCategoryId('Besucher');
    $config->setName('Seitenaufrufe - Zeitraum');
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
    $keyword=$_GET['keyword'] ?? null;
    $sql = "SELECT * FROM ( SELECT url,datum,sum(pageimpressions) as pageimpressions,unique_pageimpressions,time_on_site FROM klambt_day_data WHERE site_id=".$idSite." AND url like '%".$keyword."%' GROUP BY datum ORDER BY datum desc limit 365 ) as real_query ORDER BY datum asc";
    $db = \Piwik\Db::get();
    $result = $db->fetchAll($sql);
    return $this->renderTemplate('PageImpressionsByDateChild', array(
      'result' => $result,
    ));



  }

  public  function second2date($seconds): string {
  $t = round($seconds);
  return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}

}
