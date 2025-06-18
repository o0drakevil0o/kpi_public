<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_resulte".
 *
 * @property int $id
 * @property int|null $kpi_id ตัวชี้วัดหลัก
 * @property int $child_id ตัวชี้วัดรอง
 * @property int|null $subchild_id ตัวชี้้ย่อย
 * @property int $hcode สถานบริการ
 * @property string|null $target เป้าหมาย
 * @property float|null $value_a ค่าตัวแปร a
 * @property float|null $value_b ค่าตัวแปร b
 * @property float|null $value_c ค่าตัวแปร c
 * @property float|null $value_d ค่าตัวแปร d
 * @property string|null $result ผลลัพธ์
 * @property int|null $reslute_check 4.ผ่าน 3.อยู่ระหว่างดำเนินการ 2.ไม่ผ่าน 1.ไม่ประเมิน
 * @property int|null $send_type ประเภทการส่ง 1.รายเดือน 2.รายไตรมาส 3.ครึ่งปี 4.รายปี
 * @property int|null $successkey กุญแจแห่งความสำเร็จ
 * @property int|null $budyear ปีงบ
 * @property int|null $user_key ผู้ลงข้อมูล
 * @property int|null $position ตำแหน่ง
 * @property string|null $created_at
 * @property int|null $crearted_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $count ปี/ครึ่งปี/ไตรมาส/เดือน/
 */
class KpResulte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_resulte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id', 'child_id', 'subchild_id', 'hcode', 'reslute_check', 'send_type', 'successkey', 'budyear', 'user_key', 'position', 'crearted_by', 'updated_by', 'count'], 'integer'],
            [['child_id', 'hcode'], 'required'],
            [['value_a', 'value_b', 'value_c', 'value_d'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['target', 'result'], 'string', 'max' => 255],
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
            'hcode' => 'Hcode',
            'target' => 'Target',
            'value_a' => 'Value A',
            'value_b' => 'Value B',
            'value_c' => 'Value C',
            'value_d' => 'Value D',
            'result' => 'Result',
            'reslute_check' => 'Reslute Check',
            'send_type' => 'Send Type',
            'successkey' => 'Successkey',
            'budyear' => 'Budyear',
            'user_key' => 'User Key',
            'position' => 'Position',
            'created_at' => 'Created At',
            'crearted_by' => 'Crearted By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'count' => 'Count',
        ];
    }
}
