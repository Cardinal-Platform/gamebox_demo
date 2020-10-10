<?php

class Check
{
    private $type;
    private $checker = [];
    private $errorMessageTemplate = array();
    private $errorMessage = '';

    public function __construct()
    {
        $this->type = array(
            'uint' => '正整数',
            'ufloat' => '正小数',
            'int' => '整数',
            'float' => '小数',
            'number' => '数字',
            'string' => '字符串',
            'any' => '任意值'
        );

        $this->errorMessageTemplate = array(
            'no_exist' => '(:field) 字段不存在。',
            'empty' => '(:field) 字段为空。',
            'type_error' => '(:field) 字段应为 (:type)。',
            'length_error' => '(:field) 字段长度应为 (:length)。',
            'too_big' => '(:field) 应小于 (:border)。',
            'too_small' => '(:field) 应大于 (:border)。',
            'too_long' => '(:field) 字段长度应小于 (:length)。',
            'too_short' => '(:field) 字段长度应大于 (:length)。',
            'unknown' => '未知错误。'
        );

        $this->checker = array(
            'max' => $this->max_checker(),
            'min' => $this->min_checker(),
            'length' => $this->length_checker(),
            'maxlength' => $this->maxlength_checker(),
            'minlength' => $this->minlength_checker(),
        );

        // make sure unknown existed
        if (!isset($this->errorMessageTemplate['unknown'])) {
            $this->errorMessageTemplate['unknown'] = '未知错误';
        }
    }

    public function has_key($element, array $source = [])
    {

        if (is_array($element)) {
            foreach ($element as $value) {
                if (!key_exists($value, $source)) {
                    return false;
                }
            }
            return true;
        } else {
            // String, just one element
            return key_exists($element, $source);
        }
    }

    public function validate(array $bind, array $data)
    {
        foreach ($bind as $fieldKey => $condition) {
            // $condition 检查并格式化
            if (count($condition) < 2) {
                $this->errorMessage = sprintf('%s 绑定条件数量不正确，为 %d 个。', $fieldKey, count($condition));
                return false;
            }

            // 判断限制条件是否存在
            if (!is_array($condition[1])) {
                $this->errorMessage = sprintf('字段限制条件错误。');
                return false;
            }

            // 未指定是否必要的参数，默认值为必要参数
            if (count($condition) == 2) {
                $bind[$fieldKey][2] = true;
            }

            // 检查数据是否存在
            if ($bind[$fieldKey][2] && !array_key_exists($fieldKey, $data)) {
                $keyName = $bind[$fieldKey][0];     // 获取字段中文名
                $this->errorMessage = $this->new_error_message('no_exist', array('field' => $keyName));
                return false;
            }
        }

        // 数据检查
        foreach ($data as $key => $value) {
            // 反向检查数据是否在限制条件里，可能为多余数据
            if (!in_array($key, array_keys($bind))) {
                continue;
            }
            $fieldName = $bind[$key][0];
            $condition = $bind[$key][1];

            // 遍历限制条件
            foreach ($condition as $item) {
                // 判断是否为类型限制
                if (in_array($item, array_keys($this->type))) {
                    if (!$this->check_type($fieldName, $item, $value)) {
                        return false;
                    }
                } else {
                    // 内容限制
                    $chunk = explode(':', $item);
                    // 解析
                    if (count($chunk) !== 2) {
                        $this->errorMessage = sprintf('字段 %s 限制条件错误：%s', $key, $item);
                        return false;
                    }
                    $check = trim($chunk[0]);
                    $limit = trim($chunk[1]);
                    if (!array_key_exists($check, $this->checker)) {
                        $this->errorMessage = sprintf('检查器 %s 不存在！', $check);
                        return false;
                    }
                    // 运行检查器
                    $checker = $this->checker[$check];
                    if (!$checker($fieldName, $limit, $value)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function get_error_message()
    {
        return $this->errorMessage;
    }

    private function check_type(string $fieldName, string $type, $fieldValue)
    {
        $is_error = false;
        switch ($type) {
            case 'uint':
                $is_error = !is_int($fieldValue) || $fieldValue <= 0;
                break;
            case 'int':
                $is_error = !is_int($fieldValue);
                break;
            case 'ufloat':
                $is_error = !is_float($fieldValue) || $fieldValue <= 0;
                break;
            case 'float':
                $is_error = !is_float($fieldValue);
                break;
            case 'number':
                $is_error = !is_numeric($fieldValue);
                break;
            case 'string':
                $is_error = !is_string($fieldValue);
                break;
        }
        if ($is_error) {
            $this->errorMessage = $this->new_error_message('type_error', array('field' => $fieldName, 'type' => $this->type[$type]));
        }
        return !$is_error;
    }

    private function min_checker()
    {
        return function (string $fieldName, $limit, $value) {
            if ($value < $limit) {
                $this->errorMessage = $this->new_error_message('too_small', array('field' => $fieldName, 'border' => $limit));
                return false;
            }
            return true;
        };
    }

    private function max_checker()
    {
        return function ($fieldName, $limit, $value) {
            if ($value > $limit) {
                $this->errorMessage = $this->new_error_message('too_big', array('field' => $fieldName, 'border' => $limit));
                return false;
            }
            return true;
        };
    }

    private function length_checker()
    {
        return function ($fieldName, $limit, $value) {
            $value = (string)$value;
            $limit = (int)$limit;
            if (strlen($value) !== $limit) {
                $this->errorMessage = $this->new_error_message('length_error', array('field' => $fieldName, 'length' => $limit));
                return false;
            }
            return true;
        };
    }

    private function maxlength_checker()
    {
        return function ($fieldName, $limit, $value) {
            $value = (string)$value;
            $limit = (int)$limit;
            if (strlen($value) > $limit) {
                $this->errorMessage = $this->new_error_message('too_long', array('field' => $fieldName, 'length' => $limit));
                return false;
            }
            return true;
        };
    }

    private function minlength_checker()
    {
        return function ($fieldName, $limit, $value) {
            $value = (string)$value;
            $limit = (int)$limit;
            if (strlen($value) < $limit) {
                $this->errorMessage = $this->new_error_message('too_short', array('field' => $fieldName, 'length' => $limit));
                return false;
            }
            return true;
        };
    }

    private function new_error_message(string $type, array $bind = [])
    {
        if (array_key_exists($type, $this->errorMessageTemplate)) {
            $message = $this->errorMessageTemplate[$type];
            foreach ($bind as $mask => $value) {
                $message = str_replace('(:' . $mask . ')', $value, $message);
            }
            return $message;
        } else {
            return $this->errorMessageTemplate['unknown'];
        }
    }

}