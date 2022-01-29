<?php

declare(strict_types=1);

namespace BTCPayServer\Client;

class PullPayment extends AbstractClient
{
    /*
    |--------------------------------------------------------------------------
    | Management Pull Payment Methods.
    |--------------------------------------------------------------------------
    |
    | For management to get, create and archive a pull payment.
    | Approve, cancel or mark a payout as paid.
    |
    */

    /**
    * Get Store's Pull Payments
    *
    * @return string $id
    * @return string $name
    * @return string $currency
    * @return int $amount
    * @return int $period
    * @return int $BOLT11Expiration
    * @return bool $archived
    * @return string $viewlink
    */

    public function getStorePullPayments(
        string $storeId,
        bool $includeArchived
    ) {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/pull-payments';

        $headers = $this->getRequestHeaders();
        $method = 'GET';

        $body = json_encode(
            [
                'includeArchived' => $includeArchived,
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
    * Create a Pull Payment
    *
    * @return string $id
    * @return string $name
    * @return string $currency
    * @return int $amount
    * @return int $period
    * @return int $BOLT11Expiration
    * @return bool $archived
    * @return string $viewlink
    */

    public function createPullPayment(
        string $storeId,
        string $paymentName,
        string $paymentAmount,
        string $paymentCurrency,
        mixed $paymentPeriod,
        mixed $boltExpiration,
        mixed $startsAt,
        mixed $expiresAt,
        array $paymentMethods
    ) {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/pull-payments';

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode(
            [
                'name' => $paymentName,
                'amount' => $paymentAmount,
                'currency' => $paymentCurrency,
                'period' => $paymentPeriod,
                'BOLT11Expiration' => $boltExpiration,
                'startsAt' => $startsAt,
                'expiresAt' => $expiresAt,
                'paymentMethods' => $paymentMethods
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
    * Archive a Pull Payment
    *
    * @return true on success, throws exception
    */

    public function archivePullPayment(
        string $storeId,
        string $pullPaymentId
    ) {
        $url = $this->getApiUrl() . 'stores/' .
        urlencode($storeId) . '/' . 'pull-payments/' .
        urlencode($pullPaymentId);

        $headers = $this->getRequestHeaders();
        $method = 'DELETE';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return true;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
    * Approve a Payout
    *
    * @return string $id
    * @return int $revision
    * @return string $pullPaymentId
    * @return string $date
    * @return string $destination
    * @return int $amount
    * @return string $paymentMethod
    * @return string $cryptoCode
    * @return int $paymentMethodAmount
    * @return string $state
    */

    public function approvePayout(
        string $storeId,
        string $payoutId,
        int $revision,
        mixed $rateRule
    ) {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/' . 'payouts/' .
                    urlencode($payoutId);

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode(
            [
                'revision' => $revision,
                'rateRule' => $rateRule,
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
    * Cancel a Pull Payment
    *
    * @return true on success, throws exception
    */

    public function cancelPayout(
        string $storeId,
        string $payoutId
    ) {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/' . 'payouts/' .
                    urlencode($payoutId);

        $headers = $this->getRequestHeaders();
        $method = 'DELETE';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return true;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
    * Mark a Payout as Paid
    *
    * @return true on success, throws exception
    */

    public function markPayoutAsPaid(
        string $storeId,
        string $payoutId
    ) {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/' . 'payouts/' .
                    urlencode($payoutId);

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return true;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Public Pull Payment Methods.
    |--------------------------------------------------------------------------
    |
    | For public interaction with their payouts.
    |
    */

    public function getPullPayment(
        string $pullPaymentId
    ) {
        $url = $this->getApiUrl() . 'pull-payments/' .
                    urlencode($pullPaymentId);

        $headers = $this->getRequestHeaders();
        $method = 'GET';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function getPayouts(
        string $pullPaymentId,
        bool $includeCancelled
    ) {
        $url = $this->getApiUrl() . 'pull-payments/' .
                    urlencode($pullPaymentId) . '/payouts';

        $headers = $this->getRequestHeaders();
        $method = 'GET';

        $body = json_encode(
            [
                'includeCancelled' => $includeCancelled,
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function createPayout(
        string $pullPaymentId,
        string $destination,
        string $amount,
        string $paymentMethod
    ) {
        $url = $this->getApiUrl() . 'pull-payments/' .
                     urlencode($pullPaymentId) . '/payouts';

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode(
            [
                'destination' => $destination,
                'amount' => $amount,
                'paymentMethod' => $paymentMethod,
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function getPayout(
        string $pullPaymentId,
        string $payoutId
    ) {
        $url = $this->getApiUrl() . 'pull-payments/' .
                    urlencode($pullPaymentId) . '/payouts' . '/' .
                    urlencode($payoutId);

        $headers = $this->getRequestHeaders();
        $method = 'GET';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }
}
