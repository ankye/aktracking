<?php

/**
 * @package yii2-buttons
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.3
 */

namespace pavlinter\buttons;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Class AjaxButton
 */
class AjaxButton extends Widget
{
    /**
     * @var string the id widget.
     */
    public $id;
    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];
    /**
     * @var string the tag to use to render the button
     */
    public $tagName = 'button';
    /**
     * @var string the button label
     */
    public $label = 'Button';
    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;
    /**
     * @var string the button label
     */
    public $template = '<span class="ab-loading ab-show-{id}">{spinner}</span><span class="ab-hide-{id}">{label}</span>';
    /**
     * @var array the HTML attributes for the spinner.
     * [
     *      'class' => 'ab-spinner-black', ab-spinner-red|ab-spinner-green|ab-spinner-blue|ab-spinner-white
     *      'width' => '15px',
     *      'height' => '15px',
     *      'content' => '',
     * ]
     */
    public $spinnerOptions = [
        'class' => 'ab-spinner-black',
    ];
    /**
     * @var string main spinner class.
     */
    public $spinnerClass = 'ab-spinner';
    /**
     * @var array options for ajax.
     */
    public $ajaxOptions = [];
    /**
     * @var string confirm message
     */
    public $confirmMessage;
    /**
     * Initializes the widget.
     */
    public function run()
    {
        parent::run();

        if (isset($this->options['id'])) {
            $this->id = $this->options['id'];
        } else {
            if ($this->id === null) {
                $this->id = $this->options['id'] = $this->getId();
            } else {
                $this->options['id'] = $this->id;
            }
        }

        if (!isset($this->options['class'])) {
            $this->options['class'] = 'btn btn-primary';
        }


        $view = $this->getView();
        AssetButton::register($view);

        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;

        $spinnerTag = ArrayHelper::remove($this->spinnerOptions, 'tag', 'div');
        $spinnerWidth = ArrayHelper::remove($this->spinnerOptions, 'width', '15px');
        $spinnerHeight = ArrayHelper::remove($this->spinnerOptions, 'height', '15px');
        $spinnerContent = ArrayHelper::remove($this->spinnerOptions, 'content');

        Html::addCssClass($this->spinnerOptions, $this->spinnerClass);
        Html::addCssStyle($this->spinnerOptions,[
            'width' => $spinnerWidth,
            'height' => $spinnerHeight,
        ]);

        $spinner   = Html::tag($spinnerTag, $spinnerContent, $this->spinnerOptions);

        echo Html::tag($this->tagName, strtr($this->template, [
            '{spinner}' => $spinner,
            '{label}' => $label,
            '{id}' => $this->id,
        ]) , $this->options);

        if (!empty($this->ajaxOptions)) {
            $this->registerScript($view);
        }
    }

    /**
     * @param $view
     */
    protected function registerScript($view)
    {

        $this->ajaxOptions = ArrayHelper::merge([
            'type' => null,
            'data' => null,
            'dataType' => 'json',
            'always' => 'function(jqXHR, textStatus){jQuery(".ab-show-" + abId).hide();jQuery(".ab-hide-" + abId).show();}',
        ], $this->ajaxOptions);
        $callbackScript = '';
        foreach (['done', 'always', 'fail', 'then'] as $name) {
            $f = ArrayHelper::remove($this->ajaxOptions, $name);
            if (!empty($f)) {
                if (!($f instanceof JsExpression)) {
                    $f = new JsExpression($f);
                }
                $callbackScript .= '.' . $name . '(' . $f . ')';
            }
        }

        foreach (['beforeSend'] as $name) {
            if (isset($this->ajaxOptions[$name])) {
                if (!($this->ajaxOptions[$name] instanceof JsExpression)) {
                    $this->ajaxOptions[$name] = new JsExpression($this->ajaxOptions[$name]);
                }
            }
        }

        if (!isset($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = Url::to(['']);
        } else if(is_array($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = Url::to($this->ajaxOptions['url']);
        }

        if ($this->ajaxOptions['type'] === null) {
            if ($this->ajaxOptions['data'] !== null) {
                $this->ajaxOptions['type'] = 'post';
            } else {
                $this->ajaxOptions['type'] = 'get';
            }
        }

        if (is_string($this->ajaxOptions['data'])) {
            if (!($this->ajaxOptions['data'] instanceof JsExpression)) {
                $this->ajaxOptions['data'] = new JsExpression($this->ajaxOptions['data']);
            }
        } else if($this->ajaxOptions['type'] === 'post' && $this->ajaxOptions['data'] === null) {
            $this->ajaxOptions['data'] = new JsExpression('$(this).closest("form").serialize()');
        } else if($this->ajaxOptions['type'] === 'post' && is_array($this->ajaxOptions['data'])) {
            $request = Yii::$app->getRequest();
            if ($request->enableCsrfValidation && !isset($this->ajaxOptions['data'][$request->csrfParam])) {
                $this->ajaxOptions['data'][$request->csrfParam] = $request->getCsrfToken();
            }
        }


        if($this->confirmMessage){
            $confirmStart = 'if(confirm("' . $this->confirmMessage . '")){';
            $confirmEnd = '}';
        } else {
            $confirmStart = '';
            $confirmEnd = '';
        }

        $view->registerJs('jQuery("#' . $this->id . '").on("click", function(){' . $confirmStart . 'var abId = "' . $this->id . '";jQuery(".ab-show-" + abId).show();jQuery(".ab-hide-" + abId).hide();jQuery.ajax(' . Json::encode($this->ajaxOptions) . ')' . $callbackScript . ';' . $confirmEnd . 'return false;});');
    }
}
