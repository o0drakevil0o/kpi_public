<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hr_team".
 *
 * @property int $HR_TEAM_ID
 * @property string|null $HR_TEAM_NAME
 * @property string|null $HR_TEAM_DETAIL
 * @property string|null $LINE_TOKEN_SET
 * @property string|null $ACTIVE
 */
class HrTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hr_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HR_TEAM_NAME'], 'string', 'max' => 100],
            [['HR_TEAM_DETAIL'], 'string', 'max' => 255],
            [['LINE_TOKEN_SET'], 'string', 'max' => 200],
            [['ACTIVE'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'HR_TEAM_ID' => 'Hr Team ID',
            'HR_TEAM_NAME' => 'Hr Team Name',
            'HR_TEAM_DETAIL' => 'Hr Team Detail',
            'LINE_TOKEN_SET' => 'Line Token Set',
            'ACTIVE' => 'Active',
        ];
    }
}
