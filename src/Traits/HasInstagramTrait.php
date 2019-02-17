<?php

namespace RalphMorris\LaravelInstagram\Traits;

trait HasInstagramTrait
{
    /**
     * A model can have one Instagram Profile
     */
    public function instagram()
    {
        return $this->morphOne(config('laravel-instagram.instagram_model'), 'instagramable');
    }
	
	/**
	 * Store the Instagram profile information from the 
	 * response in the retrieve token callback.
	 * 
	 * @param  object $data
	 * @return Instagram model
	 */
	public function storeInstagramProfile($data)
	{
		return $this->instagram()->create([
			'username' => $data->user->username,
			'access_token' => $data->access_token
		]);
	}
}