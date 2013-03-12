<?php

  use Simplon\Border\Request;

  require __DIR__ . '/../vendor/autoload.php';

  $request = Request::getInstance();

  $testing = [
    'Request method'  => $request->getMethod(),
    'is JSON-RPC?'    => $request->isJsonRpc(),
    'JSON-RPC id'     => $request->getJsonRpcId(),
    'JSON-RPC method' => $request->getJsonRpcMethod(),
    'JSON-RPC params' => $request->getJsonRpcParams(),
    'URI'             => $request->getUri(),
    'HTTP ACCEPT'     => $request->getHttpAccept(),
  ];

if(Request::getInstance()->isJsonRpc())
{
  // print request id
  echo Request::getInstance()->getJsonRpcId();

  // print method
  echo Request::getInstance()->getJsonRpcMethod();

  // print params | array
  var_dump(Request::getInstance()->getJsonRpcParams());
}

  echo '<h1>Just a couple of print outs from the Request Object</h1>';

  echo '<table border="1" style="font-size:18px">';

  foreach($testing as $label => $test)
  {
    echo '
    <tr>
      <td style="width:150px;text-align:right;font-weight:bold;background:#eee;padding:5px 10px">' . $label . '</td>
      <td style="padding:5px 10px">' . var_export($test, TRUE) . '</td>
    </tr>
    ';
  }

  echo '</table>';