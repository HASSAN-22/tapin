<?php

namespace Tapin;

use Tapin\Exceptions\ProductStructureException;
use Tapin\Exceptions\ValidateDateFormatException;

class Tapin
{

    /**
     * Set tapin auth key
     * @param string $authKey
     * @return self
     */
    public static function setAuthKey(string $authKey):Tapin
    {
        Request::setAuthKey($authKey);
        return new self();
    }
    /**
     * Get provinces
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function getProvinces(int $count=32, int $page=1):array
    {
        return Request::send('state/list/',["count"=>$count, "page"=>$page])->body();
    }

    /**
     * Get Cities
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function getCities(int $provinceCode, int $count=32, int $page=1):array
    {
        return Request::send('city/list/',["state_code"=>$provinceCode,"count"=>$count, "page"=>$page])->body();
    }

    /**
     * Receive provinces and cities
     * @return array
     */
    public static function getProvinceAndCity():array
    {
        return Request::send('state/tree/')->body();
    }

    /**
     * List of shops
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function shopList(int $count=10, int $page=1):array
    {
        return Request::send('shop/list/',["count"=>$count,"page"=>$page])->body();
    }

    /**
     * List of kiosks
     * @param string $shopId
     * @param int $provinceCode
     * @param int $cityCode
     * @return array
     */
    public static function kioskList(string $shopId, int $provinceCode, int $cityCode):array
    {
        return Request::send('order/post/kiosk/',["shop_id"=>$shopId,"city_code"=>$cityCode,'province_code'=>$provinceCode])->body();
    }

    /**
     * Shop information
     * @param string $shopId
     * @return array
     */
    public static function shopInfo(string $shopId):array
    {
        return Request::send('shop/detail/',["shop_id"=>$shopId])->body();
    }

    /**
     * Get shop inventory
     * @param string $shopId
     * @return array
     */
    public static function shopValidity(string $shopId):array
    {
        return Request::send('transaction/credit/',["shop_id"=>$shopId])->body();
    }

    /**
     * List of categories
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function categories(int $count=10, int $page=1):array
    {
        return Request::send('product/category/list/',["count"=>$count, "page"=>$page])->body();
    }

    /**
     * List of products
     * @param string $shopId
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function products(string $shopId, int $count=10, int $page=1):array
    {
        return Request::send('product/list/',["shop_id"=>$shopId,"count"=>$count, "page"=>$page])->body();
    }

    /**
     * Create new product
     * @param string $shopId
     * @param string $title
     * @param int $price
     * @param int $weight
     * @param string $categoryId
     * @param string|null $description
     * @return array
     */
    public static function createProduct(string $shopId, string $title, int $price, int $weight, string $categoryId, string $description=''):array
    {
        $data = [
          "shop_id"=>$shopId,
          "title"=>$title,
          "price"=>$price,
          "weight"=>$weight,
          "category_id"=>$categoryId,
          "description"=>$description,
        ];
        return Request::send('product/create/',$data)->body();
    }

    /**
     * update a product
     * @param string $shopId
     * @param int $productId
     * @param string $title
     * @param int $price
     * @param int $weight
     * @param string $categoryId
     * @param string|null $description
     * @return array
     */
    public static function updateProduct(string $shopId, int $productId, string $title, int $price, int $weight, string $categoryId, string $description=''):array
    {
        $data = [
          "shop_id"=>$shopId,
          "product_id"=>$productId,
          "title"=>$title,
          "price"=>$price,
          "weight"=>$weight,
          "category_id"=>$categoryId,
          "description"=>$description,
        ];
        return Request::send('product/update/',$data)->body();
    }

    /**
     * delete a product
     * @param string $shopId
     * @param int $productId
     * @return array
     */
    public static function deleteProduct(string $shopId, int $productId):array
    {
        $data = [
          "shop_id"=>$shopId,
          "product_id"=>$productId
        ];
        return Request::send('product/delete/',$data)->body();
    }

