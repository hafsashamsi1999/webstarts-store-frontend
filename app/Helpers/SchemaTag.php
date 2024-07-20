<?php

namespace App\Helpers;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

class SchemaTag implements TagInterface {

    private $type = 'application/ld+json';
    public $options = [];

    public function __construct(array $options)
    {
        $this->options = $options;
    }
   
    public function getPlacement(): string
    {
        return 'head';
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'options' => json_encode($this->options)
        ];
    }
    
    public function toHtml()
    {
        return '<script type="'.$this->type.'">'.json_encode($this->options).'</script>';
    }
}