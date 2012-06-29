<?php

class CmdrunModule extends CWebModule
{
    /**
     * @var CConsoleCommandRunner 
     */
    public $runner;
    
    /**
     * @var array console application config
     */
    public $config;

    public function init()
	{
        // This module is for debug only
        if (!YII_DEBUG)
            throw new CHttpException(403);
        
		// import the module-level models and components
		$this->setImport(array(
			'cmdrun.models.*',
			'cmdrun.components.*',
		));
        
        $this->config = include Yii::getPathOfAlias('application.config.console') . '.php';
        
        $this->_initRunner();
	}

    private function _initRunner()
    {
        $this->runner = new CConsoleCommandRunner();
        
        // Adding commandMap
        if ( isset($this->config['commandMap']) )
            $this->runner->commands = $this->config['commandMap'];
        
        // Adding commands path
        if ( isset($this->config['commandPath']) )
            $path = $this->config['commandPath'];
        else
            $path = 'protected/commands';
        
        $this->runner->addCommands( $path );
    }

    public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
