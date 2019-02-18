<?php

namespace RalphMorris\LaravelInstagramFeed;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use RalphMorris\LaravelInstagramFeed\Exceptions\InstagramErrorException;
use RalphMorris\LaravelInstagramFeed\Models\InstagramProfile;

class Instagram
{
	private $instagram;

    private $redirectUrl = null;

	public function __construct(InstagramProfile $instagramProfile = null)
	{
		$this->instagramProfile = $instagramProfile;
	}

	/**
	 * The auth url users should be directed to to confirm we can access their account.
	 * 
	 * @return string
	 */
	public function getAuthUrl()
	{
		return 'https://api.instagram.com/oauth/authorize/?client_id=' . config('laravel-instagram.client_id') . '&redirect_uri='.$this->getRedirectUri().'&response_type=code';
	}

    /**
     * Manually set the redirect url if needed
     * 
     * @param string $url
     */
    public function setRedirectUri($url)
    {
        $this->redirectUrl = $url;
    }

	/**
	 * The redirect url for instagram to redirect to after confirmation/declination.
	 * 
	 * @return string
	 */
    public function getRedirectUri()
    {
        if ($this->redirectUrl) {
            return $this->redirectUrl;
        }
        
    	return route('instagram.callback');
    }

    /**
     * Handle the callback and retrieve the access token from the code provided by instagram.
     * 
     * @param  string $code
     * @return void
     */
    public function retrieveAccessToken($code)
    {
    	$client = new Client();

		$result = $client->post('https://api.instagram.com/oauth/access_token', [
		    'form_params' => [
		        'client_id' => config('laravel-instagram.client_id'),
		        'client_secret' => config('laravel-instagram.client_secret'),
		        'grant_type' => 'authorization_code',
		        'redirect_uri' => $this->getRedirectUri(),
		        'code' => $code,
		    ]
		]);

		return json_decode($result->getBody());
    }

    /**
     * Get the cache key for the given professional profile
     * 
     * @return string
     */
    protected function cacheKey()
    {
    	return 'instagram.' . $this->instagramProfile->id;
    }

    /**
     * Get the feed for the given access_token. Either from cache or API call.
     * 
     * @return [type] [description]
     */
    public function getFeed()
    {
        if ($feed = $this->maybeGetFromCache()) {
            return $feed;
        }

        try {
            
            $feed = $this->fetchFeed($this->instagramProfile->access_token);

            $this->maybeStoreInCache($feed);
            
            return collect($feed)->all();
            
        } catch (\Exception $e) {

            if (!$this->instagramProfile->had_an_error) {

                $this->instagramProfile->had_an_error = Carbon::now();
                $this->instagramProfile->error_message = $e->getMessage();
                $this->instagramProfile->save();

            }

            return null;
        }
    }

    /**
     * Maybe get the feed from the cache if caching is set 
     * to true in the config and it exists in the cache.
     * 
     * @return mixed Collection|false
     */
    protected function maybeGetFromCache()
    {
        if (!config('laravel-instagram.cache')) {
            return false;
        }

        
        if (Cache::has($this->cacheKey())) {
            return collect(Cache::get($this->cacheKey()))->all();
        }

        return false;
    }

    /**
     * Store the feed in the cache if cache is set to true in config
     * 
     * @param  array $feed
     * @return void
     */
    protected function maybeStoreInCache($feed)
    {
        if (!config('laravel-instagram.cache')) {
            return;
        }

        $expiresAt = Carbon::now()->addMinutes(config('laravel-instagram.cache-expiry'));

        Cache::put($this->cacheKey(), $feed, $expiresAt);
    }

    /**
     * Fetch the feed for the given access_token from the instagram api.
     * 
     * @return [type] [description]
     */
    public function fetchFeed()
    {
    	$client = new Client();

		$result = $client->get('https://api.instagram.com/v1/users/self/media/recent', [
		    'query' => [
		        'access_token' => $this->instagramProfile->access_token,
		    ]
		]);

		return json_decode($result->getBody());
    }
}