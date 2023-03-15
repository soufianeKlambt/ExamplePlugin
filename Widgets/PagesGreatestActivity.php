<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\PagesGreatestActivity\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;


class PagesGreatestActivity extends Widget
{
        public static $fixture = null; // initialized below class definition

    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('Besucher');
        $config->setName('Seiten mit größter Aktivität');
        $config->setOrder(99);
    }

    /**
     * This method renders the widget. It's on you how to generate the content of the widget.
     * As long as you return a string everything is fine. You can use for instance a "Piwik\View" to render a
     * twig template. In such a case don't forget to create a twig template (eg. myViewTemplate.twig) in the
     * "templates" directory of your plugin.
     *
     * @return string
     */
    public function render()
    {
       $file = './data.cache';
       $idSite=$_GET['idSite'];
       $db = \Piwik\Db::get();
       $rows = $db->fetchAll("SELECT concat('https://',pageimpressions.url) as full_url,REGEXP_REPLACE(pageimpressions.url,'^[a-zA-Z0-9\.\-]*','') as relative_url,pageimpressions.idsite,COUNT(pageimpressions.idvisit) as visits FROM (SELECT matomo_log_link_visit_action.server_time,REGEXP_REPLACE(action_url.name,'[\?|#].*$', '') as url,matomo_log_link_visit_action.idsite,matomo_log_link_visit_action.idvisit,matomo_log_link_visit_action.idpageview,matomo_log_link_visit_action.idaction_url,action_url.hash,action_url.type FROM matomo_log_link_visit_action INNER JOIN matomo_log_action as action_url ON matomo_log_link_visit_action.idaction_url = action_url.idaction WHERE matomo_log_link_visit_action.server_time >= (DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 MINUTE))  AND idsite = ".$idSite." ORDER BY matomo_log_link_visit_action.idlink_va desc) as pageimpressions GROUP BY `url`, idsite ORDER BY visits desc LIMIT 40");
       $fp = fopen($file,"w+");
       fwrite($fp,"sss");
       fclose($fp);
       $filename = './test.txt';
$somecontent = "Add this to the file\n";

// Let's make sure the file exists and is writable first.
if (is_writable($filename)) {

    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$fp = fopen($filename, 'a')) {
         echo "Cannot open file ($filename)";
        
    }

    // Write $somecontent to our opened file.
    if (fwrite($fp, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
       
    }

    echo "Success, wrote ($somecontent) to file ($filename)";

    fclose($fp);

} else {
    echo "The file $filename is not writable";
}
       return $this->renderTemplate('myViewTemplate', array(
            'rows' =>  file_get_contents($file),
        ));

       
    }

}
