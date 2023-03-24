<?php

namespace Piwik\Plugins\WidgetKLAMBT;
use Piwik\Cache;
use Matomo\Cache\Lazy;
class WKCache {
  /**
   * @var Lazy
   */
  private $cache;
  private $expire = 500;
  public function __construct()
  {
   $this->cache = Cache::getLazyCache();
  }

  public function getCacheData($name,$sql)
  {
    $cacheKey=$name;
    $result = $this->cache->fetch($cacheKey);
    if (!$result) {
      $db = \Piwik\Db::get();
      $result = $db->fetchAll($sql);
      $this->cache->save($cacheKey,$result, $this->expire);
    }
    return $result;

  }
}