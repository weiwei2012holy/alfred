<?php
require __DIR__ . '/vendor/autoload.php';

use Alfred\Workflows\Workflow;

/**
 * 时间戳和日期的相互转换
 * workflow文档:https://www.alfredapp.com/help/workflows/inputs/script-filter/json/
 * 脚本的核心就是输出一个json字符串，其中的字段定义在上面的文档中
 */

$workflow = new Workflow();

$input = $workflow->arguments();


$len = 16;

if (isset($input[0])) {
    $len = $input[0];
}

$tool = new Random($len);

$res = $tool->random();
$resUpper = strtoupper($tool->random());
$resNumber = $tool->randomNumber();
$resAll= $tool->randomAll();



$workflow->item()
    ->title($res)
    ->subtitle("字母+数字")
    ->copy($res)//在列表中使用 ⌘C 复制操作的值
    ->variable("data", $res);//设置变量后，Alfre可以通过{var:var_name}来获取，比如复制剪切板

$workflow->item()
    ->title($resUpper)
    ->subtitle("大写字母+数字")
    ->copy($resUpper)//在列表中使用 ⌘C 复制操作的值
    ->variable("data", $resUpper);//设置变量后，Alfre可以通过{var:var_name}来获取，比如复制剪切板

$workflow->item()
    ->title($resNumber)
    ->subtitle("纯数字")
    ->copy($resNumber)//在列表中使用 ⌘C 复制操作的值
    ->variable("data", $resNumber);//设置变量后，Alfre可以通过{var:var_name}来获取，比如复制剪切板

$workflow->item()
    ->title($resAll)
    ->subtitle("字母+数字+特殊字符")
    ->copy($resAll)//在列表中使用 ⌘C 复制操作的值
    ->variable("data", $resAll);//设置变量后，Alfre可以通过{var:var_name}来获取，比如复制剪切板

return $workflow->output();







