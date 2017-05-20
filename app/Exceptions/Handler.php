<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Http\Response;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
		// sửa trong if 
		return parent::render($request, $exception);
		if($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException)
		{
			// some code
			// NOT FOUND
			return response()->view("tokenMismatch", [], 404);
		}
		else if($exception instanceof MethodNotAllowedHttpException ){
			// Method not allowed
			return response()->view("405", [], 405);
		}
		else if($exception instanceof TokenMismatchException ){
			// forbidden
			return response()->view("tokenMismatch", [], 403);
		}
		else if($exception instanceof AuthenticationException){
			if ($request->expectsJson()) {
				return response()->json(['error' => 'Unauthenticated.'], 401);
			}

			return redirect()->guest(route('login'));
		}
		else{
			return response()->view("unspecifiedException", [], 422);
		}
    
        
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
