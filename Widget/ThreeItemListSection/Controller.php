<?php

namespace Plugin\GrooaWidgets\Widget\ThreeItemListSection;

use Plugin\GrooaWidgets\Parsedown;

class Controller extends \Ip\WidgetController
{
    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        if (empty($data['title'])) {
            $data['title'] = '[Missing title]';
        }

        $parsedown = new Parsedown();

        if (!empty($data['headerText'])) {
            $data['headerText'] = $parsedown->parse($data['headerText']);
        }

        if (!empty($data['footerText'])) {
            $data['footerText'] = $parsedown->parse($data['footerText']);
        }

        $data['items'] = $this->listifyItems($data);
        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }

    private function listifyItems(array $data): array
    {
        $items = [];

        if (!empty($data['firstItemTitle'])) {
            $items[0] = $this->serializeItem('firstItem', $data);
        }

        if (!empty($data['secondItemTitle'])) {
            $items[1] = $this->serializeItem('secondItem', $data);
        }

        if (!empty($data['thirdItemTitle'])) {
            $items[2] = $this->serializeItem('thirdItem', $data);
        }

        return $items;
    }

    private function serializeItem($name, $data): array
    {
        $titleName = $name . 'Title';
        $imageName = $name . 'Image';
        $bodyName = $name . 'Body';
        $urlName = $name . 'Link';

        return [
            'title' => $data[$titleName],
            'img' => !empty($data[$imageName]) ? ipFileUrl('file/repository/' . $data[$imageName][0]) : null,
            'body' => !empty($data[$bodyName]) ? $data[$bodyName] : null,
            'url' => !empty($data[$urlName]) ? $data[$urlName] : null
        ];
    }

}
