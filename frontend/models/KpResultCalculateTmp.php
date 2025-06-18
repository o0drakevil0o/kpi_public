<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kp_result_calculate_tmp".
 *
 * @property int $id
 * @property int|null $kpt_id
 * @property int $kpi_id
 * @property int $child_id
 * @property int $sub_id
 * @property string|null $name
 * @property int|null $reslute_check
 * @property int|null $reslut_total
 * @property string|null $condition
 * @property string|null $result
 * @property int|null $PASS_CHECK
 * @property int|null $SENT_COUNT_DATA
 * @property string|null $people_target
 * @property string|null $BUDYEAR_NAME
 * @property int|null $count
 * @property int|null $send_type
 * @property string|null $send_type_name
 * @property string|null $STRAT_NAME
 * @property string|null $description
 * @property string|null $min_traget
 * @property int|null $level_id
 * @property string|null $level_name
 */
class KpResultCalculateTmp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kp_result_calculate_tmp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpt_id', 'kpi_id', 'child_id', 'sub_id', 'reslute_check', 'reslut_total', 'PASS_CHECK', 'SENT_COUNT_DATA', 'count', 'send_type', 'level_id'], 'integer'],
            [['kpi_id', 'child_id', 'sub_id'], 'required'],
            [['name', 'condition', 'result', 'people_target', 'BUDYEAR_NAME', 'send_type_name', 'STRAT_NAME', 'description', 'min_traget', 'level_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kpt_id' => 'Kpt ID',
            'kpi_id' => 'Kpi ID',
            'child_id' => 'Child ID',
            'sub_id' => 'Sub ID',
            'name' => 'Name',
            'reslute_check' => 'Reslute Check',
            'reslut_total' => 'Reslut Total',
            'condition' => 'Condition',
            'result' => 'Result',
            'PASS_CHECK' => 'Pass Check',
            'SENT_COUNT_DATA' => 'Sent  Count Data',
            'people_target' => 'People Target',
            'BUDYEAR_NAME' => 'Budyear Name',
            'count' => 'Count',
            'send_type' => 'Send Type',
            'send_type_name' => 'Send Type Name',
            'STRAT_NAME' => 'Strat Name',
            'description' => 'Description',
            'min_traget' => 'Min Traget',
            'level_id' => 'Level ID',
            'level_name' => 'Level Name',
        ];
    }
}
