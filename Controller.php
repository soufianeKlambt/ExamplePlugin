<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Live;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Config;
use Piwik\Piwik;
use Piwik\DataTable;
use Piwik\Plugins\Live\Exception\MaxExecutionTimeExceededException;
use Piwik\Plugins\Live\Visualizations\VisitorLog;
use Piwik\Url;
use Piwik\View;

/**
 */
class Controller extends \Piwik\Plugin\Controller
{

}
