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


class KlambtEchtzeit extends \Piwik\Widget\Widget
{

  public static function configure(WidgetConfig $config)
  {
    $config->setCategoryId('Echtzeit');
    $config->setSubcategoryId('Besucher');
  }
  public function render()
  {
    $idSite= $_GET['idSite'];
    return $this->renderTemplate('EchtzeitTemplate', array(
      'referer' => $this->getReferer($idSite),
      'pageViews' => $this->getPageViews($idSite),
      'PGA' => $this->getPagesGreatestActivity($idSite),
      'devices' => $this->getDevices($idSite),
    ));
  }

  public  function getReferer($idSite){
    $sql="SELECT referer_name, count(idvisit) as visits FROM matomo_log_visit WHERE idsite = ".$idSite." AND visit_last_action_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE)) AND referer_name is NOT NULL GROUP BY referer_name ORDER BY visits desc LIMIT 10";
    $cache=new WKCache();
    $result= $cache->getCacheData('Referer-'.$idSite,$sql);
    return $result;
  }


  public function  getPageViews($idSite){
    $sql="SELECT TIMESTAMPDIFF(Minute,UTC_TIMESTAMP(),matomo_log_link_visit_action.server_time) as timeinterval, count(matomo_log_action.name) as hits FROM matomo_log_link_visit_action INNER JOIN matomo_log_action ON matomo_log_link_visit_action.idaction_url = matomo_log_action.idaction WHERE matomo_log_link_visit_action.server_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE)) AND matomo_log_link_visit_action.idsite = ".$idSite." GROUP BY timeinterval DESC LIMIT 0,31";
    $cache=new WKCache();
    $result= $cache->getCacheData('PageView-'.$idSite,$sql);
    $xValues= array();
    $yValues= array();
    foreach($result as $values) {
      $xValues[]=$values['timeinterval'];
      $yValues[]=$values['hits'];
    }
    return array(
      'xValues' => $xValues,
      'yValues' => $yValues,
    );
  }
  public function getPagesGreatestActivity($idSite){
    $sql = "SELECT concat('https://',pageimpressions.url) as full_url,REGEXP_REPLACE(pageimpressions.url,'^[a-zA-Z0-9\.\-]*','') as relative_url,pageimpressions.idsite,COUNT(pageimpressions.idvisit) as visits FROM (SELECT matomo_log_link_visit_action.server_time,REGEXP_REPLACE(action_url.name,'[\?|#].*$', '') as url,matomo_log_link_visit_action.idsite,matomo_log_link_visit_action.idvisit,matomo_log_link_visit_action.idpageview,matomo_log_link_visit_action.idaction_url,action_url.hash,action_url.type FROM matomo_log_link_visit_action INNER JOIN matomo_log_action as action_url ON matomo_log_link_visit_action.idaction_url = action_url.idaction WHERE matomo_log_link_visit_action.server_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE))  AND idsite = " . $idSite . " ORDER BY matomo_log_link_visit_action.idlink_va desc) as pageimpressions GROUP BY `url`, idsite ORDER BY visits desc LIMIT 40";
    $cache=new WKCache();
    $result= $cache->getCacheData('PGA-'.$idSite,$sql);
    $sum = 0;
    foreach($result as $values) {
      $sum += $values[ 'visits' ];
    }
    return  array(
      'result' => $result,
      'sum' => $sum,
    );
  }

  public function getDevices($idSite){
    $sql = "SELECT CASE WHEN config_device_type = 1  THEN 'Mobilgerät' WHEN config_device_type = 0  THEN 'Tablet' WHEN config_device_type = 10 THEN 'Tablet' WHEN config_device_type = 2  THEN 'Computer' ELSE 'andere' END as devices, count(idvisit) as visits FROM matomo_log_visit WHERE idsite = ".$idSite." AND visit_last_action_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 5 MINUTE)) GROUP BY devices ORDER BY visits desc LIMIT 10";
    $cache=new WKCache();
    $result= $cache->getCacheData('Devices-'.$idSite,$sql);
    $sum = 0;
    foreach($result as $values) {
      $sum += $values[ 'visits' ];
    }
    return  array(
      'result' => $result,
      'sum' => $sum,
    );
  }

}
