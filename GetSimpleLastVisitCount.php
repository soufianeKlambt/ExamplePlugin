<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Live\Reports;

use Piwik\Config;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugins\Live\Controller;
use Piwik\API\Request;
use Piwik\Plugins\Live\Exception\MaxExecutionTimeExceededException;
use Piwik\Report\ReportWidgetFactory;
use Piwik\View;
use Piwik\Widget\WidgetsList;

class GetSimpleLastVisitCount extends Base
{
  public static function configure(WidgetConfig $config) {
    $config->setCategoryId('Besucher');
    $config->setName('KLAMBT besucher');
    $config->setOrder(96);
  }

    public function render()
    {
        $lastMinutes = Config::getInstance()->General[Controller::SIMPLE_VISIT_COUNT_WIDGET_LAST_MINUTES_CONFIG_KEY];

        $params    = array('lastMinutes' => $lastMinutes, 'showColumns' => array('visits', 'visitors', 'actions'));
        $refereshAfterSeconds = Config::getInstance()->General['live_widget_refresh_after_seconds'];

        $error = '';
        try {
            $lastNData = Request::processRequest('Live.getCounters', $params);
        } catch (MaxExecutionTimeExceededException $e) {
            $error = $e->getMessage();
            $lastNData = [0 => ['visitors' => '-', 'visits' => '-', 'actions' => '-']];
            $refereshAfterSeconds = 999999999; // we don't want it to refresh again any time soon as same issue would happen again
        }

        $formatter = new Formatter();

        $view = new View('getSimpleLastVisitCount');
        $view->error = $error;
        $view->lastMinutes = $lastMinutes;
        $view->visitors    = $formatter->getPrettyNumber($lastNData[0]['visitors']);
        $view->visits      = $formatter->getPrettyNumber($lastNData[0]['visits']);
        $view->actions     = $formatter->getPrettyNumber($lastNData[0]['actions']);
        $view->refreshAfterXSecs = $refereshAfterSeconds;
        $view->translations = array(
            'one_visitor' => Piwik::translate('Live_NbVisitor'),
            'visitors'    => Piwik::translate('Live_NbVisitors'),
            'one_visit'   => Piwik::translate('General_OneVisit'),
            'visits'      => Piwik::translate('General_NVisits'),
            'one_action'  => Piwik::translate('General_OneAction'),
            'actions'     => Piwik::translate('VisitsSummary_NbActionsDescription'),
            'one_minute'  => Piwik::translate('Intl_OneMinute'),
            'minutes'     => Piwik::translate('Intl_NMinutes')
        );

        return $view->render();
    }
}
