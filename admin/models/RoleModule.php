<?php

namespace admin\models;

use Yii;
use common\mypublic\Myfunction;

/**
 * This is the model class for table "role_module".
 *
 * @property string $r_id
 * @property string $r_name 角色名称
 * @property string $m_id
 * @property string $m_name 模块名称
 * @property string $m_link_url 模块链接地址
 * @property bool $m_is_menu 是否是目录
 * @property string $m_rank
 * @property string $p_id
 * @property string $p_name 权限名称
 * @property string $p_module_code 模块编号
 */
class RoleModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['r_id', 'r_name', 'm_id', 'm_name', 'm_link_url', 'p_id', 'p_name', 'p_module_code'], 'required'],
            [['m_is_menu'], 'boolean'],
            [['m_rank'], 'number'],
            [['r_id', 'm_id', 'p_id'], 'string', 'max' => 32],
            [['r_name', 'm_name', 'p_name'], 'string', 'max' => 20],
            [['m_link_url'], 'string', 'max' => 50],
            [['p_module_code'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'r_id' => 'R ID',
            'r_name' => 'R Name',
            'm_id' => 'M ID',
            'm_name' => 'M Name',
            'm_link_url' => 'M Link Url',
            'm_is_menu' => 'M Is Menu',
            'm_rank' => 'M Rank',
            'p_id' => 'P ID',
            'p_name' => 'P Name',
            'p_module_code' => 'P Module Code',
        ];
    }
}
