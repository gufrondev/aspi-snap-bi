<?php
/**
 * Requestor class for making HTTP requests
 */

namespace App\Libraries\AspiSnapBI;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class Requestor
{
    protected ?PendingRequest $request = null;

    public function __construct() {}

    /**
     * Magic method to allow calling any method on the instance.
     *
     * @param string $method The method to call.
     * @param array $arguments The arguments to pass to the method.
     *
     * @return mixed The result of the method call.
     */
    public function __call(string $method, array $arguments): mixed {
        if ( !$this->request ) {
            $this->request = Http::acceptJson();
        }

        if ($method === 'withHeaders') {
            $this->request->withHeaders(...$arguments);

            return $this;
        }

        if ( $method == 'proxy' ) {
            $pass = urlencode($arguments['password']);
            $this->request->mergeOptions([
                'proxy' => "http://{$arguments['username']}:{$pass}@{$arguments['host']}:{$arguments['port']}"
            ]);

            return $this;
        }

        if ( in_array($method, ['get', 'post', 'put', 'patch', 'delete']) ) {
            $resp = $this->request->$method(...$arguments);

            $this->request = null;

            return $resp;
        }

        $this->request->$method(...$arguments);

        return $this;
    }
}
