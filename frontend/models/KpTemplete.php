<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_templete".
 *
 * @property int $id
 * @property int|null $kpi_id
 * @property int|null $child_id
 * @property int|null $sub_id
 * @property string|null $tem_kpiname ชื่อตัวชี้วัด
 * @property string|null $tem_dic คำอธิบายตัวชี้วัด
 * @property string|null $tem_unit หน่วยตัวชี้วัด
 * @property string|null $unit_a หน่วยตัวชี้วัด A
 * @property string|null $dic_a นิยามตัวแปร A
 * @property string|null $unit_b หน่วยตัวชี้วัด B
 * @property string|null $dic_b นิยามตัวแปร B
 * @property string|null $unit_c หน่วยตัวชี้วัด C
 * @property string|null $dic_c นิยามตัวแปร C
 * @property string|null $unit_d หน่วยตัวชี้วัด D
 * @property string|null $dic_d นิยามตัวแปร D
 * @property string|null $cal วิธีการคำนวณ
 * @property string|null $min_traget เป้าหมายต่ำสุด
 * @property string|null $people_target ประชาชนกลุ่มเป้าหมาย
 * @property string|null $process_data วิธรการจัดเก็บข้อมูล 
 * @property string|null $description แหล่งข้อมูล
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $support_people ผู้รับผิดชอบ/ดูแลจัดการ
 * @property string|null $condition เงื่อนไขตัวชี้วัด
 * @property float|null $weight ค่าน้ำหนักัตัวชี้วัด
 * @property int|null $send_type ประเภทการส่ง
 * @property int|null $plan แผนยุทธศาสตร์
 */
class KpTemplete extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_templete';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id', 'child_id', 'sub_id', 'created_at', 'updated_at', 'support_people', 'send_type', 'plan'], 'integer'],
            [['tem_kpiname', 'tem_dic', 'tem_unit', 'unit_a', 'dic_a', 'unit_b', 'dic_b', 'unit_c', 'dic_c', 'unit_d', 'dic_d', 'cal', 'min_traget', 'people_target', 'process_data', 'description'], 'string'],
            [['weight'], 'number'],
            [['condition'], 'string', 'max' => 2],
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
            'sub_id' => 'Sub ID',
            'tem_kpiname' => 'Tem Kpiname',
            'tem_dic' => 'Tem Dic',
            'tem_unit' => 'Tem Unit',
            'unit_a' => 'Unit A',
            'dic_a' => 'Dic A',
            'unit_b' => 'Unit B',
            'dic_b' => 'Dic B',
            'unit_c' => 'Unit C',
            'dic_c' => 'Dic C',
            'unit_d' => 'Unit D',
            'dic_d' => 'Dic D',
            'cal' => 'Cal',
            'min_traget' => 'Min Traget',
            'people_target' => 'People Target',
            'process_data' => 'Process Data',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'support_people' => 'Support People',
            'condition' => 'Condition',
            'weight' => 'Weight',
            'send_type' => 'Send Type',
            'plan' => 'Plan',
        ];
    }
}
