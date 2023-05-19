<?php
require_once 'BaseController.php';
require_once '../Factory/BookFactory.php';

class BookController extends BaseController {
    /**
     * "/book/list" Endpoint - Get list of users
     */
    public function listAction() {
      $data = null;
      $error = '';
      $params = $this->getQueryParams();

      try {
        switch ($this->getRequestMethod()) {
          case 'GET': 
            $data = BookFactory::findAll();
            break;

          default:
            $error = 'Method not supported';
            $errorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
      } catch (Exception|Error $e) {
        $error = $e->getMessage() . 'Something went wrong! Please contact support.';
        $errorHeader = 'HTTP/1.1 500 Internal Server Error';
      } finally {
        // IF ERROR
        if (!!$error) {
          $headers = array('Content-Type: application/json', $errorHeader);
          $this->sendOutput((object) array('error' => $error), $headers); 
        }

        // IF SUCCESS
        $headers = BookController::$okHeaders;
        $this->sendOutput($data, $headers);
      }
    }
}