<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Case".
 *
 * @property integer $id
 * @property string $lastName
 * @property string $startDate
 * @property string $dueDate
 * @property integer $urgent
 * @property integer $billingClientId
 * @property integer $ultimateClientId
 * @property integer $assignToId
 * @property integer $status
 * @property string $createdAt
 * @property integer $createdById
 * @property string $updatedAt
 * @property integer $updatedById
 */
class Cases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Case';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastName', 'startDate', 'dueDate', 'urgent', 'billingClientId', 'ultimateClientId', 'assignToId', 'status', 'createdAt', 'createdById', 'updatedAt', 'updatedById'], 'required'],
            [['startDate', 'dueDate', 'createdAt', 'updatedAt'], 'safe'],
            [['urgent', 'billingClientId', 'ultimateClientId', 'assignToId', 'status', 'createdById', 'updatedById'], 'integer'],
            [['lastName'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lastName' => 'Last Name',
            'startDate' => 'Start Date',
            'dueDate' => 'Due Date',
            'urgent' => 'Urgent',
            'billingClientId' => 'Billing Client ID',
            'ultimateClientId' => 'Ultimate Client ID',
            'assignToId' => 'Assign To ID',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'createdById' => 'Created By ID',
            'updatedAt' => 'Updated At',
            'updatedById' => 'Updated By ID',
        ];
    }
}
