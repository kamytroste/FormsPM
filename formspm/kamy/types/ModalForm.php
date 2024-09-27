<?php

namespace formspm\kamy\types;

use formspm\kamy\FormType;
use pocketmine\form\Form as PocketMineForm;
use pocketmine\player\Player;
use Closure;

class ModalForm implements PocketMineForm {
    private string $title = "";
    private string $content = "";
    private string $button1Text = "";
    private string $button2Text = "";
    private ?Closure $submitAction = null;

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function setButton1(string $text): void {
        $this->button1Text = $text;
    }

    public function setButton2(string $text): void {
        $this->button2Text = $text;
    }

    public function setSubmitAction(Closure $action): void {
        $this->submitAction = $action;
    }

    public function send(Player $player): void {
        $player->sendForm($this);
    }

    public function jsonSerialize(): array {
        return [
            "type" => FormType::MODAL_FORM->value,
            "title" => $this->title,
            "content" => $this->content,
            "button1" => $this->button1Text,
            "button2" => $this->button2Text,
        ];
    }

    public function handleResponse(Player $player, $data): void {
        if (is_bool($data) && $this->submitAction !== null) {
            $buttonId = $data ? 0 : 1;
            ($this->submitAction)($player, $buttonId);
        }
    }
}
