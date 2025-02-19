<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\OrderRepository;

class OrderService extends BaseService{
	public function __construct(OrderRepository $model)
	{
		$this->model = $model;
	}
}