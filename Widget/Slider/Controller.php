<?php

namespace Plugin\GrooaWidgets\Widget\Slider;

class Controller extends \Ip\WidgetController
{
    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        ipAddJsVariable('gcSliderData', $this->transformSliderDataToList($data));

        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }

    private function transformSliderDataToList(array $data): array
    {
        $transformedViews = [];

        $views = json_decode($data['views']);

        foreach ($views as $view) {
            $transformedViews[] = $this->extractSliderData($view, $data);
        }

        return $transformedViews;
    }

    private function extractSliderData(string $prefix, array $slide): array
    {
        $data = [];

        $data['viewName'] = $prefix;
        $data['url'] =  $slide[$prefix . 'Link'] ?? null;
        $data['urlLabel'] = $slide[$prefix . 'LinkLabel'] ?? null;
        $data['img'] = ipFileUrl('file/repository/' . $slide[$prefix . 'Image'][0]);
        $data['title'] = $slide[$prefix . 'Title'];
        $data['body'] = $slide[$prefix . 'Body'] ?? null;

        return $data;
    }
}
