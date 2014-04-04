<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $Id
 * @property string $username
 * @property string $passwordhash
 * @property string $name
 * @property string $email
 */
class User extends CActiveRecord
{
	
	public $password;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username','unique'),
			array('username, name, email, telephone', 'required'),
			array('password', 'required', 'on' => 'create'),
			array('username, password, name, email', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('Id, username, passwordhash, name, email', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'Id',
			'username' => 'Username',
			'passwordhash' => 'Passwordhash',
			'name' => 'Name',
			'email' => 'Email',
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

		$criteria->compare('Id',$this->Id);

		$criteria->compare('username',$this->username,true);

		$criteria->compare('passwordhash',$this->passwordhash,true);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		if (!empty($this->password)) {
			$this->passwordhash = self::hashPassword($this->password);
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
	
	public function validatePassword($password)
	{
		return crypt($password,$this->passwordhash)===$this->passwordhash;
	}
}