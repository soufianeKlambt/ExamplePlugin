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
   /* $config->setCategoryId('Echtzeit');
    $config->setSubcategoryId('Seitenaufrufe');*/
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
    return $this->renderTemplate('PageImpressionsByDate', array(
      'idSite' => $_GET['idSite'],
      'period' => $_GET['period'],
      'date' => $_GET['date'],

    ));



  }


}
