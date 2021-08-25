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

	public function datarest(){

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {     //Mostrar en formato json
          //
          // Creamos la variable $connection que contiene la conexión a la base de datos de Drupal.
          $connection = \Drupal::database();

          $database = \Drupal::database();
          $query = $database->query("SELECT * FROM {example_users}");
          $result = $query->fetchAll();
          $sql = $result;
          header("HTTP/1.1 200 OK");
          echo json_encode($sql);
          exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
          //envio post
          $input = $_POST;
          if ($input) {
            // code...
            switch ($input['cargo']) {
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
                                'nombre' => $input[nombre],
                                'identificacion' => $input[identificacion],
                                'fechanacimiento' => $input[fechanacimiento],
                                'cargo' => $input[cargo],
                                'estado' => $estado,
              ))->execute();

            header("HTTP/1.1 200 OK");
            exit();
          }else{

            echo json_encode(array(
                    'status' => '1',
                    'msg' => 'Debe especificar una opcion valida.'
            ));
            header("HTTP/1.1 400 Bad Request");
            exit();

          }

    }
	}

  public function datarestdelete($id){

      $table = 'example_users';

      $num_deleted = \Drupal::database()->delete($table)
        ->condition('id', $id)
        ->execute();

      if($num_deleted == 1){

        echo json_encode(array(
                'status' => '1',
                'msg' => 'Dato eliminado.'
        ));
        header("HTTP/1.1 200 OK");
        exit();
      }else{
        echo json_encode(array(
                'status' => '1',
                'msg' => 'Debe especificar una opcion valida para borrar.'
        ));
        header("HTTP/1.1 400 Bad Request");
        exit();
      }


  }

  public function datarestupdate($id){

    $table = 'example_users';

    $input = $_GET;

    if($id){

      switch ($input['cargo']) {
         case '1':
              $estado = 1;
           break;

         default:
              $estado = 0;
           break;
       }

      if ($input) {

        $num_updated = \Drupal::database()->update($table)
          ->fields([
            'nombre' => $input[nombre],
            'identificacion' => $input[identificacion],
            'fechanacimiento' => $input[fechanacimiento],
            'cargo' => $input[cargo],
            'estado' => $estado,
          ])
          ->condition('id', $id)
          ->execute();
      }

      if($num_deleted == 1 or !empty($input)){

        echo json_encode(array(
                'status' => '1',
                'msg' => 'Dato Actualizado.'
        ));
        header("HTTP/1.1 200 OK");
        exit();

      }else{
        echo json_encode(array(
                'status' => '1',
                'msg' => 'Debe especificar una opcion valida para actualizar.'
        ));
        header("HTTP/1.1 400 Bad Request");
        exit();
      }

    }else{
        echo json_encode(array(
                'status' => '1',
                'msg' => 'Debe especificar una opcion valida.'
        ));
        header("HTTP/1.1 400 Bad Request");
        exit();
      }



  }

}

?>