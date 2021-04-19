<?php

namespace Dniccum\PhoneNumber;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class PhoneNumber extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'intl-phone-number';

    public $countriesToValidate = 'AUTO';

    public $ignoreValidation = false;

    public function __construct(string $name, ?string $attribute = null,  $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
    }

    public function resolve($resource, $attribute = null)
    {
        $this->setRules();

        return parent::resolve($resource, $attribute);
    }


    /**
     * Tells the field to show as a clickable tel link on the index view
     * @param bool $linkOnIndex
     * @return PhoneNumber
     */
    public function linkOnIndex(bool $linkOnIndex = true)
    {
        return $this->withMeta([
            'linkOnIndex' => $linkOnIndex
        ]);
    }

    /**
     * Tells the field to show as a clickable tel link on the detail view
     * @param bool $linkOnDetail
     * @return PhoneNumber
     */
    public function linkOnDetail(bool $linkOnDetail = true)
    {
        return $this->withMeta([
            'linkOnDetail' => $linkOnDetail
        ]);
    }

    /**
     * Overrides the default US country phone number validation
     * @param string $country
     * @return PhoneNumber
     */
    public function country(string $country = "AUTO")
    {
        $this->countriesToValidate = $country;

        return $this->setRules();
    }

    /**
     * Provides a list of countries to validate against
     * @param array $countries
     * @return PhoneNumber
     */
    public function countries(array $countries)
    {
        $this->countriesToValidate = implode(',', $countries);

        return $this->setRules();
    }

    /**
     * Tells the plugin to disable any of the field validation
     * @param bool $ignore
     * @return $this
     */
    public function disableValidation(bool $ignore = true)
    {
        $this->ignoreValidation = $ignore;

        $this->withMeta([
            'disableValidation' => $ignore
        ]);

        $this->setRules();

        return $this;
    }

    /**
     * Appends the Phone number validation rules
     *
     * @param  callable|array|string  $rules
     * @return $this
     */
    public function rules($rules)
    {
        $this->rules = is_string($rules) ? func_get_args() : $rules;

        return $this->setRules();
    }

    /**
     * Sets the rules for the class
     *
     * @return void
     */
    private function setRules()
    {
        $phoneValidationRules = [];

        if ($this->ignoreValidation === false) {
            $phoneValidationRules = ["phone:" . $this->countriesToValidate];

            if ($this->nullable) {
                array_push($phoneValidationRules, 'nullable');
            }
        }

        $this->rules = array_merge_recursive(
            $phoneValidationRules,
            $this->rules
        );

        return $this;
    }
}
