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
     $result= null;//$cache->getCacheData('PGA-'.$idSite,$sql);
    $sum = 0;
    foreach($result as $values) {
      $sum += $values[ 'visits' ];
    }
    return $this->renderTemplate('PGATemplate', [
      'rows' => $result,
      'sum' => $sum,
    ]);
  }


}
