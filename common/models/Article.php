<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id ID
 * @property string $title 标题
 * @property string $content 内容
 * @property int $category_id 分类
 * @property int $status 状态
 * @property int $created_by 创建人
 * @property int $created_at 创建时间
 * @property int $updated_at 最后修改时间
 *
 * @property Adminuser $createdBy
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * 文章状态
     */

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 10;

    public static function allStatus()
    {
        return [self::STATUS_DRAFT=>'草稿',self::STATUS_PUBLISHED=>'已发布'];
    }

    public function getStatusStr()
    {
        return $this->status==self::STATUS_DRAFT?'草稿':'已发布';
    }

    /**
     * 文章分类
     */

    private static $cateStrArray = [ 1=>'静态页面',
        2=>'网站公告',
        3=>'行业新闻'];

    public static function allCategory()
    {
        return self::$cateStrArray;
    }

    public function getCateStr()
    {
        return self::$cateStrArray[$this->category_id];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['category_id', 'status', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 512],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Adminuser::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'created_by']);
    }

    /**
     * 重写查询字段过滤
     */
    public function fields(){
        return[
            'id',
            'title',
            'status'=>function($model){
                return $model->status==self::STATUS_DRAFT?'草稿':'已发布';
            },
            'createdBy'=>function($model){
            return $model->createdBy['realname'];
            }
        ];
    }
}
