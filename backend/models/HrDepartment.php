<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hr_department".
 *
 * @property string $HR_DEPARTMENT_ID รหัสกลุ่มงาน
 * @property string|null $HR_DEPARTMENT_NAME ชื่อกุล่มงาน
 * @property string|null $BOOK_NUM เลขที่หนังสือกลุ่มงาน
 * @property string|null $ACTIVE สถานะ
 * @property string|null $BOOK_HR_ID สารบรรณกลุ่มงาน
 * @property string|null $LEADER_HR_ID หัวหน้ากลุ่มงาน
 * @property string|null $PHONE_IN เบอร์โทรภายใน
 * @property string|null $LINE_TOKEN_SET
 * @property string|null $ISORGOUT True เป็นองค์กรภายนอก
 * @property int|null $HR_DEPART_ID รหัสกลุ่มภารกิจ
 * @property string|null $ISPLAN เปิดใช้แผนงานโครงการ
 */
class HrDepartment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hr_department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HR_DEPARTMENT_ID'], 'required'],
            [['ACTIVE'], 'string'],
            [['HR_DEPART_ID'], 'integer'],
            [['HR_DEPARTMENT_ID'], 'string', 'max' => 11],
            [['HR_DEPARTMENT_NAME'], 'string', 'max' => 100],
            [['BOOK_NUM'], 'string', 'max' => 255],
            [['BOOK_HR_ID', 'LEADER_HR_ID'], 'string', 'max' => 10],
            [['PHONE_IN'], 'string', 'max' => 30],
            [['LINE_TOKEN_SET'], 'string', 'max' => 200],
            [['ISORGOUT', 'ISPLAN'], 'string', 'max' => 5],
            [['HR_DEPARTMENT_ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'HR_DEPARTMENT_ID' => 'Hr Department ID',
            'HR_DEPARTMENT_NAME' => 'Hr Department Name',
            'BOOK_NUM' => 'Book Num',
            'ACTIVE' => 'Active',
            'BOOK_HR_ID' => 'Book Hr ID',
            'LEADER_HR_ID' => 'Leader Hr ID',
            'PHONE_IN' => 'Phone In',
            'LINE_TOKEN_SET' => 'Line Token Set',
            'ISORGOUT' => 'Isorgout',
            'HR_DEPART_ID' => 'Hr Depart ID',
            'ISPLAN' => 'Isplan',
        ];
    }
}
