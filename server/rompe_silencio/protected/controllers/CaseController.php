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
		/*return array(
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
		);*/
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

	public function actionGet(){
		if (empty($_POST['id_mobile']) && empty($_POST['password'])){
			$this->_sendResponse(400,'bad request');
			return;
		}
		$case = MCase::model()->findByAttributes(array(
				"Identificator" => $_POST['id_case'],
			));
		if (!isset($case)){
			$this->_sendResponse(400,'bad request');
		}
		if (!empty($_POST['id_mobile']) && $case->MobileId !== $_POST['id_mobile']){
			$this->_sendResponse(403,"not authorized");
			return;
		}
		if (!empty($_POST['password']) && !$case->validatePassword($_POST['password'])){
			$this->_sendResponse(403,"not authorized");
			return;
		}
		$data = array();
		foreach ($case->responses as $response) {
			$data[] = array(
				"text" => $response->Text,
				"id_author" => $response->UserId,
				"timestamp" => $response->TS,
			);
		}
		print json_encode($data);

	}

	public function actionList(){
		if (empty($_POST['id_mobile'])){
			$this->_sendResponse(400,'bad request');
			return;
		}
		$cases = MCase::model()->findAllByAttributes(array (
			"MobileId" => $_POST['id_mobile'],
		));
		$data = array();
		foreach ($cases as $case) {
			$data[] = array(
				"id_case" => $case->Identificator,
				"summary" => @$case->responses[0]->Text,
				"timestamp" => @$user->responses[ count($user->responses) - 1]->TS,
			);
		}
		print json_encode($data);
	}

	public function actionResponse() {
		if (!isset(Yii::app()->user)) {
			if (empty($_POST['id_mobile']) && empty($_POST['password'])) {
				$this->_sendResponse(400,"bad request");
				return;
			}
		}
		$case = MCase::model()->findByAttributes(array(
			"Identificator" => $_POST['id_case'],
		));
		if (!isset($case)) {
			$this->_sendResponse(400,"bad request");
			return;
		}
		if (!empty($_POST['id_mobile']) && $case->MobileId !== $_POST['id_mobile']){
			$this->_sendResponse(403,"not authorized");
			return;
		}
		if (!empty($_POST['password']) && !$case->validatePassword($_POST['password'])){
			$this->_sendResponse(403,"not authorized");
			return;
		}

		$resp = new Response();
		$resp->CaseId = $case->CaseId;
		$resp->Text = $_POST['text'];
		$resp->TS = new CDbExpression("NOW()");
		$resp->UserId = Yii::app()->user->id;
		
		$resp->insert();
	}

	public function actionTag(){
		if (!isset(Yii::app()->user)) {
			$this->_sendResponse(403,"not authorized");
			return;
		}
		if (empty($_POST['id_case']) || empty($_POST['id_tag'])){
			$this->_sendResponse(400,'bad request');
			return;
		}
		$mCase = MCase::model()->findByAttributes(array(
			"Identificator" => $_POST['id_case'],
		));
		if (!isset($case)){
			$this->_sendResponse(400,'bad request');
			return;
		}
		if (empty($_POST['delete'])){
			$t = new CaseTag();
			$t->CaseId = $mCase->CaseId;
			$t->TagId = $_POST['id_tag'];
			$t->insert();
		}else{
			CaseTag::model()->deleteByAttributes(array(
				"CaseId" => $mCase->CaseId,
				"TagId" => $_POST['id_tag'],
			));
		}
		$data = array();
		print json_encode($data);
	}

	public function actionAssign(){
		if (!isset(Yii::app()->user)) {
			$this->_sendResponse(403,"not authorized");
			return;
		}
		$data = array();
		print json_encode($data);
	}

	public function actionList_assigned(){
		if (!isset(Yii::app()->user)) {
			$this->_sendResponse(403,"not authorized");
			return;
		}
		$data = array();
		print json_encode($data);
	}

	public function actionList_by_field(){
		if (!isset(Yii::app()->user)) {
			$this->_sendResponse(403,"not authorized");
			return;
		}
		$data = array();
		print json_encode($data);
	}
	

}
