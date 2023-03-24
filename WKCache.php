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
    $expire = 500;
    $cacheKey=$name;
    $result = $this->cache->fetch($cacheKey);
    echo "before<br>";
    if (!$result) {
      echo "not cache";
      $db = \Piwik\Db::get();
      $result = $db->fetchAll($sql);
      $this->cache->save($cacheKey,$result, $expire);
    }
    return $result;

  }
}