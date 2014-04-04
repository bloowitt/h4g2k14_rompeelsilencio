<?php

/**
 * This is the model class for table "Response".
 *
 * The followings are the available columns in table 'Response':
 * @property integer $ResponseId
 * @property integer $CaseId
 * @property integer $UserId
 * @property string $TS
 * @property string $Text
 */
class Response extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Response';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CaseId', 'required'),
			array('CaseId, UserId', 'numerical', 'integerOnly'=>true),
			array('TS, Text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ResponseId, CaseId, UserId, TS, Text', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'UserId'),
			'case' => array(self::BELONGS_TO, 'Case', 'CaseId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ResponseId' => 'Response',
			'CaseId' => 'Case',
			'UserId' => 'User',
			'TS' => 'Ts',
			'Text' => 'Text',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ResponseId',$this->ResponseId);

		$criteria->compare('CaseId',$this->CaseId);

		$criteria->compare('UserId',$this->UserId);

		$criteria->compare('TS',$this->TS,true);

		$criteria->compare('Text',$this->Text,true);

		return new CActiveDataProvider('Response', array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Response the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}