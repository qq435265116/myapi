<?php
/**
 * Created by PhpStorm.
 * User: KNKJ-3
 * Date: 2018/3/8
 * Time: 13:55
 */

namespace common\myerror;


class FactoryMsg implements createMsg
{
    function Msg() {
        return  new  Template;
    }
}