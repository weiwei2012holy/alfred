<?php
require __DIR__ . '/vendor/autoload.php';

use Alfred\Workflows\Workflow;

/**
 * 时间戳和日期的相互转换
 * workflow文档:https://www.alfredapp.com/help/workflows/inputs/script-filter/json/
 * 脚本的核心就是输出一个json字符串，其中的字段定义在上面的文档中
 */

$workflow = new Workflow();

$input = implode(" ", $workflow->arguments());


if ($input == "") {
    $input = "now";
}


$tz = 'Asia/Shanghai';
date_default_timezone_set($tz);


$v1 = '';
if (is_numeric($input)) {
    $res = \Carbon\Carbon::createFromTimestamp($input);
    $dateList = formatDate($res);
    $subtitle = $input;
} else {
    $res = \Carbon\Carbon::parse($input);
    if (!$res) {
        $res = "无效的日期字符串";
    }
    $subtitle = $input;
    $dateList[] = [$res->getTimestamp(), 'Timestamp'];
    if ($input == 'now') {
        $dateList = array_merge($dateList, formatDate($res));
    }
}

foreach ($dateList as [$v, $type]) {
    $workflow->item()
        ->title($v)
        ->subtitle($subtitle . ' ' . $type)
//        ->icon('date-res.png')
        ->copy($v)//在列表中使用 ⌘C 复制操作的值
        ->variable("date", $v);//设置变量后，Alfre可以通过{var:var_name}来获取，比如复制剪切板
}


return $workflow->output();

function formatDate($res): array
{
    $dateList[] = [$res->toDateTimeString(), ''];
    $dateList[] = [$res->toIso8601String(), 'Iso8601'];
    $dateList[] = [$res->toIso8601ZuluString(), 'Iso8601Zulu'];
    return $dateList;
}