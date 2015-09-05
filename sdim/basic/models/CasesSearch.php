<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cases;

/**
 * CasesSearch represents the model behind the search form about `app\models\Cases`.
 */
class CasesSearch extends Cases
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'urgent', 'billingClientId', 'ultimatrClientId', 'assignToId', 'status', 'createdById', 'updatedById'], 'integer'],
            [['lastName', 'startDate', 'dueDate', 'createdAt', 'updatedAt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Cases::find();

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
            'id' => $this->id,
            'startDate' => $this->startDate,
            'dueDate' => $this->dueDate,
            'urgent' => $this->urgent,
            'billingClientId' => $this->billingClientId,
            'ultimatrClientId' => $this->ultimatrClientId,
            'assignToId' => $this->assignToId,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'createdById' => $this->createdById,
            'updatedAt' => $this->updatedAt,
            'updatedById' => $this->updatedById,
        ]);

        $query->andFilterWhere(['like', 'lastName', $this->lastName]);

        return $dataProvider;
    }
}
