<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KpKpi;

/**
 * KpKpiSearch represents the model behind the search form of `app\models\KpKpi`.
 */
class KpKpiSearch extends KpKpi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id', 'stratetgic', 'issues', 'goal', 'goal2', 'project', 'team', 'manager', 'budyear', 'type_kpi', 'level_kpi', 'weight', 'plan'], 'integer'],
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
        $query = KpKpi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'kpi_id' => $this->kpi_id,
            'stratetgic' => $this->stratetgic,
            'issues' => $this->issues,
            'goal' => $this->goal,
            'goal2' => $this->goal2,
            'project' => $this->project,
            'team' => $this->team,
            'manager' => $this->manager,
            'budyear' => $this->budyear,
            'type_kpi' => $this->type_kpi,
            'level_kpi' => $this->level_kpi,
            'weight' => $this->weight,
            'plan' => $this->plan,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function searchYearType($params){ 
        $year = empty($params['KpKpiSearch']['budyear']) ? 0 : $params['KpKpiSearch']['budyear'] ; 
        $level = empty($params['KpKpiSearch']['level_kpi']) ? 0 : $params['KpKpiSearch']['level_kpi'] ;
        $query = KpKpi::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere([
            'budyear' => $year,
            'type_kpi' => $level,
        ]) ; 
        return $dataProvider;
    }
}
