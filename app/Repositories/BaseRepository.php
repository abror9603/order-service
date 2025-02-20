<?php

namespace App\Repositories;

class BaseRepository{
	protected $model;

	public function getAllOrderByPaginate()
	{
		return $this->model->all();
	}

	public function getOneOrder($id)
	{
		return $this->getById($id);
	}

	public function createOrder(array $params)
	{
		return $this->model->create($params);
	}

	public function updateOrder(array $params, int $id)
	{
		$query = $this->getById($id);

		if($query){
			$query->update($params);
			return $query;
		}else{
			return false;
		}
	}

	public function updateRepoStatus($params)
	{
		$order = $this->getById($params->order_id);
        $order->status = $params->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
	}

	public function deleteOrder(int $id)
	{
		$query = $this->getById($id);
		return $query ? $query->delete() : false;
	}

	public function getById(int $id)
	{
		return $this->model->find($id);
	}
}