<?php

  namespace Simplon\Border;

  class Response
  {
    public function __construct()
    {
      $this
        ->getHeadersInstance()
        ->reset();
    }

    // ##########################################

    /**
     * @return Headers
     */
    protected function getHeadersInstance()
    {
      return Headers::getInstance();
    }

    // ##########################################

    /**
     * @return bool
     */
    protected function releaseResponseHeaders()
    {
      $this
        ->getHeadersInstance()
        ->release();

      return TRUE;
    }

    // ##########################################

    /**
     * @param $subtype
     * @param $encoding
     */
    protected function sendTextSubtype($subtype, $encoding)
    {
      // set content header
      $this
        ->getHeadersInstance()
        ->setContentType('text/' . $subtype . '; charset=' . strtolower($encoding));
    }

    // ##########################################

    /**
     * @param $code
     * @return Response
     */
    public function setStatusCode($code)
    {
      $this
        ->getHeadersInstance()
        ->setStatusCode($code);

      return $this;
    }

    // ##########################################

    /**
     * @param $data
     * @param string $encoding
     */
    public function sendText($data, $encoding = 'utf-8')
    {
      // set content header
      $this->sendTextSubtype('plain', $encoding);

      // release headers
      $this->releaseResponseHeaders();

      // send body
      echo $data;
    }

    // ##########################################

    /**
     * @param $data
     * @param string $encoding
     */
    public function sendHtml($data, $encoding = 'utf-8')
    {
      // set content header
      $this->sendTextSubtype('html', $encoding);

      // release headers
      $this->releaseResponseHeaders();

      // send body
      echo $data;
    }

    // ##########################################

    /**
     * @param $data
     * @return bool
     */
    public function sendJson($data)
    {
      // enforce array
      if(! is_array($data))
      {
        $data = [$data];
      }

      // set content header
      $this
        ->getHeadersInstance()
        ->setContentType('application/json');

      // release headers
      $this->releaseResponseHeaders();

      // send body
      echo json_encode($data);
    }

    // ##########################################

    /**
     * @param $type
     * @param $data
     * @param $id
     * @return bool
     */
    public function sendJsonRpc($type, $data, $id = NULL)
    {
      // set basic structure
      $jsonRpc = [
        'jsonrpc' => '2.0',
        $type     => $data,
      ];

      // set id if existing
      if($id)
      {
        $jsonRpc['id'] = (int)$id;
      }

      // and now sendJson
      return $this->sendJson($jsonRpc);
    }

    // ##########################################

    /**
     * @param $filePath
     * @param null $mimeType
     */
    public function sendFile($filePath, $mimeType = NULL)
    {
      // set headers
      $this
        ->getHeadersInstance()
        ->setFileData($filePath, $mimeType);

      // release headers
      $this->releaseResponseHeaders();

      // send body
      readfile($filePath);
    }

    // ##########################################

    /**
     * @param $url
     * @return bool
     */
    public function redirect($url)
    {
      // set headers
      $this
        ->getHeadersInstance()
        ->setRedirect($url);

      // release headers
      return $this->releaseResponseHeaders();
    }

    // ##########################################

    /**
     * @param $code
     * @return bool
     */
    public function sendStatusCode($code)
    {
      // set headers
      $this
        ->getHeadersInstance()
        ->setStatusCode($code);

      // release headers
      return $this->releaseResponseHeaders();
    }

    // ##########################################

    /**
     * @return bool
     */
    public function returnToReferer()
    {
      $referer = Request::getInstance()
        ->getHttpReferer();

      // we dont have any
      if(! $referer)
      {
        return FALSE;
      }

      // set headers
      $this
        ->getHeadersInstance()
        ->setRedirect($referer);

      // release headers
      return $this->releaseResponseHeaders();
    }

    // ##########################################

    /**
     * @param null $message
     */
    public function sendChunk($message = NULL)
    {
      // not implemented yet

      $this
        ->getHeadersInstance()
        ->setTransferEncoding('chunked');
    }
  }