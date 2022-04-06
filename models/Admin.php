<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $admin_id
 * @property int $admin_type
 * @property string $admin_username
 * @property string $admin_password
 * @property string $admin_password_salt
 * @property string $admin_name
 * @property string|null $admin_email
 * @property string|null $admin_dob
 * @property string|null $admin_image
 * @property string $admin_sound
 * @property string|null $admin_phone
 * @property string|null $admin_remark
 * @property string $admin_status
 * @property string|null $admin_last_login
 * @property string $admin_create_time
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_type', 'admin_username', 'admin_password', 'admin_password_salt', 'admin_name'], 'required'],
            [['admin_type'], 'integer'],
            [['admin_dob', 'admin_last_login', 'admin_create_time'], 'safe'],
            [['admin_sound', 'admin_status'], 'string'],
            [['admin_username'], 'string', 'max' => 126],
            [['admin_password', 'admin_password_salt', 'admin_name', 'admin_email', 'admin_image', 'admin_phone', 'admin_remark'], 'string', 'max' => 255],
            [['admin_username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'admin_type' => 'Admin Type',
            'admin_username' => 'Admin Username',
            'admin_password' => 'Admin Password',
            'admin_password_salt' => 'Admin Password Salt',
            'admin_name' => 'Admin Name',
            'admin_email' => 'Admin Email',
            'admin_dob' => 'Admin Dob',
            'admin_image' => 'Admin Image',
            'admin_sound' => 'Admin Sound',
            'admin_phone' => 'Admin Phone',
            'admin_remark' => 'Admin Remark',
            'admin_status' => 'Admin Status',
            'admin_last_login' => 'Admin Last Login',
            'admin_create_time' => 'Admin Create Time',
        ];
    }
}
