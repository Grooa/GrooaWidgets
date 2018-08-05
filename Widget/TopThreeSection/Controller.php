<?php

namespace Plugin\GrooaWidgets\Widget\TopThreeSection;

use Plugin\GrooaWidgets\Parsedown;

class Controller extends \Ip\WidgetController
{
    private $parsedown;

    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        if (empty($data['title'])) {
            $data['title'] = '[Missing title]';
        }

        if (!isset($this->parsedown)) {
            $this->parsedown = new Parsedown();
        }

        $data['items'] = $this->listifyItems($data);
        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }

    private function listifyItems($data)
    {
        $items = json_decode($data['items']);

        return array_map(function($item) use ($data) {
            return $this->serializeItem($data, $item);
        }, $items);
    }

    private function serializeItem(array $data, $item)
    {
        $urlName = $item . 'Link';
        $imageName = $item . 'Image';
        $titleName = $item . 'Title';
        $bodyName = $item . 'Body';

        return [
            'id' => $item,
            'title' => $data[$titleName],
            'img' => !empty($data[$imageName]) ? ipFileUrl('file/repository/' . $data[$imageName][0]) : null,
            'body' => !empty($data[$bodyName]) ? $this->parsedown->parse($data[$bodyName]) : null,
            'url' => !empty($data[$urlName]) ? $data[$urlName] : null
        ];
    }
}
