<?php

/**
 * This is the model class for table "Case".
 *
 * The followings are the available columns in table 'Case':
 * @property integer $CaseId
 * @property string $MobileId
 * @property string $PasswordHash
 * @property string $TS
 * @property string $Identificator
 */
class MCase extends CActiveRecord
{
	
	public $Password;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Case';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Identificator', 'required'),
			array('MobileId, PasswordHash, Identificator', 'length', 'max'=>45),
			array('TS', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CaseId, MobileId, PasswordHash, TS, Identificator', 'safe', 'on'=>'search'),
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
			'caseTags' => array(self::HAS_MANY, 'CaseTag', 'CaseId'),
			'responses' => array(self::HAS_MANY, 'Response', 'CaseId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CaseId' => 'Case',
			'MobileId' => 'Mobile',
			'PasswordHash' => 'Password Hash',
			'TS' => 'Ts',
			'Identificator' => 'Identificator',
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

		$criteria->compare('CaseId',$this->CaseId);

		$criteria->compare('MobileId',$this->MobileId,true);

		$criteria->compare('PasswordHash',$this->PasswordHash,true);

		$criteria->compare('TS',$this->TS,true);

		$criteria->compare('Identificator',$this->Identificator,true);

		return new CActiveDataProvider('Case', array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Case the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		if (!empty($this->Password)) {
			$this->PasswordHash = self::hashPassword($this->Password);
		}
		return parent::beforeSave();
	}
	
	public static function hashPassword($password)
	{
		return crypt($password, self::generateSalt());
	}
	
	public static function generateSalt(){
		$staticsalt = 'rompe_tu_silencio_hashtag_2014';
		$random = md5(uniqid(mt_rand(), true));
		$salt = hash('sha512',$random.microtime().$staticsalt);
		return '$2a$12$'.$salt;
	}
	
	public static function generateUniqueIdentificator() {
		$length = 5;
		$rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36
		$rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36

		do {
			$base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number
			$newRand = base_convert($base10Rand, 10, 36); //convert it
			$c = MCase::model()->findByAttributes(array(
				"Identificator" => $newRand,
			));
		} while (isset($c));
		
		return $newRand;
	}
	
	public function validatePassword($password)
	{
		return crypt($password,$this->PasswordHash)===$this->PasswordHash;
	}
	
}