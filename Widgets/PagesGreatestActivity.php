<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\PagesGreatestActivity\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;


class PagesGreatestActivity extends Widget {

  public static function configure(WidgetConfig $config) {
    $config->setCategoryId('Besucher');
    $config->setName('Seiten mit größter Aktivität (30 Min)');
    $config->setOrder(99);
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
    $file = '/var/www/html/cache/plugin-PGA-site-' . $idSite . '.cache';
    $expire = 300;
    if (filemtime($file) < (time() - $expire)) {
      $db = \Piwik\Db::get();
      $result = $db->fetchAll("SELECT concat('https://',pageimpressions.url) as full_url,REGEXP_REPLACE(pageimpressions.url,'^[a-zA-Z0-9\.\-]*','') as relative_url,pageimpressions.idsite,COUNT(pageimpressions.idvisit) as visits FROM (SELECT matomo_log_link_visit_action.server_time,REGEXP_REPLACE(action_url.name,'[\?|#].*$', '') as url,matomo_log_link_visit_action.idsite,matomo_log_link_visit_action.idvisit,matomo_log_link_visit_action.idpageview,matomo_log_link_visit_action.idaction_url,action_url.hash,action_url.type FROM matomo_log_link_visit_action INNER JOIN matomo_log_action as action_url ON matomo_log_link_visit_action.idaction_url = action_url.idaction WHERE matomo_log_link_visit_action.server_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE))  AND idsite = " . $idSite . " ORDER BY matomo_log_link_visit_action.idlink_va desc) as pageimpressions GROUP BY `url`, idsite ORDER BY visits desc LIMIT 40");
       $fp = fopen($file, "w+");
       fputs($fp, json_encode($result));
       fclose($fp);
       echo  "sql<br>";
     }
     else {
       $db = \Piwik\Db::get();
       $result = $db->fetchAll("SELECT concat('https://',pageimpressions.url) as full_url,REGEXP_REPLACE(pageimpressions.url,'^[a-zA-Z0-9\.\-]*','') as relative_url,pageimpressions.idsite,COUNT(pageimpressions.idvisit) as visits FROM (SELECT matomo_log_link_visit_action.server_time,REGEXP_REPLACE(action_url.name,'[\?|#].*$', '') as url,matomo_log_link_visit_action.idsite,matomo_log_link_visit_action.idvisit,matomo_log_link_visit_action.idpageview,matomo_log_link_visit_action.idaction_url,action_url.hash,action_url.type FROM matomo_log_link_visit_action INNER JOIN matomo_log_action as action_url ON matomo_log_link_visit_action.idaction_url = action_url.idaction WHERE matomo_log_link_visit_action.server_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE))  AND idsite = " . $idSite . " ORDER BY matomo_log_link_visit_action.idlink_va desc) as pageimpressions GROUP BY `url`, idsite ORDER BY visits desc LIMIT 40");

     }
    $ww=file_get_contents($file);
    print_r(json_decode($ww,true));
    return $this->renderTemplate('myViewTemplate', [
      'rows' => $result,
    ]);


  }


}
