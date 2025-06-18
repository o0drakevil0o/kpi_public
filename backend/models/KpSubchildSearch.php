<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KpSubchild;

/**
 * KpSubchildSearch represents the model behind the search form of `app\models\KpSubchild`.
 */
class KpSubchildSearch extends KpSubchild
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subchild_id', 'kpi_id', 'child_id', 'strategic', 'issue', 'goal', 'goal2', 'project', 'team', 'manager', 'type_kpi', 'budyear', 'weight', 'plan'], 'integer'],
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
        $query = KpSubchild::find();

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
            'subchild_id' => $this->subchild_id,
            'kpi_id' => $this->kpi_id,
            'child_id' => $this->child_id,
            'strategic' => $this->strategic,
            'issue' => $this->issue,
            'goal' => $this->goal,
            'goal2' => $this->goal2,
            'project' => $this->project,
            'team' => $this->team,
            'manager' => $this->manager,
            'type_kpi' => $this->type_kpi,
            'budyear' => $this->budyear,
            'weight' => $this->weight,
            'plan' => $this->plan,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    public function searchSubchild($kpiId , $childId){ 
        $query = KpSubchild::find() ; 

        $dataProvider = new ActiveDataProvider([
            'query' => $query , 
        ]); 
        $query->andFilterWhere([
            'kpi_id' => $kpiId , 
            'child_id'=> $childId
        ]); 

        return $dataProvider ;
    }
}
