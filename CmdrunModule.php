<?php

/**
 * @property-read array $config console application config
 */
class CmdrunModule extends CWebModule
{
    /**
     * Run module only if Yii application running in DEBUG MODE.
     * Defaults to true.
     * @var boolean
     */
    public $onlyInDebug = true;
    
    /**
     * Console application config path alias.
     * Defaults to "application.config.console".
     * @var string 
     */
    public $configPathAlias = 'application.config.console';

    
    /**
     * @var CConsoleCommandRunner 
     */
    public $runner;
    
    /**
     * Console application config.
     * Use property "config" instead
     * @var array
     */
    private $_config;

    public function init()
    {
        // This module is for debug only
        if ( $this->onlyInDebug && !YII_DEBUG )
            throw new CHttpException(403);
        
		// import the module-level models and components
        $this->setImport(array(
            'cmdrun.models.*',
            'cmdrun.components.*',
        ));
        
        $this->_config = $this->_readConfig();
        
        $this->_initRunner();
    }
    
    /**
     * Reads console application config and adds default values
     * @return array console application config
     */
    private function _readConfig()
    {
        $config = include Yii::getPathOfAlias($this->configPathAlias) . '.php';
        
        // Setting dafaults
        $config += array(
            'commandMap' => array(),
            'commandPath' => 'protected/commands',
        );
        
        return $config;
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
    
    
    /* Getters */
    
    /**
     * @return array console application config
     */
    public function getConfig()
    {
        return $this->_config;
    }
    
}
