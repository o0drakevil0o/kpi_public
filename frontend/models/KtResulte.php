<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "kt_resulte".
 *
 * @property int $id
 * @property int|null $owner
 * @property int|null $main_id
 * @property int|null $submain_id
 * @property int|null $budyear_id
 * @property int|null $month_id
 * @property int|null $year
 * @property string|null $target
 * @property int|null $success
 * @property int|null $processing
 * @property int|null $unprocessing
 * @property string|null $bud_traget
 * @property int|null $bud_success
 * @property int|null $bud_proceesing
 * @property int|null $bud_unprocessing
 *
 * @property KtBudyear $budyear
 * @property KtMain $main
 * @property KtMonth $month
 * @property KtSubmain $submain
 * @property Year $year
 */
class KtResulte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kt_resulte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner', 'main_id', 'submain_id', 'budyear_id', 'month_id', 'year', 'reslute', 'success', 'processing', 'unprocessing', 'bud_success', 'bud_proceesing', 'bud_unprocessing'], 'integer'],
            [['target', 'bud_traget'], 'string'],
            [['budyear_id'], 'exist', 'skipOnError' => true, 'targetClass' => KtBudyear::class, 'targetAttribute' => ['budyear_id' => 'id']],
            [['month_id'], 'exist', 'skipOnError' => true, 'targetClass' => KtMonth::class, 'targetAttribute' => ['month_id' => 'id']],
            [['main_id'], 'exist', 'skipOnError' => true, 'targetClass' => KtMain::class, 'targetAttribute' => ['main_id' => 'id']],
            [['submain_id'], 'exist', 'skipOnError' => true, 'targetClass' => KtSubmain::class, 'targetAttribute' => ['submain_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ลำดับ',
            'owner' => 'ผู้รับผิดชอบ',
            'main_id' => 'กองทุนหลัก',
            'submain_id' => 'กองทุนรอง',
            'budyear_id' => 'ปีงบประมาณ',
            'month_id' => 'เดือน',
            'year' => 'ปี',
            'target' => 'เป้าหมาย',
            'success' => 'ผลสำเร็จ',
            'processing' => 'กำลังดำเนินการ',
            'unprocessing' => 'ยังไม่ได้ดำเนินการ',
            'bud_traget' => 'เป้าหมายปีงบ',
            'bud_success' => 'ผลสำเร็จปีงบ',
            'bud_proceesing' => 'กำลังดำเนินการปีงบ',
            'bud_unprocessing' => 'ยังไม่ได้ดำเนินการปีงบ',
        ];
    }

    /**
     * Gets query for [[Budyear]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudyear()
    {
        return $this->hasOne(KtBudyear::class, ['id' => 'budyear_id']);
    }
    /**
     * Gets query for [[Main]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMain()
    {
        return $this->hasOne(KtMain::class, ['id' => 'main_id']);
    }
    /**
     * Gets query for [[Month]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMonth()
    {
        return $this->hasOne(KtMonth::class, ['id' => 'month_id']);
    }
    /**
     * Gets query for [[Submain]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubmain()
    {
        return $this->hasOne(KtSubmain::class, ['id' => 'submain_id']);
    }

    public function getDetailYear()
    {
        return $this->hasOne(KtYear::class, ['id' => 'year']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class , ['id' => 'owner']);
    }
}
