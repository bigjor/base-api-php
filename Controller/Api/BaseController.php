<?php
class BaseController {
  protected static $okHeaders = array(
    'Content-Type: application/json',
    'HTTP/1.1 200 OK'
  );

  /**
   * __call magic method.
   */
  public function __call($name, $arguments) {
    $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
  }

  /**
   * Get request method.
   * @return string
   */
  public function getRequestMethod() {
    return strtoupper($_SERVER['REQUEST_METHOD']);
  }

  /**
   * Get URI elements.
   * @return array
   */
  protected function getUriSegments() {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );
    return $uri;
  }

  /**
   * Get query params.
   * @return array
   */
  protected function getQueryParams() {
    return parse_str($_SERVER['QUERY_STRING'], $query);
  }

  /**
   * Get body params.
   * @return object|array
   */
  protected function getBodyParams() {
    $body = file_get_contents('php://input');
    return json_decode($body);
  }

  /**
   * Get method POST params.
   * @return array
   */
  protected function getPostParams() {
    return $_POST;
  }

  /**
   * Get method GET params.
   * @return array
   */
  protected function getGetParams() {
    return $_GET;
  }

  /**
   * Get complete request
   */
  protected function getRequest() {
    return $_REQUEST;
  }

  /**
   * Send API output.
   * @param mixed  $data
   * @param string $httpHeader
   */
  protected function sendOutput($data, $httpHeaders=array()) {
    header_remove('Set-Cookie');

    if (is_object($httpHeaders)) {
      $httpHeaders = array($httpHeaders);
    }

    if (is_array($httpHeaders) && count($httpHeaders)) {
      foreach ($httpHeaders as $httpHeader) {
        header($httpHeader);
      }
    }

    if (is_array($data) || is_object($data)) {
      echo json_encode($data);
    } else {
      echo $data;
    }
    exit;
  }
}