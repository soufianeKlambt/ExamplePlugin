<?php

namespace Piwik\Plugins\WidgetKLAMBT;
use Piwik\Cache;
use Matomo\Cache\Lazy;
class WKCache {
  /**
   * @var Lazy
   */
  private $cache;
  protected $name = null;
  public function __construct($name)
  {
    $this->name = $name;
    $this->cache = Cache::getLazyCache();
  }

  public function getData($id,$sql)
  {
    $expire = 24*60*60;
    $cacheKey=$this->name.'_'.$id;
    $result = $this->cache->fetch($cacheKey);
    if (!$result) {
      $db = \Piwik\Db::get();
      $result = $db->fetchAll($sql);
      $this->cache->save($cacheKey,$result, $expire);
    }
    return $result;

  }
}