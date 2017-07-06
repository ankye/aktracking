<?php

/**
 * @package yii2-buttons
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.3
 */

namespace pavlinter\buttons;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class InputButton
 */
class InputButton extends Widget
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
     * @var array additional options for JS plugin
     */
    public $clientOptions = [];
    /**
     * @var string|array id or HTML attributes for the input tag
     */
    public $input;
    /**
     * @var string name for [[input]]
     */
    public $name;
    /**
     * @var string value for [[input]]
     */
    public $value;
    /**
     * jquery selector where append input
     * @var string|object [[yii\widgets\ActiveForm]]
     */
    public $formSelector;
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

        $this->mustBeSet('input');
        $this->mustBeSet('name');
        $this->mustBeSet('formSelector');

        if ($this->formSelector instanceof ActiveForm) {
            $this->formSelector = "#" . $this->formSelector->getId(false);
        }

        if (!is_array($this->input)) {
            $this->input = [
                'id' => $this->input,
            ];
        }

        if (!isset($this->input['type'])) {
            $this->input['type'] = 'hidden';
        }

        $view = $this->getView();
        $this->registerScript($view);

        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;
        echo Html::tag($this->tagName, $label, $this->options);
    }

    /**
     * @param $view
     */
    protected function registerScript($view)
    {
        AssetInputButton::register($view);

        $this->clientOptions['inputValue'] = $this->value;
        $this->clientOptions['inputTemplate'] = Html::input($this->input['type'], $this->name, null, $this->input);
        $this->clientOptions['inputId'] = $this->input['id'];
        $this->clientOptions['formSelector'] = $this->formSelector;

        $view->registerJs('jQuery("#' . $this->id . '").inputButton(' . Json::encode($this->clientOptions) . ');');
    }

    /**
     * @param $name
     * @throws InvalidConfigException
     */
    protected function mustBeSet($name)
    {
        if ($this->$name === null) {
            throw new InvalidConfigException('The "' . $name . '" property must be set.');
        }
    }
}
