<?php

namespace App\Exceptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionTrait
{
    public function apiException($request, $e) {

        if ($this->isModel($e)) {

            return $this->modelResponse();
        }

        if ($this->isHttp($e)) {

            return $this->httpResponse();
        }

        return parent::render($request, $e);
    }

    protected function isModel($e) {

        return $e instanceof ModelNotFoundException;
    }

    protected function isHttp($e) {

        return $e instanceof NotFoundHttpException;
    }

    protected function modelResponse() {

        return response([
            'errors' => 'Product Model not found'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function httpResponse() {

        return response([
            'errors' => 'Incorrect route'
        ], Response::HTTP_NOT_FOUND);

    }


}