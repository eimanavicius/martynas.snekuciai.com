<?php

require_once 'system/model.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class info_class extends system_model {
	/**
	 * 
	 */
	public function getDarbai() {
		$result = array(
			array(
				'img' => 'img/darbai/vasara/naujienos.jpg',
				'title' => 'Naujienų atvaizdavimas',
				'desc' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',
			),
			array(
				'img' => 'img/darbai/vasara/puslapiavimas.jpg',
				'title' => 'Betkokio turinio puslapiavimas',
				'desc' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',
			),
			array(
				'img' => 'img/darbai/vasara/admin_sarasas.jpg',
				'title' => 'Naujienų administravimas',
				'desc' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',
			),
			array(
				'img' => 'img/darbai/vasara/admin_forma.jpg',
				'title' => 'Naujienų kūrimo ir redagavimo forma su "autocomplete"',
				'desc' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',
			),
			array(
				'img' => 'img/darbai/vasara/draugas.jpg',
				'title' => 'Draugiško boto pokalbių išklotinė',
				'desc' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',
			),
			array(
				'img' => 'img/darbai/vasara/cv.jpg',
				'title' => 'CV aprašas',
				'desc' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',
			),
			array(
				'img' => 'img/darbai/vasara/programa_v1.jpg',
				'title' => 'Programa naujienoms rašyti',
				'desc' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',
			),
		);
		return $result;
	}
}
