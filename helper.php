<?php


function error($title, $subtitle = '')
{
    $workflow = new \Alfred\Workflows\Workflow();

    $item = $workflow->item()->title($title);
    if ($subtitle) {
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


class Random
{
    const NUMBER = "0123456789";
    const UPPERCASE = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const LOWERCASE = "abcdefghijklmnopqrstuvwxyz";
    const SPECIAL_CHARACTER = '~!@#$%^&*()_+{}[]|\;:"<>,.?/';

    private int $length;

    public function __construct(int $length = 16)
    {
        $this->length = $length;
    }

    function random(): string
    {
        $string = '';
        while (($len = strlen($string)) < $this->length) {
            $size = $this->length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }
        return $string;
    }

    public function randomNumber(): string
    {
        $string = '';
        while (($len = strlen($string)) < $this->length) {
            $size = $this->length - $len;
            $string .= substr(mt_rand(), 0, $size);
        }
        return $string;
    }


    private function randomString(string ...$inputs): string
    {
        $seed = implode('', $inputs);
        $seedLen = strlen($seed);
        $leftSize = $this->length;
        $res = '';
        //先循环保证每个类型都有
        shuffle($inputs);
        for ($i = 0; $i < count($inputs); $i++) {
            $res .= $inputs[$i][mt_rand(0, strlen($inputs[$i]) - 1)];
            $leftSize--;
            if ($leftSize <= 0) {
                return $res;
            }
        }
        while ($leftSize > 0) {
            $rd = mt_rand();
            do {
                $res .= $seed[$rd % $seedLen];
                $leftSize--;
                if ($leftSize <= 0) {
                    break;
                }
            } while (($rd = $rd >> 1) > 0);

        }
        return $res;
    }

    public function randomAll(): string
    {
        return $this->randomString(self::NUMBER, self::UPPERCASE, self::LOWERCASE, self::SPECIAL_CHARACTER);
    }


}