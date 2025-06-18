<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KtResulte;

/**
 * KtResulteSearch represents the model behind the search form of `app\models\KtResulte`.
 */
class KtResulteSearch extends KtResulte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'owner', 'main_id', 'submain_id', 'budyear_id', 'month_id', 'year', 'success', 'processing', 'unprocessing', 'bud_success', 'bud_proceesing', 'bud_unprocessing'], 'integer'],
            [['target', 'bud_traget'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = KtResulte::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'owner' => $this->owner,
            'main_id' => $this->main_id,
            'submain_id' => $this->submain_id,
            'budyear_id' => $this->budyear_id,
            'month_id' => $this->month_id,
            'year' => $this->year,
            'success' => $this->success,
            'processing' => $this->processing,
            'unprocessing' => $this->unprocessing,
            'bud_success' => $this->bud_success,
            'bud_proceesing' => $this->bud_proceesing,
            'bud_unprocessing' => $this->bud_unprocessing,
        ]);

        $query->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'bud_traget', $this->bud_traget]);

        return $dataProvider;
    }
}
