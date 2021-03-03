<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

trait AuthorizeForAdmin
{

    /**
     * Determine if the current user can view the given resource or throw an exception.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeToView(Request $request)
    {
        throw_unless($this->authorizedToView($request), AuthorizationException::class);
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function authorizedToView(Request $request)
    {
        if ($this->resource->id === $request->user()->id) {
            return true;
        }

        if ($this->resource->hasAnyRole(Role::IGNORE_ROLES)) {
            return false;
        }

        return parent::authorizedToDelete($request);
    }

    /**
     * Determine if the current user can update the given resource or throw an exception.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeToUpdate(Request $request)
    {
        throw_unless($this->authorizedToUpdate($request), AuthorizationException::class);
    }

    /**
     * Determine if the current user can delete the given resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        if ($this->resource->id === $request->user()->id) {
            return true;
        }

        if ($this->resource->hasAnyRole(Role::IGNORE_ROLES)) {
            return false;
        }

        return parent::authorizedToDelete($request);
    }

    /**
     * Determine if the current user can delete the given resource or throw an exception.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeToDelete(Request $request)
    {
        throw_unless($this->authorizedToDelete($request), AuthorizationException::class);
    }

    /**
     * Determine if the current user can delete the given resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        if ($this->resource->hasAnyRole(Role::IGNORE_ROLES)) {
            return false;
        }

        return parent::authorizedToDelete($request);
    }

    /**
     * Determine if the current user can force delete the given resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function authorizedToForceDelete(Request $request)
    {
        if ($this->resource->hasAnyRole(Role::IGNORE_ROLES)) {
            return false;
        }

        return parent::authorizedToForceDelete($request);
    }
}
