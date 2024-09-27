<?php

namespace formspm\kamy;

use formspm\kamy\types\ModalForm;
use formspm\kamy\types\SimpleForm;
use formspm\kamy\types\CustomForm;
use pocketmine\form\Form as PocketMineForm;

class Form {
    public static function create(FormType $type): PocketMineForm {
        return match ($type) {
            FormType::SIMPLE_FORM => new SimpleForm(),
            FormType::MODAL_FORM => new ModalForm(),
            FormType::CUSTOM_FORM => new CustomForm(),
        };
    }
}
