<?php

class CaseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create','get','list','response'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('tag','assign','list_assigned','list_by_field'),
				'roles' => array ('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if ((empty($_POST['id_mobile']) && empty($_POST['password'])) || empty($_POST['text'])) {
			$this->_sendResponse(400,"bad request");
			return;
		} 
		
		$model=new MCase();
		$model->MobileId = @$_POST['id_mobile'];
		$model->Password = @$_POST['password'];
		$model->Identificator = MCase::generateUniqueIdentificator();
		$model->TS = new CDbExpression("NOW()");
		
		if ($model->validate()) {

			if($model->save()) {
				
				$resp = new Response();
				$resp->CaseId = $model->CaseId;
				$resp->Text = $_POST['text'];
				$resp->TS = new CDbExpression("NOW()");
				$resp->UserId = @Yii::app()->user->id;
				$resp->insert();
				
				print $model->Identificator;
				
				Yii::app()->end();
			} else {
				$this->_sendResponse(500, "Could not create the case");
			}
		} else {
			$this->_sendResponse(400,
					json_encode($model->errors));
		}
	}

}
