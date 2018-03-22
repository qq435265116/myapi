<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/8
 * Time: 12:01
 */

namespace common\myerror;



interface  Hint {
    function  Error($_errors,$code);
}