<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResource extends Resource
{
    /**
     * ==========================================================
     * PERMISSION PREFIX
     * ==========================================================
     *
     * Setiap Resource WAJIB menentukan prefix permission.
     *
     * Contoh:
     *
     * mstruangan
     * trxsoftwareassignment
     * trxserviceasset
     *
     * Permission yang akan dicek:
     *
     * {prefix}.view
     * {prefix}.create
     * {prefix}.update
     * {prefix}.delete
     */
    protected static string $permissionPrefix = '';


    /**
     * ==========================================================
     * GET PERMISSION PREFIX
     * ==========================================================
     */
    protected static function getPermissionPrefix(): string
    {
        return static::$permissionPrefix;
    }


    /**
     * ==========================================================
     * VIEW ANY
     * ==========================================================
     */
    public static function canViewAny(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->can(
            static::getPermissionPrefix() . '.view'
        );
    }


    /**
     * ==========================================================
     * VIEW
     * ==========================================================
     */
    public static function canView(
        Model $record
    ): bool {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->can(
            static::getPermissionPrefix() . '.view'
        );
    }


    /**
     * ==========================================================
     * CREATE
     * ==========================================================
     */
    public static function canCreate(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->can(
            static::getPermissionPrefix() . '.create'
        );
    }


    /**
     * ==========================================================
     * EDIT
     * ==========================================================
     */
    public static function canEdit(
        Model $record
    ): bool {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->can(
            static::getPermissionPrefix() . '.update'
        );
    }


    /**
     * ==========================================================
     * DELETE
     * ==========================================================
     */
    public static function canDelete(
        Model $record
    ): bool {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->can(
            static::getPermissionPrefix() . '.delete'
        );
    }


    /**
     * ==========================================================
     * DELETE ANY
     * ==========================================================
     */
    public static function canDeleteAny(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->can(
            static::getPermissionPrefix() . '.delete'
        );
    }
}
