<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_department_register".
 *
 * @property int $id
 * @property int|null $kpi_id ตัวชี้วัดหลัก
 * @property int|null $child_id ตัวชี้วัดรอง
 * @property int|null $subchild_id ตัวชี้วัดย่อย
 * @property int|null $department ประเภทการส่ง
 */
class KpDepartmentRegister extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_department_register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id', 'child_id', 'subchild_id', 'department'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kpi_id' => 'Kpi ID',
            'child_id' => 'Child ID',
            'subchild_id' => 'Subchild ID',
            'department' => 'Department',
        ];
    }
}
