#!/bin/bash

# alfred workflow 脚本
# 使用方法:
# 1. 创建workflow,右键选中input->script filter(创建触发命令,比如ww)->使用bash 执行脚本
# 2. 填入脚本内容
# query=$1
# [你的脚本路径]/prompt.sh [你的json文件路径] $query
# 3.增加一个clipboard,复制变量 {var:prompt}
# 4.增加一个关闭动作
# 5.现在使用Alfred 输入对应的命令ww即可触发,回车即可复制到剪切板

# 脚本功能：根据传入的参数过滤 JSON 配置文件中的数据
# 参数说明：
#   $1 JSON配置文件路径
#   $2 需要过滤的 prompt 字段值, 可选

# 检查参数是否传入
if [ -z "$1" ]; then
    echo "请传入至少一个参数: 1.JSON文件路径 [2.过滤参数(可选)]"
    exit 1
fi

JSON_FILE="$1"
FILTER_PARAM="$2"

# 检查 JSON 文件是否存在
if [ ! -f "$JSON_FILE" ]; then
    echo "指定的 JSON 文件不存在: $JSON_FILE"
    exit 1
fi

# 检查 jq 是否安装
if ! command -v jq &> /dev/null; then
    echo "请先安装 jq 工具"
    exit 1
fi

# 如果未传过滤参数, 默认返回前10条
if [ -z "$FILTER_PARAM" ]; then
    jq -c '{
        items: [ .[] | {subtitle: .prompt, text: {copy: .prompt}, title: .title, variables: {prompt: .prompt}} ][0:10]
    }' "$JSON_FILE"
else
    # 传入过滤参数时, 按条件过滤
    jq -c --arg filter "$FILTER_PARAM" '{
        items: [
            .[] 
            | select((.title | contains($filter)) or (.prompt | contains($filter)))
            | {subtitle: .prompt, text: {copy: .prompt}, title: .title, variables: {prompt: .prompt}}
        ]
    }' "$JSON_FILE"
fi