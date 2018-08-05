<?php

namespace Plugin\GrooaWidgets\Widget\ThumbnailCard;

class Controller extends \Ip\WidgetController
{
    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        if (!empty($data['image'])) {
            $data['image'] = ipFileUrl('file/repository/' . $data['image'][0]);
        } else {
            $data['image'] = '';
        }

        if (empty($data['title'])) {
            $data['title'] = '[Missing required title]';
        }

        $url = '';
        if (!empty($data['link'])) {
            $url = $data['link'];
        } else if (!empty($data['file'])) {
            $url = ipFileUrl('file/repository/' . $data['file'][0]);
        }

        $data['url'] = $url;

        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }
}
