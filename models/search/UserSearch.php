<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{

    public $structure;
    public $university;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated', 'email', 'phio', 'last_login', 'password_reset_token', 'password_hash','number',/*'structure', 'university',*/'start_year'], 'safe'],
            [['author_id', 'user_id', 'role_id', 'status'], 'integer'],
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
    public function search($params,$customQuery = false)
    {
        if(!$customQuery){
            $query = User::find();
            /*$query->joinWith(['structure']);
            $query->joinWith(['university']);*/
        } else {
            $query = $customQuery;

        }

        /*$query->joinWith(['structure'=>function($query) {
            $query->joinWith(['university']);
        }]);*/

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        /*$dataProvider->sort->attributes['structure'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['structure.name' => SORT_ASC],
            'desc' => ['structure.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['university'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['university.name' => SORT_ASC],
            'desc' => ['university.name' => SORT_DESC],
        ];*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'created' => $this->created,
            'updated' => $this->updated,
            //'author_id' => $this->author_id,
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'last_login' => $this->last_login,
            'status' => $this->status,
            //'structure_id' => $this->structure_id,
            'start_year' => $this->start_year
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phio', $this->phio])
            ->andFilterWhere(['like', 'number', $this->number])
            /*->andFilterWhere(['like', 'university.name', $this->university])
            ->andFilterWhere(['like', 'structure.name', $this->structure])*/
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash]);

        return $dataProvider;
    }
}
