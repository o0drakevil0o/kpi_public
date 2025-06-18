<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KpTemplete;

/**
 * KpTempleteSearch represents the model behind the search form of `app\models\KpTemplete`.
 */
class KpTempleteSearch extends KpTemplete
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kpi_id', 'child_id', 'sub_id', 'created_at', 'updated_at', 'support_people', 'send_type', 'plan'], 'integer'],
            [['tem_kpiname', 'tem_dic', 'tem_unit', 'unit_a', 'dic_a', 'unit_b', 'dic_b', 'unit_c', 'dic_c', 'unit_d', 'dic_d', 'cal', 'min_traget', 'people_target', 'process_data', 'description', 'condition'], 'safe'],
            [['weight'], 'number'],
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
        $query = KpTemplete::find();

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
            'kpi_id' => $this->kpi_id,
            'child_id' => $this->child_id,
            'sub_id' => $this->sub_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'support_people' => $this->support_people,
            'weight' => $this->weight,
            'send_type' => $this->send_type,
            'plan' => $this->plan,
        ]);

        $query->andFilterWhere(['like', 'tem_kpiname', $this->tem_kpiname])
            ->andFilterWhere(['like', 'tem_dic', $this->tem_dic])
            ->andFilterWhere(['like', 'tem_unit', $this->tem_unit])
            ->andFilterWhere(['like', 'unit_a', $this->unit_a])
            ->andFilterWhere(['like', 'dic_a', $this->dic_a])
            ->andFilterWhere(['like', 'unit_b', $this->unit_b])
            ->andFilterWhere(['like', 'dic_b', $this->dic_b])
            ->andFilterWhere(['like', 'unit_c', $this->unit_c])
            ->andFilterWhere(['like', 'dic_c', $this->dic_c])
            ->andFilterWhere(['like', 'unit_d', $this->unit_d])
            ->andFilterWhere(['like', 'dic_d', $this->dic_d])
            ->andFilterWhere(['like', 'cal', $this->cal])
            ->andFilterWhere(['like', 'min_traget', $this->min_traget])
            ->andFilterWhere(['like', 'people_target', $this->people_target])
            ->andFilterWhere(['like', 'process_data', $this->process_data])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'condition', $this->condition]);

        return $dataProvider;
    }


    public function searchTemplete($identifyKpi = []){ 
        $query = KpTemplete::find() ; 
        $dataProvider = new ActiveDataProvider([
            'query' => $query , 
        ]); 
        $query->andFilterWhere([
                'kpi_id' => $identifyKpi[0],
                'child_id' => $identifyKpi[1],
                'sub_id' => $identifyKpi[2],
        ]);

        return $dataProvider ; 
    }
}
