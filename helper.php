<?php


function error($title, $subtitle = '')
{
    $workflow = new \Alfred\Workflows\Workflow();

    $item = $workflow->item()->title($title);
    if ($subtitle){
        $item->subtitle($subtitle);
    }
    return $workflow->output();
}

function errorHandler($level, $error, $file, $line)
{
    $workflow = new \Alfred\Workflows\Workflow();
    $workflow->item()->title($error);
    $workflow->output(true);
    die();
}