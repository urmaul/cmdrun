<?php

/**
 * @property CmdrunModule $module 
 * 
 * @property-read CConsoleCommandRunner $runner
 */
class DefaultController extends Controller
{
    
    public function actionIndex()
    {
        $this->showCommands();
    }


    public function actionRun($name)
    {
        $this->showCommands();
        
        $attrs = @$_SERVER['QUERY_STRING'];
        
        echo
            '<style>' .
                'pre {background: #eee; padding: 4px;}' .
            '</style>' .
            '<h2>How to call</h2>' .
            '<pre>' .
                Yii::getPathOfAlias('application.yiic') . ' ' . $name . (empty($attrs) ? '' : ' ' . $attrs) .
            '</pre>' .
            '<h2>Output</h2>' .
            '<pre>';
        
        $params = array_merge(array('', $name), explode(' ', $attrs));
        
        $this->runner->run($params);
        
        echo
            '</pre>';
    }
    
    
    public function showCommands()
    {
        $links = array();
        foreach ($this->runner->commands as $name => $file) {
            $links[] = CHtml::link($name, $this->createUrl('run', array('name' => $name)));
        }
        echo '<p>Commands: ' . implode(', ', $links) . '</p>';
    }
    
    /**
     * @return CConsoleCommandRunner 
     */
    public function getRunner()
    {
        return $this->module->runner;
    }
}