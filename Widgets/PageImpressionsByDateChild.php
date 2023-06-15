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
$sqlDate="";
    switch ($_GET['period']) {
      case 'day':
        $date=$_GET['date'];
        $sqlDate="datum = '".$date."' ";
        break;
      case 'week':
        $date=$_GET['date'];
        $sqlDate="datum between '".$date."' and '".date('Y-m-d', strtotime($date .'+7 day'))."' ";
        break;
      case 'month':
        $date=$_GET['date'];
        $monthLastDay=date("m", strtotime($date));
        $yearMonth=date("Y-m", strtotime($date));
        $sqlDate="datum between '".$yearMonth."-01' and '".$yearMonth."-".$monthLastDay."' ";
        break;
      case 'year':
        $date=$_GET['date'];
        $year=date("Y", strtotime($date));
        $sqlDate="datum between '".$year."-01-01' and '".$year."-12-31' ";
        break;
      case 'range':
        $date=$_GET['date'];
        $dateFrom=explode(",",$date)[0];
        $dateTo=explode(",",$date)[1];
        $sqlDate="datum between '".$dateFrom."' and '".$dateTo."' ";
        break;
      default:
        break;
    }
    $sql = "SELECT * FROM ( SELECT url,datum,sum(pageimpressions) as pageimpressions,unique_pageimpressions,time_on_site FROM klambt_day_data WHERE site_id=".$idSite." AND url like '%".$keyword."%' GROUP BY datum ORDER BY datum desc limit 365 ) as real_query ".$sqlDate." ORDER BY datum asc";
    echo $sql;
    /* $db = \Piwik\Db::get();
     $result = $db->fetchAll($sql);

     return $this->renderTemplate('PageImpressionsByDateChild', array(
       'result' => $result,
     ));*/
  }

}
