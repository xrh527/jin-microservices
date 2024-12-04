<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\UserService;
use DtmClient\Saga;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Di\Annotation\Inject;

/**
 * DTM.SAGA回调控制器
 * Class SagaController
 * @package App\Controller
 */
#[Controller(prefix: '/saga')]
class SagaController extends AbstractController
{
    /**
     * 注入OrderService
     * @var UserService
     */
    #[Inject]
    protected UserService $userService;


    /**
     * @param RequestInterface $request
     * @return string[]
     */
    #[GetMapping(path: 'successCase')]
    public function successCase(RequestInterface $request): array
    {
        //$saga = new Saga();
        $payload1 = [
            'user_id'=>1,
            'amount'=>1,
            'order_no'=>date("Ymd"),
        ];
        $payload2 = [
            'order_no' => date("Ymd"),
            'user_id' => 1,
            'coupon_id' => 1,
            'order_money' => 10,
            'order_discount' => 8,
            'consume_number' => 1,
            'order_status' => 0,
            'payment' => 1,
        ];
        //return $payload2;
        $serviceUri = 'http://192.168.10.34:9553';
        $serviceUri2 = 'http://192.168.10.34:9552';

        //$saga->init();
        //$saga->add($serviceUri . '/saga/changeStored', $serviceUri . '/saga/changeStoredCompensate', $payload1);
        //$saga->add($serviceUri2 . '/saga/sageCreateOrder', $serviceUri2 . '/saga/sageCreateOrderCompensate', $payload2);
        //$saga->submit();

        $res =  [
            'dtm_result' => 'SUCCESS',
        ];

        return $res;

    }

    /**
     * 改变储值成功
     * @param RequestInterface $request
     * @return string[]
     */
    #[PostMapping(path: 'changeStored')]
    public function changeStored(RequestInterface $request): array
    {
        //调用userService.changeStored方法
        $this->userService->changeStored(
            $request->input('user_id'),
            $request->input('amount'),
            $request->input('order_no'),
        );

        return [
            'dtm_result' => 'SUCCESS',
        ];
    }

    /**
     * 改变储值成功补偿
     * @param RequestInterface $request
     * @return string[]
     */
    #[PostMapping(path: 'changeStoredCompensate')]
    public function changeStoredCompensate(RequestInterface $request): array
    {
        //调用userService.changeStoredCompensate方法
        $this->userService->changeStoredCompensate(
            $request->input('user_id'),
            $request->input('amount'),
            $request->input('order_no'),
        );

        return [
            'dtm_result' => 'SUCCESS',
        ];
    }
}
