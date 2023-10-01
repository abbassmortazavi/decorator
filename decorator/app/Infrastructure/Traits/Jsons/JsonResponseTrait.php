<?php


namespace App\Infrastructure\Traits\Jsons;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait JsonResponseTrait
{

    public array $successMeta = ['success' => true, 'status' => 'success'];
    public array $failedMeta = ['success' => false, 'status' => 'error'];
    public string $key = 'data';

    /**
     * The request has succeeded.
     *
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiOk($data = null, ?array $extra = []): JsonResponse
    {
        return $this->_partialResponse(ResponseAlias::HTTP_OK, $data, $extra);
    }

    /**
     * The request has been fulfilled and resulted in a new resource being created.
     *
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiCreated($data = null, ?array $extra = []): JsonResponse
    {
        return $this->_partialResponse(201, $data, $extra);
    }

    /**
     * The request has been accepted for processing, but the processing has not been completed.
     *
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiUpdated($data = null, ?array $extra = []): JsonResponse
    {
        return $this->_partialResponse(ResponseAlias::HTTP_ACCEPTED, $data, $extra);
    }

    /**
     * @param $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiAccepted($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.accepted')], $this->successMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_ACCEPTED, $data, $extra);
    }

    /**
     * @param $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiDeleted($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.deleted')], $this->successMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_ACCEPTED, $data, $extra);
    }

    /**
     * @param $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiChanged($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.changed')], $this->successMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_ACCEPTED, $data, $extra);
    }

    /**
     * @param $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiRestored($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.restored')], $this->successMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_ACCEPTED, $data, $extra);
    }

    /**
     * @return JsonResponse
     */
    protected function apiNoContent(): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('base::modules.message.no_data')], $this->successMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_NO_CONTENT, $data, $meta);
    }

    /**
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiFailed($data = null, ?array $extra = []): JsonResponse
    {
        return $this->_partialResponse(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $data, $extra);
    }

    /**
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiBadRequest($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.bad_request')], $this->failedMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_BAD_REQUEST, $data, $extra);
    }

    /**
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiUnauthorized($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.unauthorized')], $this->failedMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_UNAUTHORIZED, $data, $extra);
    }

    /**
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiForbidden($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.forbidden')], $this->failedMeta);
        return $this->_partialResponse(403, $data, $extra);
    }

    /**
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    protected function apiNotFound($data = null, ?array $extra = []): JsonResponse
    {
        $data = @array_merge(['message' => trans('base::modules.message.not_found')], $this->failedMeta);
        return $this->_partialResponse(ResponseAlias::HTTP_NOT_FOUND, $data, $extra);
    }

    /**
     * @param $data
     * @param $statusCode
     * @return JsonResponse
     */
    protected function apiException($data, $statusCode): JsonResponse
    {
        return $this->_partialResponse($statusCode, $data, null);
    }

    /**
     * @param int $responseStatus
     * @param null $data
     * @param array|null $extra
     * @return JsonResponse
     */
    private function _partialResponse(int $responseStatus = 202, $data = null, ?array $extra = []): JsonResponse
    {
        $extra = $responseStatus < 400 && is_array($extra) ? @array_merge($extra) : $extra;
        if (empty($data) && empty($extra)) {
            return response()->json(null, $responseStatus);
        }
        if (!empty($data['links']) && !empty($data['meta'])) {
            $meta = $data['meta'];
            $links = $data['links'];
            $data = $data['data'] ?? [];
            $result = $extra !== null ? compact('data', 'meta', 'links', 'extra') : compact('data', 'meta', 'links');
            return response()->json($result, $responseStatus);

        }
        if (!empty($data['data'])) {
            return response()->json(compact('data'), $responseStatus);
        }


        $result = $extra !== null ? compact('data', 'extra') : compact('data');
        return response()->json($result, $responseStatus);

    }
}
