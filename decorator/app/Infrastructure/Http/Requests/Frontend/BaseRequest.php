<?php

namespace App\Infrastructure\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request as IlluminateRequest;

abstract class BaseRequest extends FormRequest
{

    protected $formRequest;

    protected $formRequestUser;

    protected $model;


    /**
     * Constructor
     *
     * BaseRequest constructor.
     * @param IlluminateRequest $request
     */
    public function __construct(IlluminateRequest $request)
    {
        $this->formRequest = $request;

        $this->formRequestUser = $this->formRequest->user();
        if ($this->formRequestUser === null)
            $this->formRequestUser = user();

        parent::__construct();
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isSuperadmin(): bool
    {
        return $this->formRequestUser !== null && $this->formRequestUser->isSuperadmin();
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isAdmin(): bool
    {
        return $this->formRequestUser !== null && $this->formRequestUser->isAdmin();
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isUser(): bool
    {
        return $this->formRequestUser !== null && $this->formRequestUser->isUser();
    }


    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isLaboratory(): bool
    {
        return $this->formRequestUser !== null && $this->formRequestUser->isLaboratory();
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isAssistant(): bool
    {
        return $this->formRequestUser !== null && $this->formRequestUser->isAssistant();
    }

    /**
     * Check the Availability of Role
     *
     * @param $role
     * @return bool
     */
    protected function hasRole($role): bool
    {
        return $this->formRequestUser !== null && ($this->isSuperadmin() || $this->formRequestUser->hasRole($role));
    }

    /**
     * Check the Availability of action
     *
     * @param $action
     * @return bool
     */
    protected function hasPermission($action): bool
    {
        return $this->formRequestUser !== null && ($this->isSuperadmin() || $this->formRequestUser->hasPermission($action));
    }

    /**
     * Check the Availability of action
     *
     * @param $action
     * @return bool
     */
    protected function hasPermissionInRole($action): bool
    {
        return $this->formRequestUser !== null && ($this->isSuperadmin() || $this->formRequestUser->inRole($action));
    }

    /**
     * check permission availability
     *
     * @param $permission
     * @return bool
     */
    protected function checkPermission($permission): bool
    {
        return $this->hasPermission($permission) || $this->hasPermissionInRole($permission);
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function canAccess(): bool
    {
        return $this->isSuperadmin();
    }

    /**
     * Check the process is approved.
     *
     * @param $action
     * @return bool
     */
    protected function can($action): bool
    {
        return $this->formRequestUser !== null && $this->formRequestUser->can($action, $this->model);
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isShow(): bool
    {
        return $this->formRequest !== null && ($this->formRequest->isMethod('GET') || $this->formRequest->is('*/datatable*'));
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isCreate(): bool
    {
        return $this->formRequest !== null && $this->formRequest->is('*/create');
    }

    /**
     * Check the process is store.
     *
     * @return bool
     **/
    protected function isStore(): bool
    {
        return $this->formRequest !== null && $this->formRequest->isMethod('POST');
    }

    /**
     * Check the process is edit.
     *
     * @return bool
     **/
    protected function isEdit(): bool
    {
        return $this->formRequest !== null && $this->formRequest->is('*/edit');
    }

    /**
     * Check the process is update.
     *
     * @return bool
     **/
    protected function isUpdate(): bool
    {
        return $this->formRequest !== null &&
            ($this->formRequest->isMethod('PUT') ||
                $this->formRequest->isMethod('PATCH'));
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isDelete(): bool
    {
        return $this->formRequest !== null && $this->formRequest->isMethod('DELETE');
    }

    /**
     * Check the process is destroyed.
     *
     * @return bool
     **/
    protected function isDestroy(): bool
    {
        return $this->formRequest !== null && $this->formRequest->isMethod('DESTROY');
    }

    /**
     * Check the process is restore.
     *
     * @return bool
     */
    protected function isRestore(): bool
    {
        return $this->formRequest !== null && $this->formRequest->isMethod('RESTORE');
    }

    /**
     * Check the process is acl.
     *
     * @return bool
     */
    protected function isAcl(): bool
    {
        return $this->formRequest !== null && $this->formRequest->isMethod('ACL');
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isPaymentVerify(): bool
    {
        return $this->formRequest !== null && $this->formRequest->is('*/payment/verify');
    }

    /**
     * Check the process is verified.
     *
     * @return bool
     **/
    protected function isAppointmentVOC(): bool
    {
        return $this->formRequest !== null && $this->formRequest->is('*/appointments/telemedicine/show-voc/*');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        // Default validation rule.
        return [];
    }
}
