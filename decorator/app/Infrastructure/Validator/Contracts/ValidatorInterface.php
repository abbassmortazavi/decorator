<?php namespace App\Infrastructure\Validator\Contracts;

/**
 * Interface ValidatorInterface
 * @package App\Infrastructure\Validator\Contracts
 */
interface ValidatorInterface
{
    const RULE_CREATE = 'create';
    const RULE_UPDATE = 'update';
    const RULE_DELETE = 'delete';

    /**
     * Set Id
     *
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * With
     *
     * @param array $input
     * @return mixed
     */
    public function with(array $input);

    /**
     * Pass the data and the rules to the validator
     *
     * @param null $action
     * @return mixed
     */
    public function passes($action = null);

    /**
     * Pass the data and the rules to the validator or throws ValidatorException
     *
     * @param null $action
     * @return mixed
     */
    public function passesOrFail($action = null);

    /**
     * Errors
     *
     * @return mixed
     */
    public function errors();

    /**
     * Errors
     *
     * @return mixed
     */
    public function errorsBag();

    /**
     * Set Rules for Validation
     *
     * @param array $rules
     * @return mixed
     */
    public function setRules(array $rules);

    /**
     * Get rule for validation by action ValidatorInterface::RULE_CREATE or ValidatorInterface::RULE_UPDATE
     *
     * Default rule: ValidatorInterface::RULE_CREATE
     *
     * @param null $action
     * @return mixed
     */
    public function getRules($action = null);
}
