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


class PageImpressionsByDate extends Widget {

  public static function configure(WidgetConfig $config) {
    $config->setCategoryId('Echtzeit');
    $config->setSubcategoryId('Seitenaufrufe URL');
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
    $datum = $_GET['date'];
    $sql = "select url,datum,sum(pageimpressions) as pageimpressions from klambt_day_data where site_id=".$idSite."  and ";
    switch ($_GET['period']) {
      case 'day':
        $sql .= "datum ='".date("Y-m-d", strtotime($datum))."'";
        break;
      case 'week':
        $sql .= "datum between '".$datum."' and '".date('Y-m-d', strtotime($datum.' +7 days'))."'";
        break;
      case 'month':
        $sql .= "datum between '".date('Y-m', strtotime($datum))."-01' and '".date('Y-m', strtotime($datum)).'-'.cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($datum)),date("Y",strtotime($datum)))."'";
        break;
      case 'year':
        $sql .= "datum between '".date('Y', strtotime($datum))."-01-01' and '".date('Y', strtotime($datum))."-12-31'";
        break;
      case 'range':
        $sql .= "datum between '".explode(",",$datum)[0]."' and '".explode(",",$datum)[1]."'";
        break;
    }
    $sql .= " group by datum";

    $db = \Piwik\Db::get();
    $result = $db->fetchAll($sql);
    return $this->renderTemplate('PageImpressionsByDate', array(
      'result' => $result,
      'suche' => $_GET['suche'] ?? null,

    ));



  }


}
