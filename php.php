<?php
/**
 * 运行PHP函数
 */

require __DIR__ . '/vendor/autoload.php';

use Alfred\Workflows\Workflow;

set_error_handler("errorHandler");
$workflow = new Workflow();

$inputs = $workflow->arguments();

$cmd = array_shift($inputs);

if (!function_exists($cmd)) {
    return error('输入有效方法&参数以继续', 'function ( arg1 , arg2 ... )');
} else {

    $ref = new ReflectionFunction($cmd);

    $str = '';
    foreach ($ref->getParameters() as $parameter) {
        $str .= sprintf("%s,", $parameter->getName());
    }


    $str = trim($str,',');
    $subTitle = sprintf('%s(%s)', $cmd, $str);

    if ($ref->getNumberOfRequiredParameters() > count($inputs)){
        return error("函数DOC",$subTitle);
    }

    try {
        $res = $cmd(...$inputs);
    } catch (Throwable $exception) {
        return error($exception->getMessage(),$subTitle);
    }

//    $subTitle = sprintf('%s(%s)', $cmd, implode(',', $inputs));
    $workflow->item()
        ->title($res)
        ->subtitle($subTitle)
        ->copy($res)//在列表中使用 ⌘C 复制操作的值
        ->variable("data", $res);//设置变量后，Alfre可以通过{var:data}来获取，比如复制剪切板
}

$workflow->output();





