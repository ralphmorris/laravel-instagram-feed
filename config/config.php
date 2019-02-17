<?php

/*
 *
 * To get your API keys go to https://www.instagram.com/developer/clients/manage/ 
 * and follow the steps to register a new client.
 * 
 */

return [

	/*
	 *
	 * Client ID provided to you after you have created your Client with Instagram.
	 * 
	 */
	'client_id' => env('instagram_client_id'),

	/*
	 *
	 * Client Secret provided to you after you have created your Client with Instagram.
	 * 
	 */
	'client_secret' => env('instagram_client_secret'),

	/*
	 *
	 * Define the full qualified class name of the Instagram model. 
	 * You can override this and create your own model extending 
	 * this one if you would like to add your own logic here.
	 * 
	 */
	'instagram_model' => RalphMorris\LaravelInstagramFeed\Models\InstagramProfile::class,

	/*
	 *
	 * Store the feed in the apps cache. Recommended as Instagram has 
	 * a current rate limit of 200 requests per hour on their API.
	 * 
	 */
	'cache' => true,

	/*
	 *
	 * The length of time in minutes that we should store the feed in the cache before refreshing.
	 * 
	 */
	'cache-expiry' => 60 * 24,
	
];