<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KpChild;

/**
 * KpChildSearch represents the model behind the search form of `app\models\KpChild`.
 */
class KpChildSearch extends KpChild
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['child_id', 'kpi_id', 'strategic', 'issue', 'goal', 'goal2', 'project', 'team', 'manager', 'budyear', 'weight', 'plan'], 'integer'],
            [['name'], 'safe'],
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
        $query = KpChild::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'kpi_id' => $this->kpi_id,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
    public function searchFromKpi($kpi_id){ 
        $query = KpChild::find() ;
        $dataProvider = new ActiveDataProvider([
            'query' => $query , 
        ]);
         $query->andFilterWhere(['kpi_id' => $kpi_id]);
         return $dataProvider ; 

    }
}
