<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\WidgetKLAMBT;
use Piwik\Cache;
use Matomo\Cache\Lazy;
class WidgetKLAMBT extends \Piwik\Plugin
{
  /**
   * @var Lazy
   */
  private $cache;

  public function __construct()
  {

    $this->cache = Cache::getLazyCache();
  }

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
  }

    // support archiving just this plugin via core:archive
    public function getArchivingAPIMethodForPlugin(&$method, $plugin)
    {
        if ($plugin == 'WidgetKLAMBT') {
            $method = 'WidgetKLAMBT.getExampleArchivedMetric';
        }
    }

  public function get($name,$sql)
  {
    $expire = 24*60*60;
    $cacheKey=$name;
    $result = $this->cache->fetch($cacheKey);
    if (!$result) {
      $db = \Piwik\Db::get();
      $result = $db->fetchAll($sql);
      $this->cache->save($cacheKey,$result, $expire);
    }
    return $result;
  }

  }
