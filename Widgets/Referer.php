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
    $file = '/var/www/html/cache/WidgetKLAMBT-referer-site-' . $idSite . '.cache';
    $expire = 300;
    if (filemtime($file) < (time() - $expire)) {
      $db = \Piwik\Db::get();
      $result = $db->fetchAll("SELECT referer_name, count(idvisit) as visits FROM matomo_log_visit WHERE idsite = ".$idSite." AND visit_last_action_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE)) AND referer_name is NOT NULL GROUP BY referer_name ORDER BY visits desc LIMIT 10");
      $fp = fopen($file, "w");
      fputs($fp, json_encode($result));
      fclose($fp);
    }
    else {
      $result =json_decode( file_get_contents($file),true);
    }
    return $this->renderTemplate('refererTemplate', [
      'rows' => $result,
    ]);


  }


}
