<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Role[] $children
 * @property Role[] $parents
 */
class Role extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app/models', 'Name'),
            'type' => Yii::t('app/models', 'Type'),
            'description' => Yii::t('app/models', 'Description'),
            'rule_name' => Yii::t('app/models', 'Rule Name'),
            'data' => Yii::t('app/models', 'Data'),
            'created_at' => Yii::t('app/models', 'Created At'),
            'updated_at' => Yii::t('app/models', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Role::className(), ['name' => 'child'])->viaTable('{{%role_child}}', ['parent' => 'name']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(Role::className(), ['name' => 'parent'])->viaTable('{{%role_child}}', ['child' => 'name']);
    }

}
