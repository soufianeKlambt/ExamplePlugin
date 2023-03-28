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


class KlambtEchtzeit extends \Piwik\Widget\Widget
{
  public static function configure(WidgetConfig $config)
  {
    $config->setCategoryId('General_Actions');
    $config->setSubcategoryId('Klambt Echtzeit');
  }
  public function render()
  {
    return $this->renderTemplate('TestTemplate', array(
      'answerToLife' => 42
    ));
  }

}
