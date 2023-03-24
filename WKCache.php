<?php

namespace Piwik\Plugins\WidgetKLAMBT;
use Piwik\Cache;
use Matomo\Cache\Lazy;
class WKCache {
  /**
   * @var Lazy
   */
  private $cache;
  public function __construct()
  {
   $this->cache = Cache::getLazyCache();
  }

  public function getCacheData($name,$sql)
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