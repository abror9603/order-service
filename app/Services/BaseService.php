<?php

namespace App\Services;

use App\Repositories\BaseRepository;
class BaseService {
	protected BaseRepository $model;

	public function getAll()
	{
		return $this->model->getAllOrderByPaginate();
	}

	public function getOne(int $id)
	{
		return $this->model->getOneOrder($id);
	}

	public function createData(array $params, $userId)
	{
		$params['user_id'] = $userId;
		
		return $this->model->createOrder($params);
	}

	public function updateData(array $params, int $id)
	{
		return $this->model->updateOrder($params, $id);
	}

	public function deleteData(int $id)
	{
		return $this->model->deleteOrder($id);
	}
}