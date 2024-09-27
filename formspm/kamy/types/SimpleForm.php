<?php

namespace formspm\kamy\types;

use formspm\kamy\FormType;
use pocketmine\form\Form as PocketMineForm;
use pocketmine\player\Player;
use Closure;

class SimpleForm implements PocketMineForm {
    private string $title = "";
    private string $content = "";
    private array $buttons = [];
    private ?Closure $submitAction = null;

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function addButton(string $text, string $icon = null): void {
        $this->buttons[] = [
            "text" => $text,
            "icon" => $icon ? ["type" => "url", "data" => $icon] : null,
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
            "type" => FormType::SIMPLE_FORM->value,
            "title" => $this->title,
            "content" => $this->content,
            "buttons" => array_map(fn($button) => ["text" => $button["text"]], $this->buttons),
        ];
    }

    public function handleResponse(Player $player, $data): void {
        if (is_int($data) && isset($this->buttons[$data])) {
            $buttonId = $data;
            if ($this->submitAction !== null) {
                ($this->submitAction)($player, $buttonId);
            }
        }
    }
}
