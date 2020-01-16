<?php
namespace kDevelop\ModuleBankApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class ModuleBankApi
 */
class General
{
    protected const BASE_URL = 'https://pay.modulbank.ru';

    /**
     * @var false|string
     */
    protected $secretKey = '';

    /**
     * @var string
     */
    protected $merchantId = '';

    /**
     * @var bool
     */
    protected $testMode = true;

    /**
     * @var Client
     */
    protected $client;

    /**
     * moduleBankApi constructor.
     * @param string $merchant
     * @param string $secret
     * @param bool $mode
     */
    public function __construct(string $merchant, string $secret, bool $mode)
    {
        $this->merchantId = $merchant;
        $this->testMode = $mode;
        $this->secretKey = $secret;

        $this->client = new Client([
            'base_uri' => self::BASE_URL
        ]);
    }

    /**
     * @param array $params
     * @param string $key
     * @return string
     */
    protected function getSignature(array $params, string $key = 'signature'): string
    {
        $keys = array_keys($params);
        sort($keys);
        $chunks = [];
        foreach ($keys as $k) {
            $v = (string) $params[$k];
            if (($v !== '') && ($k != $key)) {
                $chunks[] = $k . '=' . base64_encode($v);
            }
        }

        return $this->doubleSha1(implode('&', $chunks));
    }

    /**
     * @param string $params
     * @return string
     */
    protected function doubleSha1(string $params): string
    {
        $data = '';
        for ($i = 0; $i < 2; $i++) {
            $data = sha1($this->secretKey . $params);
        }
        return $data;
    }

    /**
     * @return array
     */
    protected function getSystemParams(): array
    {
        return [
            'merchant' => $this->merchantId,
            'testing' => $this->testMode,
            'unix_timestamp' => time()
        ];
    }

    /**
     * @param array $params
     * @return array
     */
    public function createPayment(array $params): array
    {
        $params = array_merge($params, $this->getSystemParams());
        $params['signature'] = $this->getSignature($params);

        var_dumP($params);

        $test = $this->client
            ->request('post', '/pay', $params)
            ->getBody()
            ->getContents();

        var_dumP($test);

        return [];

        return json_decode(
            $this->client
                ->post('/pay', $params)
                ->getBody()
                ->getContents(),
            true
        );
    }
}
