<?php
declare(strict_types=1);

namespace Paseto;

use Zend\Soap\Client;

class ATMAverba extends Base implements ATMAverbaInterface
{
    private $user;
    private $password;
    private $cod;
    private $xml;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return ATMAverba
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return ATMAverba
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCod()
    {
        return $this->cod;
    }

    /**
     * @param mixed $cod
     * @return ATMAverba
     */
    public function setCod($cod)
    {
        $this->cod = $cod;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param mixed $xml
     * @return ATMAverba
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
        return $this;
    }


    public function averbaCTe()
    {
        $std = new \stdClass();
        $std->method = 'averbaCTe';
        return $this->send($std);
    }

    /**
     * @param \stdClass $stdClass
     * @return bool
     */
    private function send(\stdClass $stdClass): bool
    {
        try {
            $client = new Client(WSDL, ["soap_version" => SOAP_1_1]);
            if (!is_file($this->getXml())) {
                $this->setErrors('Arquivo não encontrado.');
                return false;
            }
            $xml = file_get_contents($this->getXml());
            if ($this->isValidXml($xml) === false) {
                $this->setErrors('Arquivo XML inválido.');
                return false;
            }
            if (empty($this->getUser()) || empty($this->getPassword()) || empty($this->getCod())){
                $this->setErrors('Todos os parâmetros são obrigatórios.');
                return false;
            }

            $params = [
                'usuari' => $this->getUser(),
                'senha' => $this->getPassword(),
                'codatm' => $this->getCod(),
                'xmlCTe' => $xml,
            ];

            $client->call($stdClass->method, $params);
            $request = $client->getLastRequest();
            $response = $client->getLastResponse();

            $std = new \stdClass();
            $std->request = $request;
            $std->response = $response;
            $std->object = $this->readReturn('Response', $response);
            $this->setResponse($std);
            return true;
        } catch (\Exception $e) {
            $this->setErrors($e->getMessage());
            return false;
        }
    }

}
