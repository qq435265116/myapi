<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/8
 * Time: 13:54
 */

namespace common\myerror;


class Template implements Hint
{
    function Error($_errors,$code) {
        if (empty($_errors)) {

            print_r(json_encode([]));
        } else {
            $errors['data']['data']    = '';
            $errors['data']['msg'] = $_errors;
            $errors['data']['code'] = $code;
            echo json_encode($errors,JSON_UNESCAPED_UNICODE);
        }
    }
}