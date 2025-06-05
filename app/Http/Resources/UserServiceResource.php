<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserServiceResource extends JsonResource
{
    public $status;
    public $message;

    public function __construct($resource, $status = 'Success', $message = 'UserService data loaded')
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource ? parent::toArray($request) : null,
        ];
    }

}
