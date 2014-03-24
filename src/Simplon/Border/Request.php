<?php

    namespace Simplon\Border;

    class Request
    {
        /** @var Request */
        private static $_instance;

        /** @var array */
        private $_data = [];

        // ######################################

        /**
         * @return Request
         */
        public static function getInstance()
        {
            if (!isset(Request::$_instance))
            {
                Request::$_instance = new Request();
            }

            return Request::$_instance;
        }

        // ######################################

        public function __construct()
        {
            $this->readData();
        }

        // ######################################

        /**
         * @return $this|bool
         */
        protected function readData()
        {
            $this->_data = $_SERVER;

            if ($this->isPostRequest())
            {
                // try to read json rpc
                $this->readJsonRpc();
            }

            $this->setParams($_REQUEST);

            return TRUE;
        }

        // ######################################

        /**
         * @return bool
         */
        protected function readJsonRpc()
        {
            $json = file_get_contents('php://input');
            $data = json_decode($json, TRUE);

            $params = isset($data['params']) ? $data['params'] : [];

            // json-rpc request
            if (isset($data['id']) && isset($data['method']))
            {
                $this
                    ->setByKey('isJsonRpc', TRUE)
                    ->setByKey('jsonRpcId', $data['id'])
                    ->setByKey('jsonRpcMethod', $data['method'])
                    ->setByKey('jsonRpcParams', $params);

                return TRUE;
            }

            // json-rpc notification
            elseif (isset($data['method']))
            {
                $this
                    ->setByKey('isJsonRpcNotification', TRUE)
                    ->setByKey('jsonRpcMethod', $data['method'])
                    ->setByKey('jsonRpcParams', $params);

                return TRUE;
            }

            $this->setByKey('isJsonRpc', FALSE);

            return FALSE;
        }

        // ######################################

        /**
         * @param $key
         * @param $val
         *
         * @return Request
         */
        protected function setByKey($key, $val)
        {
            $key = strtoupper($key);

            $this->_data[$key] = $val;

            return $this;
        }

        // ######################################

        /**
         * @param $key
         *
         * @return mixed
         */
        protected function getByKey($key)
        {
            $key = strtoupper($key);

            if (!isset($this->_data[$key]))
            {
                return FALSE;
            }

            return $this->_data[$key];
        }

        // ######################################

        /**
         * @return array
         */
        public function getData()
        {
            return $this->_data;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getServerIp()
        {
            return $this->getByKey('server_addr');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getServerPort()
        {
            return $this->getByKey('server_port');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getProtocol()
        {
            return $this->getByKey('server_protocol');
        }

        // ######################################

        /**
         * @return string
         */
        public function getMethod()
        {
            return strtolower($this->getByKey('request_method'));
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getTime()
        {
            return $this->getByKey('request_time');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getScriptName()
        {
            return $this->getByKey('script_name');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getUri()
        {
            return $this->getByKey('request_uri');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getQueryString()
        {
            return $this->getByKey('query_string');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpCacheControl()
        {
            return $this->getByKey('http_cache_control');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpAccept()
        {
            return $this->getByKey('http_accept');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpAcceptCharset()
        {
            return $this->getByKey('http_accept_charset');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpAcceptEncoding()
        {
            return $this->getByKey('http_accept_encoding');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpAcceptLanguage()
        {
            return $this->getByKey('http_accept_language');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpConnection()
        {
            return $this->getByKey('http_connection');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpHost()
        {
            return $this->getByKey('http_host');
        }

        // ######################################

        public function getHttpReferer()
        {
            return $this->getByKey('http_referer');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttpUserAgent()
        {
            return $this->getByKey('http_user_agent');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getHttps()
        {
            return $this->getByKey('https');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getRemoteIp()
        {
            return $this->getByKey('remote_addr');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getRemotePort()
        {
            return $this->getByKey('remote_port');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getRemoteUser()
        {
            return $this->getByKey('remote_user');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getPathInfo()
        {
            return $this->getByKey('path_info');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function isJsonRpc()
        {
            return $this->getByKey('isJsonRpc');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function isJsonRpcNotification()
        {
            return $this->getByKey('isJsonRpc');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getJsonRpcId()
        {
            return $this->getByKey('jsonRpcId');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getJsonRpcMethod()
        {
            return $this->getByKey('jsonRpcMethod');
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getJsonRpcParams()
        {
            return $this->getByKey('jsonRpcParams');
        }

        // ######################################

        /**
         * @param $params
         *
         * @return $this
         */
        public function setParams($params)
        {
            $this->setByKey('params', $params);

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getParams()
        {
            return $this->getByKey('params');
        }

        // ######################################

        /**
         * @return bool
         */
        public function isGetRequest()
        {
            return $this->getMethod() === 'get' ? TRUE : FALSE;
        }

        // ######################################

        /**
         * @return bool
         */
        public function isPostRequest()
        {
            return $this->getMethod() === 'post' ? TRUE : FALSE;
        }

        // ######################################

        /**
         * @param $key
         * @param null $value
         *
         * @return bool
         */
        public function hasParam($key, $value = NULL)
        {
            $params = $this->getParams();

            if (isset($params[$key]))
            {
                if ($value !== NULL)
                {
                    return (string)$params[$key] === (string)$value;
                }

                return TRUE;
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param $key
         *
         * @return bool|string
         */
        public function getParam($key)
        {
            $params = $this->getParams();

            if (isset($params[$key]))
            {
                return (string)$params[$key];
            }

            return FALSE;
        }
    }
