<?php

declare(strict_types=1);

namespace BTCPayServer\Client;

use BTCPayServer\Http\CurlClient;
use BTCPayServer\Result\PaymentMethod;
use BTCPayServer\Util\PreciseNumber;

class Invoice extends AbstractClient
{

    public function createInvoice(string $storeId, PreciseNumber $amount, string $currency, ?string $orderId, ?string $customerEmail): \BTCPayServer\Result\Invoice
    {
        // TODO test & finish this
        // TODO add parameter for metadata and merge with orderId and buyerEmail
        $url = $this->getBaseUrl() . 'stores/' . urlencode($storeId) . '/invoices';
        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode([
            'amount' => $amount,
            'currency' => $currency,
            'metadata' => [
                'orderId' => $orderId,
                'buyerEmail' => $customerEmail
            ]
        ], JSON_THROW_ON_ERROR);

        $response = CurlClient::request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return new \BTCPayServer\Result\Invoice(json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR));
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function getInvoice(string $storeId, string $invoiceId): \BTCPayServer\Result\Invoice
    {
        $url = $this->getBaseUrl() . 'stores/' . urlencode($storeId) . '/invoices/' . urlencode($invoiceId);
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = CurlClient::request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return new \BTCPayServer\Result\Invoice(json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR));
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @param string $storeId
     * @param string $invoiceId
     * @return PaymentMethod[]
     */
    public function getPaymentMethods(string $storeId, string $invoiceId): array
    {
        $method = 'GET';
        $url = $this->getBaseUrl() . 'stores/' . urlencode($storeId) . '/invoices/' . urlencode(
                $invoiceId
            ) . '/payment-methods';
        $headers = $this->getRequestHeaders();
        $response = CurlClient::request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            $r = [];
            $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            foreach ($data as $item) {
                $item = new \BTCPayServer\Result\PaymentMethod($item);
                $r[] = $item;
            }
            return $r;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

}
