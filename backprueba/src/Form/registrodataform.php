<?php

/**
 * @file
 * Contains \Drupal\backprueba\Form\registrodataform.
 */
namespace Drupal\backprueba\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class registrodataform extends FormBase {

	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		// Nombre del formulario
		return 'registrodata_form';
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {

		//$form['#attached']['library'][] = 'backprueba/backpruebalib';

		// Definimos los campos


		$form['nombre'] = [
			'#type'     => 'textfield',
			'#title'    => $this->t('Nombre'),
			'#required' => TRUE,
      '#prefix'   => '<div class="col-md-6">',
		];

    $form['identificacion'] = [
      '#type'     => 'textfield',
      '#title'    => $this->t('Identificación'),
      '#required' => TRUE,
      '#suffix' => '</div>',
    ];


    $form['fechanacimiento'] = [
      '#type' => 'date',
      '#title'    => $this->t('Fecha de Nacimiento'),
      '#description' => t('Por favor escoger fecha de nacimiento'),
      '#required' => TRUE,
      '#date_format' => 'Y-m-d',
      '#default_value' => date('Y-m-d'),
      '#prefix'   => '<div class="col-md-6">',
    ];

		$form['cargo'] = [
			'#title'    => $this->t('Cargo'),
			'#required' => TRUE,
      '#type' => 'select',
      '#options' => [
          '1' => $this->t('Administrador'),
          '2' => $this->t('Webmaster'),
          '3' => $this->t('Desarrollador'),
        ],
      '#suffix' => '</div>',
		];


		$form['submit'] = [
			'#type'  => 'submit',
			'#value' => $this->t('Guardar'),
      '#prefix'   => '<div class="col-md-12">',
      '#suffix' => '</div>',

		];
		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm(array&$form, FormStateInterface $form_state) {

		// validaciones necesarias

		if (empty($form_state->getValue('nombre'))) {
      $form_state->setErrorBynombre('nombre', $this->t('Es necesario introducir un Nombre'));
    }

		if (empty($form_state->getValue('identificacion'))) {
			$form_state->setErrorBynombre('identificacion', $this->t('Es necesario introducir una Identificacion'));
		}

    if (empty($form_state->getValue('cargo'))) {
          $form_state->setErrorBynombre('cargo', $this->t('Es necesario introducir un Cargo'));
    }

	}

	/**
	 * {@inheritdoc}
	 */

	public function submitForm(array&$form, FormStateInterface $form_state) {

	$values = array(
			'nombre' => $form_state->getValue('nombre'),
			'identificacion' => $form_state->getValue('identificacion'),
      'fechanacimiento' => $form_state->getValue('fechanacimiento'),
      'cargo' => $form_state->getValue('cargo'),
		);


   switch ($values['cargo']) {
      case '1':
           $estado = 1;
        break;

      default:
           $estado = 0;
        break;
    }


		$table = 'example_users';

		\Drupal::database()->insert($table)
		                   ->fields(array(
				'nombre' => $values['nombre'],
				'identificacion' => $values['identificacion'],
        'fechanacimiento' => $values['fechanacimiento'],
        'cargo' => $values['cargo'],
        'estado' => $estado,
			))
			->execute();

		drupal_set_message('Guardado Correctamente.', 'status');

		// Mostrar resultados al enviar el formulario en un mensaje de drupal
		//foreach ($form_state->getValues() as $key => $value) {
		//drupal_set_message($key.': '.$value);
		//}
	}

}
