<?php

namespace App\Traits;

use Illuminate\Support\Collection;

/**
 * Traits ApiFormatter.
 */
trait ApiFormatter
{
    /**
     * @param  Collection|array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($data)
    {
        $return = [
            'success' => true,
            'data' => $this->setData($data),
        ];

        return response()->json($return, 200);
    }

    /**
     * @param  Collection|array  $data
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendErrorResponse($data, $status = 500)
    {
        $return = [
            'success' => false,
            'data' => $this->setData($data),
        ];

        return response()->json($return, $status);
    }

    /**
     * Return data for response.
     */
    private function setData($data): array
    {
        if ($data instanceof Collection) {
            return $data->toArray();
        }

        return $data;
    }
}
