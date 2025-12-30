<?php
namespace Fosa\Core;

/**
 * Class Tokenizer
 * This class is responsible for generating, decoding, refreshing, invalidating and checking the validity of tokens.
 * 
 * @package Fosa\Core
 */

require_once __DIR__ . '/Session.php';

class Tokenizer
{
    /**
     * @var Session
     */
    private $session_instance;

    /**
     * Tokenizer constructor.
     */

    public function __construct()
    {
        $this->session_instance = new Session();
    }

    /**
     * Generate new token for payload
     *
     * @param $payload
     * @return string
     */

    public function tokenize($payload)
    {
        $token = $this->createToken();
        $this->session_instance->set($token, array_merge($payload, [
            'ttl' => 3600,
            'born_at' => new \DateTime()
        ]));
        return $token;
    }

    /**
     * Decode token
     *
     * @param $token
     * @return array
     */

    public function decode($token)
    {
        if(!$token || !$this->session_instance->isset($token)) return null;
        return $this->session_instance->get($token);
    }

    /**
     * Refresh token
     *
     * @param $token
     * @return string
     */

    public function refresh($token)
    {
        if(self::isValid($token)) return $token;
        $this->session_instance->clear($token);
        $payload = self::decode($token);
        return self::tokenize($payload);
    }

    /**
     * Check if token is valid
     *
     * @param $token
     * @return bool
     */

    public function isValid($token)
    {
        if(!$token) return false;
        if(!$this->session_instance->isset($token)) return false;
        $payload = $this->session_instance->get($token);
        $lifetime = (new \DateTime())->diff($payload['born_at'], true);
        if($lifetime->i > ($payload['ttl']/60)) {
            return false;
        }
        return true;
    }

    /**
     * Create token string
     *
     * @return string
     */

    protected function createToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i < 30; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
        return $token;
    }

    /**
     * Invalidate token
     *
     * @param $token
     * @return bool
     */

    public function invalidate($token)
    {
        if(!$token) return false;
        if(!$this->session_instance->isset($token)) return false;
        return $this->session_instance->clear($token);
    }
}