    /**
     * List of employees
     * @param string $shopId
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function employeeList(string $shopId, int $count=10, int $page=1):array
    {
        $data = [
          "shop_id"=>$shopId,
          "count"=>$count,
          "page"=>$page
        ];
        return Request::send('employee/list/',$data)->body();
    }

    /**
     * List of customer categories
     * @param string $shopId
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function customerCategories(string $shopId, int $count=10, int $page=1):array
    {
        $data = [
          "shop_id"=>$shopId,
          "count"=>$count,
          "page"=>$page
        ];
        return Request::send('customer/category/list/',$data)->body();
    }

    /**
     * List of customers
     * @param string $shopId
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function customers(string $shopId, int $count=10, int $page=1):array
    {
        $data = [
          "shop_id"=>$shopId,
          "count"=>$count,
          "page"=>$page
        ];
        return Request::send('customer/list/',$data)->body();
    }


    /**
     * Add order to tapin
     * @param string $shopId
     * @param array $products
     * @param string $address
     * @param int $provinceCode
     * @param int $cityCode
     * @param string $fistName
     * @param string $lastName
     * @param string $mobile
     * @param string $postalCode
     * @param int $payType
     * @param int $orderType
     * @param int $packageWeight
     * @param int $presenterCode
     * @param int $manualId
     * @param int $contentType
     * @param int $registerType
     * @param string $employeeCode
     * @param array $kiosk
     * @param int|null $insuranceId
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $description
     * @return array
     * @throws ProductStructureException
     */
    public static function createOrder(string $shopId, array $products, string $address, int $provinceCode, int $cityCode, string $fistName, string $lastName, string $mobile, string $postalCode, int $payType, int $orderType, int $packageWeight, int $presenterCode, int $manualId, int $contentType,int $registerType=0, string $employeeCode='-1', array $kiosk=[], int $insuranceId=null, string $email=null, string $phone=null, string $description=null):array
    {
        if(!hasNestedArrays($products)){
            throw new ProductStructureException($_SERVER['SCRIPT_NAME']);
        }
        $data = [
            "register_type" => $registerType,
            "shop_id" => $shopId,
            "address" => $address,
            "city_code" => $cityCode,
            "province_code" => $provinceCode,
            "description" => $description,
            "email" => $email,
            "employee_code" => $employeeCode,
            "first_name" => $fistName,
            "last_name" => $lastName,
            "mobile" => $mobile,
            "phone" => $phone,
            "postal_code" => $postalCode,
            "pay_type" => $payType,
            "order_type" => $orderType,
            "package_weight" => $packageWeight,
            "presenter_code" => $presenterCode,
            "manual_id" => $manualId,
            "insurance_id" => $insuranceId,
            "content_type" => $contentType,
            "products" => $products,
            "kiosk" => $kiosk,
        ];
        if(count($kiosk) <= 0){
            unset($data['kiosk']);
        }
        return Request::send('order/post/register/',$data)->body();
    }

    /**
     * The cost of sending the order
     * @param string $shpId
     * @param array $products
     * @param string $address
     * @param int $provinceCode
     * @param int $cityCode
     * @param string $employeeCode
     * @param string $firstName
     * @param string $lastName
     * @param string $mobile
     * @param int $postalCode
     * @param int $payType
     * @param int $orderType
     * @param int $packageWeight
     * @param array $kiosk
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $description
     * @return array
     */
    public static function priceInquiry(string $shpId, array $products, string $address, int $provinceCode, int $cityCode, string $employeeCode, string $firstName, string $lastName, string $mobile, int $postalCode, int $payType, int $orderType, int $packageWeight, array $kiosk=[], string $email=null, string $phone=null, string $description=null):array
    {
        if(!hasNestedArrays($products)){
            throw new ProductStructureException($_SERVER['SCRIPT_NAME']);
        }
        $data = [
            "shop_id"=>$shpId,
            "address"=>$address,
            "city_code"=>$cityCode,
            "province_code"=>$provinceCode,
            "description"=>$description,
            "email"=>$email,
            "employee_code"=>$employeeCode,
            "first_name"=>$firstName,
            "last_name"=>$lastName,
            "mobile"=>$mobile,
            "phone"=>$phone,
            "postal_code"=>$postalCode,
            "pay_type"=>$payType,
            "order_type"=>$orderType,
            "package_weight"=>$packageWeight,
            "products"=>$products,
            "kiosk"=>$kiosk
        ];
        if(count($kiosk) <= 0){
            unset($data['kiosk']);
        }
        return Request::send('order/post/check-price/',$data)->body();
    }

