<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Closure;
use GuzzleHttp\Pool;
use GuzzleHttp\Client;
class PendingConcurrentPool
{
    private int $concurrency = 10;
    private Closure $requestsBuilder;

    public function __construct(Closure $requestsBuilder)
    {
        $this->requestsBuilder = $requestsBuilder;
    }

    public function concurrency(int $amount): self
    {
        $this->concurrency = $amount;
        return $this;
    }

    public function wait(): Collection
    {
        $responses = collect();

        $pool = new Pool(new Client(), call_user_func($this->requestsBuilder), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function (Response $response, $index) use ($responses) {
                $responses[$index] = new \Illuminate\Http\Client\Response($response);
            },
            'rejected' => function (RequestException $reason, $index) use ($responses) {
                $responses[$index] = new \Illuminate\Http\Client\Response($reason->getResponse());
            },
        ]);

        $pool->promise()->wait();

        return $responses;
    }
}