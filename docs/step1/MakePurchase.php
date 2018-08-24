<?php

require './plugins/php-eu-vat-master/EuropeVAT.php';
require './plugins/redsys/apiRedsys.php';
require './plugins/paypal/Paypal.php';
require './plugins/stripe/stripe.php';
require './plugins/productProviderEurope.php';
require './plugins/productProviderUSA.php';
require './plugins/InternalProvider.php';

class CreateOrder
{
    // Order data
    private $orderId;
    private $description;
    private $createdAt;

    // Payment data
    private $price;
    private $realPrice;
    private $finalNetPrice;
    private $finalNetRealPrice;
    private $currency;
    private $paymentMethod;
    private $vat;
    private $points; // Points is a fidelization mechanism. Each Point spent is a discount of ONE unit over price.
    private $pointsEarned; // This is the amount of points earned on this order
    private $platformCommission;
    private $paymentFee;
    private $isAlreadyPaid;

    // Product data
    private $numberOfProducts;
    private $productNames;
    private $productsWithNoOffer;
    private $productsWithOffer;
    private $productInfoMargin;
    private $productInfo;
    private $totalProductCommission;

    // Fraud data
    private $fraudScore;
    private $fraudFlag;
    private $fraudUserLabel;
    private $fraudReason;


    private $providerNames;
    private $providerTypes;

    // ProviderEurope data
    private $providerEuropePassword;
    private $providerEuropeIds;
    private $providerEuropeOurIds;
    private $providerEuropePrices;
    private $providerEuropePricesIncVAT;
    private $providerEuropeStore;
    private $providerEuropeConfig;
    private $providerEuropeIP;

    // ProviderUSA data
    private $providerUsaIds = [];

    // Payment methods data
    private $lastFour;
    private $zipCheck;
    private $cvcCheck;
    private $cardBrand;
    private $cardFunding;
    private $stripeCardID;
    private $address_city;
    private $address_country;
    private $address_line1;
    private $address_line2;
    private $address_zip;
    private $address_state;
    private $card_name;
    private $paypal_email;
    private $paypal_id;
    private $paypal_address_status;
    private $paypal_status;
    private $stripeCustomerID;
    private $stripeCountry;
    private $storePaymentID;
    private $apiContext;
    private $firstPurchase;
    private $redsysPurchaseID;
    private $isRedsysSecurePayment = false;

    // Referrals data
    private $utm_source;
    private $utm_medium;
    private $utm_campaign;
    private $idAffiliate;

    private $hasProviderEuropeProducts = false;
    private $hasProviderUSAProducts = false;

    private $productsList = [];

    /**
     * @return bool
     */
    public function indexAction()
    {
        /**
         * We rely on SESSION and COOKIES this is a really bad issue we have to solve first
         */
        session_start();

        $this->paymentMethod = $_POST['method'];
        /**
         * We rely on the last insert Id our Mysql database get us, this is an expensive operation.
         * In complex systems we must avoid all the complexity we will solve it in other way.
         */
        $this->orderId = $this->_getOrderId();

        /**
         * Initialize the default values of our data we will manage this isolated
         */
        $this->stripeCardID = '';
        $this->fraudReason = '';
        $this->fraudUserLabel = '';
        $this->redsysPurchaseID = '';
        $this->paymentFee = 0;
        $this->productsWithOffer = false;
        $this->fraudScore = 0.0;
        $this->isAlreadyPaid = false;
        $this->currency = $this->_getCurrencyByCookie();
        $this->utm_source = '';
        $this->utm_medium = '';
        $this->utm_campaign = '';
        $this->idAffiliate = '';
        $this->paymentFee = $this->_calculatePaymentFee();
        if (isset($_SESSION['utm_source'])) {
            $this->utm_source = $_SESSION['utm_source'];
        }
        if (isset($_SESSION['utm_medium'])) {
            $this->utm_medium = $_SESSION['utm_medium'];
        }
        if (isset($_SESSION['utm_campaign'])) {
            $this->utm_campaign = $_SESSION['utm_campaign'];
        }
        if (isset($_COOKIE['idAffiliate'])) {
            $this->idAffiliate = $_COOKIE['idAffiliate'];
        }

        return false;
    }

    /**
     * Connect to the database to perform and insert and then get the insert id to get the order id.
     * This is a smell.
     *
     * @return int
     */
    private function _getOrderId(): int
    {
        $orderId = 123456;

        return $orderId;
    }

    /**
     * Get the user cookie and then, depending on the country, currency and language assign a final Currency.
     * Simplified version of a really complex one operation of validation.
     *
     * @return string
     */
    private function _getCurrencyByCookie(): string
    {
        $currency = 'USD';
        if ($_COOKIE['lang'] === 'es_es' && $_COOKIE['currency'] == 'EUR' && $_COOKIE['country'] === 'spain') {
            $currency = 'EUR';
        }

        return $currency;
    }

    /**
     * We need to calculate the payment fee depending on the payment method and currency
     * Simplified version of a really complex one operation of validation.
     *
     * @return int
     */
    private function _calculatePaymentFee(): int
    {
        $paymentFee = 0;
        if ($this->paymentMethod === 'paypal' && $_COOKIE['currency'] == 'EUR') {
            $paymentFee = 45;
        }

        return $paymentFee;
    }
}
