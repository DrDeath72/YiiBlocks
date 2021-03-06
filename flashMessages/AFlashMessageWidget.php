<?php
/**
 * A simple widget for displaying flash messages
 * @author Charles Pick
 * @package packages.flashMessages
 */
class AFlashMessageWidget extends CWidget {
	/**
	 * Holds a list of message types supported by this widget
	 * @see getMessageTypes()
	 * @see setMessageTypes()
	 * @var array
	 */
	protected $_messageTypes;
	/**
	 * The html options for the container
	 * @var array
	 */
	public $htmlOptions = array();

	/**
	 * The name of the tag used for the container.
	 * Defaults to div.
	 * If this is set to false the message will be displayed directly.
	 * @var string
	 */
	public $tagName = "div";

	/**
	 * Displays the flash message(s) if any.
	 */
	public function run() {
		$messages = array();

		foreach($this->getMessageTypes() as $type => $details) {
			$message = Yii::app()->user->getFlash($type);
			if ($message) {
				if (is_array($message)) {
					$viewFile = array_shift($message);
					$message = Yii::app()->controller->renderPartial($viewFile,$message,true);
				}
				$timeout = false;
				if (isset($details['timeout'])) {
					$timeout = $details['timeout'];
					unset($details['timeout']);
				}
				$options = array_merge($this->htmlOptions,$details);
				if (!isset($options['id'])) {
					$options['id'] = $this->id."_".$type;
				}
				$messages[] = CHtml::tag($this->tagName,$options,$message);
				if ($timeout) {
					$script = "jQuery(\"#".$options['id']."\").fadeOut(".$timeout." * 1000);";
					Yii::app()->clientScript->registerScript($options['id'],$script,CClientScript::POS_READY);
				}
			}
		}
		if (count($messages)) {
			echo implode("\n",$messages);
		}
	}
	/**
	 * Gets a list of message types that can be handled by this widget
	 * @return array an array of message types => configuration
	 */
	public function getMessageTypes() {
		if ($this->_messageTypes === null) {
			$this->_messageTypes = array(
					"info" => array(
								"class" => "info box",
								"timeout" => 30,
								),
					"warning" => array(
								"class" => "warning box",
								"timeout" => 30
								),
					"error" => array(
								"class" => "error box",
								"timeout" => false,
								),
					"success" => array(
								"class" => "success box",
								"timeout" => false,
								),
				);
		}
		return $this->_messageTypes;
	}
	/**
	 * Sets the message types that can be handled by this widget and their configuration
	 * @param array $value The message type (key) and the message configuration (value)
	 */
	public function setMessageTypes($value) {
		return $this->_messageTypes = $value;
	}
}