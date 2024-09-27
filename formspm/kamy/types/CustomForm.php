<?php

namespace formspm\kamy\types;

use formspm\kamy\FormType;
use pocketmine\form\Form as PocketMineForm;
use pocketmine\player\Player;
use Closure;

class CustomForm implements PocketMineForm {
    private string $title = "";
    private array $elements = [];
    private ?Closure $submitAction = null;

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function addSlider(string $text, float $min, float $max, float $default = 0): void {
        $this->elements[] = [
            "type" => "slider",
            "text" => $text,
            "min" => $min,
            "max" => $max,
            "default" => $default,
        ];
    }

    public function addInput(string $text, string $placeholder = ""): void {
        $this->elements[] = [
            "type" => "input",
            "text" => $text,
            "placeholder" => $placeholder,
        ];
    }

    public function addDropdown(string $text, array $options): void {
        $this->elements[] = [
            "type" => "dropdown",
            "text" => $text,
            "options" => $options,
        ];
    }

    public function setSubmitAction(Closure $action): void {
        $this->submitAction = $action;
    }

    public function send(Player $player): void {
        $player->sendForm($this);
    }

    public function jsonSerialize(): array {
        return [
            "type" => FormType::CUSTOM_FORM->value,
            "title" => $this->title,
            "content" => $this->elements,
        ];
    }

    public function handleResponse(Player $player, $data): void {
        if ($this->submitAction !== null) {
            ($this->submitAction)($player, $data);
        }
    }
}
