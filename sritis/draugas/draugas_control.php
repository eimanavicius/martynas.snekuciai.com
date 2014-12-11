<?php

require_once 'system/base.php';

/**
 *
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class draugas_control extends system_base {

	protected function merginosAction() {
		$first_message = "Labas.";
        $this->getView()->assign('title', 'Pokalbiai su merginomis');
		$this->draugas_pokalbiai('merginos', $first_message);
	}

	protected function vaikinaiAction() {
        $this->getView()->assign('title', 'Pokalbiai su vaikinais');
		$first_message = "Mielai atrodai. Gal susipazinkim?";
		$this->draugas_pokalbiai('vaikinai', $first_message);
	}

	protected function draugas_pokalbiai($lytis, $first_message) {
		/* @var $model draugas_class */
		$model = $this->loadModel();
		$chats = $model->doPaginate(true)
			->setLimit(10)
			->setPage($this->getQuery('page', 1))
			->getGroupedChats($model->getChats($lytis));
		$pagination = $model->getPaginationVars();
		$pagination['route'] = array(
				$this->getAction(),
				$this->getName()
		);
		$this->getView()->assign(compact('chats', 'pagination', 'first_message'));
		$this->setAction('draugas_pokalbiai');
	}
}
