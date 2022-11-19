<?php
require __DIR__ . '/vendor/autoload.php';

use Alfred\Workflows\Workflow;

/**
 * 时间戳和日期的相互转换
 * workflow文档:https://www.alfredapp.com/help/workflows/inputs/script-filter/json/
 * 脚本的核心就是输出一个json字符串，其中的字段定义在上面的文档中
 */

$workflow = new Workflow();

$input = implode(" ",$workflow->arguments());

if ($input == "") {
    $input = "now";
}
date_default_timezone_set('Asia/Shanghai');

$res = "";
if (is_numeric($input)) {
    $res = date("Y-m-d H:i:s", $input);
} else {
    $res = strtotime($input);
    if (!$res) {
        $res = "无效的日期字符串";
    }
}

$workflow->item()
    ->title($res)
    ->subtitle($input)
    ->icon('date-res.png')
    ->copy($res)//在列表中使用 ⌘C 复制操作的值
    ->variable("date", $res);//设置变量后，Alfre可以通过{var:var_name}来获取，比如复制剪切板

return $workflow->output();