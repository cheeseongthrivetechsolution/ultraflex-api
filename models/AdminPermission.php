<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_permission".
 *
 * @property int $admin_permission_id
 * @property int $admin_type_id
 * @property int $module_id
 * @property string $admin_permission_view
 * @property string $admin_permission_add
 * @property string $admin_permission_update
 * @property string $admin_permission_export
 * @property string $admin_permission_create_time
 */
class AdminPermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_type_id', 'module_id'], 'required'],
            [['admin_type_id', 'module_id'], 'integer'],
            [['admin_permission_view', 'admin_permission_add', 'admin_permission_update', 'admin_permission_export'], 'string'],
            [['admin_permission_create_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'admin_permission_id' => 'Admin Permission ID',
            'admin_type_id' => 'Admin Type ID',
            'module_id' => 'Module ID',
            'admin_permission_view' => 'Admin Permission View',
            'admin_permission_add' => 'Admin Permission Add',
            'admin_permission_update' => 'Admin Permission Update',
            'admin_permission_export' => 'Admin Permission Export',
            'admin_permission_create_time' => 'Admin Permission Create Time',
        ];
    }
}
