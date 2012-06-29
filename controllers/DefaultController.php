<?php

class DefaultController extends Controller
{
    /**
     * @var CConsoleCommandRunner 
     */
    protected $_runner;

    protected $_alias = 'application.commands';

    
    public function init()
    {
        parent::init();
        
        $this->_runner = new CConsoleCommandRunner();
    }

    public function beforeAction($action)
    {
        // This controller is for debug only
        if (!YII_DEBUG)
            throw new CHttpException(403);
        
        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        $this->showCommands();
    }


    public function actionRun($name, $attrs = array())
    {
        $this->showCommands();
        
        echo
            '<style>' .
                'pre {background: #eee; padding: 4px;}' .
            '</style>' .
            '<h2>How to call</h2>' .
            '<pre>' .
                Yii::getPathOfAlias('application.yiic') . ' ' . $name . (empty($attrs) ? '' : ' ' . implode(' ', $attrs)) .
            '</pre>' .
            '<h2>Output</h2>' .
            '<pre>';
        
        $this->_runner->run(array('', $name) + $attrs);
        
        echo
            '</pre>';
    }
    
    
    public function showCommands()
    {
        $this->_runner->addCommands( Yii::getPathOfAlias($this->_alias) );
        
        $links = array();
        foreach ($this->_runner->commands as $name => $file) {
            $links[] = CHtml::link($name, $this->createUrl('run', array('name' => $name)));
        }
        echo '<p>Commands: ' . implode(', ', $links) . '</p>';
    }
}