<?php
/*
 * This code was generated automatically by Nebo15/REST
 */

namespace App\Models;

use Nebo15\REST\Traits\ListableTrait;
use Nebo15\REST\Interfaces\ListableInterface;

/**
 * Class Table
 * @package App\Models
 * @property string $title
 * @property string $description
 * @property string $default_decision
 * @property string $matching_type
 * @property Rule[] $rules
 * @property Field[] $fields
 * @method static Decision findById($id)
 * @method static Decision create(array $attributes = [])
 * @method Decision save(array $options = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 */
class Table extends Base implements ListableInterface
{
    use ListableTrait;

    protected $listable = ['_id', 'title', 'description', 'matching_type', 'default_decision'];

    protected $visible = ['_id', 'title', 'description', 'matching_type', 'default_decision', 'rules', 'fields'];

    protected $fillable = ['title', 'description', 'default_decision', 'matching_type'];

    protected $perPage = 20;

    protected function getArrayableRelations()
    {
        return [
            'fields' => $this->fields,
            'rules' => $this->rules
        ];
    }

    public function rules()
    {
        return $this->embedsMany('App\Models\Rule');
    }

    public function fields()
    {
        return $this->embedsMany('App\Models\Field');
    }

    public function setRules($rules)
    {
        $this->rules()->delete();
        foreach ($rules as $rule) {
            $ruleModel = new Rule($rule);
            if (isset($rule['conditions'])) {
                $ruleModel->setConditions($rule['conditions']);
            }
            $this->rules()->associate($ruleModel);
        }

        return $this;
    }

    public function setFields($fields)
    {
        $this->fields()->delete();
        foreach ($fields as $field) {
            $fieldModel = new Field($field);
            if (isset($field['preset'])) {
                $fieldModel->preset()->associate(new Preset($field['preset']));
            }
            $this->fields()->associate($fieldModel);
        }

        return $this;
    }
}