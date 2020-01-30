<?php
/**
 * Created by PhpStorm.
 * User: Marquinho
 * Date: 27/01/2020
 * Time: 14:20
 */

namespace StreamWamp\Types;


use Cake\Http\Exception\InternalErrorException;

class StreamTransportConfig
{
    /**
     * @var string
     */
    private $user;
    /**
     * @var string
     */
    private $secret;
    /**
     * @var string
     */
    private $realm;
    /**
     * @var string
     */
    private $url;

    public function __construct(
        string $user,
        string $secret,
        string $realm,
        string $url
    )
    {
        $this->user = $user;
        $this->secret = $secret;
        $this->realm = $realm;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getRealm(): string
    {
        return $this->realm;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    public static function fromArray(array $arrayConfig): self
    {
        $possibleConfigs = ['user', 'secret', 'realm', 'uri'];

        if (!empty(array_diff($possibleConfigs, array_keys($arrayConfig)))) {
            throw new InternalErrorException(
                'StreamWamp config need this keyed values: '.implode(', ', $possibleConfigs)
            );
        }

        return new self(
            $arrayConfig['user'],
            $arrayConfig['secret'],
            $arrayConfig['realm'],
            $arrayConfig['uri']
        );
    }
}