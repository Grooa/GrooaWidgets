<?php

namespace Plugin\GrooaWidgets\Form;

use Ip\Form;

class TopThreeSectionForm extends GenericWidgetForm {

    public function buildManagementForm($widgetData = array(), $validationFuncName = '')
    {
        $form = $this->setupManagementForm($validationFuncName);

        $form->addField(new \Ip\Form\Field\Text([
            'name' => 'title',
            'label' => 'Title',
            'value' => !empty($widgetData['title']) ? $widgetData['title'] : null
        ]));

        $form->addField(new \Ip\Form\Field\Text([
            'name' => 'subTitle',
            'label' => 'Sub-title',
            'value' => !empty($widgetData['subTitle']) ? $widgetData['subTitle'] : null
        ]));

        $nths = [3, 2, 1];

        foreach($nths as $nth) {
            $form = $this->addTopNthItem($nth, $form, $widgetData);
        }

        $form->addField(new Form\Field\Hidden([
            'name' => 'items',
            'value' => json_encode($nths)
        ]));

        return $form;
    }

    public function validateManagementForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->buildManagementForm();
        $data = $form->filterValues($data); //filter post data to remove any non form specific items
        $errors = $form->validate($data); //http://www.impresspages.org/docs/form-validation-in-php-3

        if ($errors) {
            //error
            $data = array(
                'status' => 'error',
                'errors' => $errors
            );
        } else {
            //success
            unset($data['aa']);
            unset($data['securityToken']);
            unset($data['antispam']);
            $data = array(
                'status' => 'ok',
                'data' => $data
            );
        }

        return new \Ip\Response\Json($data);
    }

    private function addTopNthItem($nth, $form, $widgetData)
    {
        $itemFieldset = new \Ip\Form\Fieldset();
        $itemFieldset->setLabel($nth . '. Item');
        $form->addFieldset($itemFieldset);


        $linkName = $nth . 'Link';
        $form->addField(new \Ip\Form\Field\Url([
            'name' => $linkName,
            'label' => 'Page URL',
            'hint' => 'Link to where the user should go, if the item is clicked',
            'value' => !empty($widgetData[$linkName]) ? $widgetData[$linkName] : null,
        ]));

        $imageName = $nth . 'Image';
        $form->addField(new \Ip\Form\Field\RepositoryFile([
            'name' => $imageName,
            'label' => 'Image',
            'value' => !empty($widgetData[$imageName]) ? $widgetData[$imageName] : null,
            'preview' => 'thumbnails', //or list. This defines how files have to be displayed in the repository browser
            'fileLimit' => 1, //optional. Limit file count that can be selected. -1 For unlimited
            'filterExtensions' => array('jpg', 'jpeg', 'png', 'gif', 'webm', 'ogg', 'svg') //optional
        ]));

        $titleName = $nth . 'Title';
        $form->addField(new \Ip\Form\Field\Text([
            'name' => $titleName,
            'label' => 'Title',
            'value' => !empty($widgetData[$titleName]) ? $widgetData[$titleName] : null,
            'hint' => 'This items title. If omitted, will it hide the whole section!'
        ]));

        $bodyName = $nth . 'Body';
        $form->addField(new \Ip\Form\Field\Textarea([
            'name' => $bodyName,
            'label' => 'Short text',
            'value' => !empty($widgetData[$bodyName]) ? $widgetData[$bodyName] : null
        ]));

        return $form;
    }
}
