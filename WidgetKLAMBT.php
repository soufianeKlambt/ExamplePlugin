<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\WidgetKLAMBT;

class WidgetKLAMBT extends \Piwik\Plugin
{


  /**
   * @see \Piwik\Plugin::registerEvents
   */
  public function registerEvents()
  {
    return [
      'AssetManager.getJavaScriptFiles' => 'getJsFiles',
      'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
    ];
  }
  public function getStylesheetFiles(&$stylesheets) {
    $stylesheets[] = 'plugins/WidgetKLAMBT/css/style.css';
  }
  public function getJsFiles(&$jsFiles)
  {
    $jsFiles[] = 'plugins/WidgetKLAMBT/js/Chart.js';
    $jsFiles[] = 'plugins/WidgetKLAMBT/js/refresh.js';
  }


  }
