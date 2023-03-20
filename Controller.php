<?php
namespace Piwik\Plugins\WidgetKLAMBT;


class Controller extends \Piwik\Plugin\Controller
{
    public function index()
    {
        // Render the Twig template templates/index.twig and assign the view variable answerToLife to the view.
        return $this->renderTemplate('index', array(
            'answerToLife' => 42
        ));
    }
}
