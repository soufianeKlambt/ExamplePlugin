<?php

namespace Piwik\Plugins\WidgetKLAMBT;
use Piwik\Cache;
use Matomo\Cache\Lazy;
class WKCache {
  /**
   * @var Lazy
   */
  private $cache;
  private int $expire = 300;
  public function __construct()
  {
   $this->cache = Cache::getLazyCache();
  }

  public function getCacheData($name,$sql)
  {
    $result = $this->cache->fetch($name);
    if (!$result) {
      $db = \Piwik\Db::get();
      $result = $db->fetchAll($sql);
      $this->cache->save($name,$result, $this->expire);
    }
    return $result;

  }
}