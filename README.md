# Cmdrun

Yii module to run non-interactive yiic commands using http requests.

It is useful when you need to debug your console scripts with [yiidebugtb](http://cr0t.github.com/yiidebugtb/).

## How to install

Place it into 'protected/modules/cmdrun' and attach 'cmdrun' to modules list in 'config/main.php'.

## How to use

You need to call urls like this:

``
/cmdrun/default/run/name/[command name]?[arguments]
``
