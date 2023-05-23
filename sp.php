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

if (isset($input[0])){
    $len = $input[0];
}

$res = random($len);


$workflow->item()
    ->title($res)
    ->subtitle($len)
//    ->icon('sp.png')
    ->copy($res)//在列表中使用 ⌘C 复制操作的值
    ->variable("data", $res);//设置变量后，Alfre可以通过{var:var_name}来获取，比如复制剪切板

return $workflow->output();



function random($length = 16)
{
    $string = '';

    while (($len = strlen($string)) < $length) {
        $size = $length - $len;

        $bytes = random_bytes($size);

        $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
    }

    return $string;
}