    /**
     * List of insurance amounts
     * @return array
     */
    public static function insuranceAmounts():array
    {
        return Request::send('insurance/list/')->body();
    }

    /**
     * Changing the status of order
     * @param string $shopId
     * @param int $orderId
     * @param int $status
     * @return array
     */
    public static function changeOrderStatus(string $shopId, int $orderId, int $status):array
    {
        $data = [
          "shop_id"=>$shopId,
          "order_id"=>$orderId,
          "status"=>$status,
        ];
        return Request::send('order/post/change-status/',$data)->body();
    }

    /**
     * List of orders
     * @param string $shopId
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function orders(string $shopId, int $count=10, int $page=1):array
    {
        $data = [
            "shop_id"=>$shopId,
            "count"=>$count,
            "page"=>$page,
        ];
        return Request::send('order/post/list/',$data)->body();
    }

    /**
     * Order details
     * @param string $shopId
     * @param int $orderId
     * @return array
     */
    public static function orderDetail(string $shopId, int $orderId):array
    {
        $data = [
            "shop_id"=>$shopId,
            "order_id"=>$orderId,
        ];
        return Request::send('order/post/detail/',$data)->body();
    }

    /**
     * Request link for payment
     * @param string $shopId
     * @param int $price
     * @param string $callback
     * @return array
     */
    public static function paymentLink(string $shopId, int $price, string $callback):array
    {
        $data = [
            "shop_id"=>$shopId,
            "price"=>$price,
            "redirect_page"=>$callback,
        ];
        return Request::send('transaction/indirect/new/',$data)->body();
    }

    /**
     * List of transactions history
     * @param string $shopId
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function transactions(string $shopId, int $count=10, int $page=1):array
    {
        $data = [
            "shop_id"=>$shopId,
            "count"=>$count,
            "page"=>$page,
        ];
        return Request::send('transaction/online-increase-credit/list/',$data)->body();
    }

    /**
     * Create batch of orders
     * @param string $shopId
     * @param array $orders
     * @return array
     */
    public static function createBatchOfOrders(string $shopId, array $orders):array
    {
        $data = [
            "shop_id"=>$shopId,
            "orders"=>$orders,
        ];
        return Request::send('order/post/register/bulk/',$data)->body();
    }

    /**
     * Changing the batch status of orders
     * @param string $shopId
     * @param array $orders
     * @param string $status
     * @return array
     */
    public static function changeBatchOfOrderStatus(string $shopId, array $orders, string $status):array
    {
        $data = [
            "shop_id"=>$shopId,
            "orders"=>$orders,
            "status"=>$status
        ];
        return Request::send('order/post/change-status/bulk/',$data)->body();
    }

    /**
     * Get the latest order status change by date
     * @param string $shopId
     * @param string $date
     * @param int $count
     * @param int $page
     * @return array
     */
    public static function getOrderStatusByDate(string $shopId, string $date, int $count=10, int $page=10):array
    {
        if(!validateDateFormat($date)){
            throw new ValidateDateFormatException($_SERVER['SCRIPT_NAME']);
        }
        $data = [
            "shop_id"=>$shopId,
            "count"=>$count,
            "page"=>$page,
            "date"=>$date
        ];
        return Request::send('order/post/change-status/report/',$data)->body();
    }

    /**
     * Receive the latest order status changes within a specified date range
     * @param string $shopId
     * @param string $fromDate
     * @param string $toDate
     * @param int $count
     * @param int $page
     * @return array
     * @throws ValidateDateFormatException
     */
    public static function getOrderStatusBetweenDate(string $shopId, string $fromDate, string $toDate, int $count=10, int $page=10):array
    {
        if(!validateDateFormat($fromDate) or !validateDateFormat($toDate)){
            throw new ValidateDateFormatException($_SERVER['SCRIPT_NAME']);
        }
        $data = [
            "shop_id"=>$shopId,
            "count"=>$count,
            "page"=>$page,
            "from_date"=>$fromDate,
            "to_date"=>$toDate,
        ];
        return Request::send('order/post/change-status/report/last-change-status/',$data)->body();
    }

}