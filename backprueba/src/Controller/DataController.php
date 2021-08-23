<?php

namespace Drupal\backprueba\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * class controller.
 */

class DataController extends ControllerBase {

	/**
	 * registro method.
	 */
	public function registro() {

		// Utilizamos el formulario
		$form = $this->formBuilder()->getForm('Drupal\backprueba\Form\registrodataform');

		// Le pasamos el formulario y demás a la vista (tema configurado en el module)
		return [
			'#theme'    => 'registro_data',
			'#attached' => array(
				'library'  => array(
					'backprueba/backpruebalib',
					'backprueba/jquery_validate',
                    'backprueba/bootstrap_cdn',
				),
			),
			'#titulo'      => $this->t('Registrar Usuario'),
			'#descripcion' => 'Por favor llena los siguientes datos',
			'#formulario'  => $form,
			'#markup'      => " ",
		];

	}


}

?>