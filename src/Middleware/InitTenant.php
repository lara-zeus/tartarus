<?php

namespace LaraZeus\Tartarus\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use LaraZeus\Tartarus\Models\Company;
use Symfony\Component\HttpFoundation\Response;

class InitTenant
{
    // identifying the tenant in the frontend
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $this->makeSubdomain($request->getHost());

        if ($subdomain === 'www') {
            return redirect()->away(config('note.central_domain'));
        }
        $company = Company::where('subdomain', $subdomain)->first();

        abort_if($company === null, 404);

        $request->session()->put('company', $company);

        URL::defaults(['domain' => $subdomain]);

        return $next($request);
    }

    protected function makeSubdomain(string $hostname): string
    {
        return explode('.', $hostname)[0];
    }
}
