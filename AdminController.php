<?php

namespace Plugin\GrooaWidgets;


use Ip\Form;

class AdminController
{
    /**
     * WidgetSkeleton.js ask to provide widget management popup HTML. This controller does this.
     * @return \Ip\Response\Json
     * @throws \Ip\Exception\View
     */
    public function widgetPopupHtml()
    {
        $widgetId = ipRequest()->getQuery('widgetId');
        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        // Populate form with proper fields
        switch ($widgetRecord['name']) {
            case 'ContentSection':
                //create form prepopulated with current widget data
                $form = $this->contentSectionManagementForm($widgetData);
                break;
            case 'ThreeItemListSection':
                $form = $this->threeItemManagementForm($widgetData);
                break;

            case 'Slider':
                $form = $this->sliderManagementForm($widgetData);
                break;
            case 'TopThreeSection':
                $form = $this->topThreeSectionManagementForm($widgetData);
                break;
            default:
                $err = new \Ip\Response\Json([
                    'error' => 'Unknown widget',
                    'widget' => $widgetRecord
                ]);
                $err->setStatusCode(400);
                return $err;
        }

        //Render form and popup HTML
        $viewData = array(
            'form' => $form
        );
        $popupHtml = ipView('view/editPopup.php', $viewData)->render();
        $data = array(
            'popup' => $popupHtml
        );
        //Return rendered widget management popup HTML in JSON format
        return new \Ip\Response\Json($data);
    }

    /**
     * Check widget's posted data and return data to be stored or errors to be displayed
     */
    public function checkContentSectionForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->contentSectionManagementForm();
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

    /**
     * Check widget's posted data and return data to be stored or errors to be displayed
     */
    public function checkThreeItemForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->threeItemManagementForm();
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

    /**
     * Check widget's posted data and return data to be stored or errors to be displayed
     */
    public function checkSliderForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->sliderManagementForm();
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

    protected function threeItemManagementForm($widgetData = array())
    {
        $form = $this->setupManagementForm('checkThreeItemForm');

        // Header
        $headerFieldset = new \Ip\Form\Fieldset();
        $headerFieldset->setLabel('Header');
        $form->addFieldset($headerFieldset);

        $form->addField(new \Ip\Form\Field\Text([
            'name' => 'title',
            'label' => 'Title',
            'value' => !empty($widgetData['title']) ? $widgetData['title'] : null
        ]));

        $form->addField(new \Ip\Form\Field\Checkbox([
            'name' => 'hasTransparentBackground',
            'label' => 'Use transparent background',
            'value' => !empty($widgetData['hasTransparentBackground']) ? true : false // Be explicit
        ]));

        $form->addField(new \Ip\Form\Field\Textarea([
            'name' => 'headerText',
            'label' => 'Header text',
            'value' => !empty($widgetData['headerText']) ? $widgetData['headerText'] : null
        ]));

        // 1st Item
        $form = $this->addItemFieldArea('firstItem', 1, $form, $widgetData);

        // 2nd Item
        $form = $this->addItemFieldArea('secondItem', 2, $form, $widgetData);

        // 3rd Item
        $form = $this->addItemFieldArea('thirdItem', 3, $form, $widgetData);

        // Footer
        $footerFieldset = new \Ip\Form\Fieldset();
        $footerFieldset->setLabel('Footer');
        $form->addFieldset($footerFieldset);

        $form->addField(new \Ip\Form\Field\Textarea([
            'name' => 'footerText',
            'label' => 'Footer text',
            'value' => !empty($widgetData['footerText']) ? $widgetData['footerText'] : null
        ]));

        return $form;
    }

    private function addItemFieldArea($name, $index, $form, $widgetData)
    {
        $itemFieldset = new \Ip\Form\Fieldset();
        $itemFieldset->setLabel($index . '. Item');
        $form->addFieldset($itemFieldset);

        $linkName = $name . 'Link';
        $form->addField(new \Ip\Form\Field\Url([
            'name' => $linkName,
            'label' => 'Page URL',
            'hint' => 'Link to where the user should go, if the item is clicked',
            'value' => !empty($widgetData[$linkName]) ? $widgetData[$linkName] : null,
        ]));

        $imageName = $name . 'Image';
        $form->addField(new \Ip\Form\Field\RepositoryFile([
            'name' => $imageName,
            'label' => 'Image',
            'value' => !empty($widgetData[$imageName]) ? $widgetData[$imageName] : null,
            'preview' => 'thumbnails', //or list. This defines how files have to be displayed in the repository browser
            'fileLimit' => 1, //optional. Limit file count that can be selected. -1 For unlimited
            'filterExtensions' => array('jpg', 'jpeg', 'png', 'gif', 'webm', 'ogg', 'svg') //optional
        ]));

        $titleName = $name . 'Title';
        $form->addField(new \Ip\Form\Field\Text([
            'name' => $titleName,
            'label' => 'Title',
            'value' => !empty($widgetData[$titleName]) ? $widgetData[$titleName] : null,
            'hint' => 'This items title. If omitted, will it hide the whole section!'
        ]));

        $bodyName = $name . 'Body';
        $form->addField(new \Ip\Form\Field\Text([
            'name' => $bodyName,
            'label' => 'Short text',
            'value' => !empty($widgetData[$bodyName]) ? $widgetData[$bodyName] : null
        ]));

        return $form;
    }

    private function topThreeSectionManagementForm($widgetData = array())
    {
        $form = $this->setupManagementForm('checkTopThreeSectionForm');

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

    public function checkTopThreeSectionForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->topThreeSectionManagementForm();
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

    protected function contentSectionManagementForm($widgetData = array())
    {
        $form = $this->setupManagementForm('checkContentSectionForm');

        /**
         * Place own values bellow
         */

        $form->addField(new \Ip\Form\Field\RepositoryFile([
            'name' => 'backgroundCover',
            'label' => 'Title Cover-image',
            'value' => !empty($widgetData['backgroundCover']) ? $widgetData['backgroundCover'] : null,
            'preview' => 'thumbnails', //or list. This defines how files have to be displayed in the repository browser
            'fileLimit' => 1, //optional. Limit file count that can be selected. -1 For unlimited
            'filterExtensions' => array('jpg', 'jpeg', 'png', 'gif', 'webm', 'ogg') //optional
        ]));

        $nameField = new \Ip\Form\Field\Text([
            'name' => 'title',
            'label' => 'Title',
            'value' => !empty($widgetData['title']) ? $widgetData['title'] : null
        ]);
        $form->addField($nameField);

        $form->addField(new \Ip\Form\Field\Text([
            'name' => 'subTitle',
            'label' => 'Sub-title',
            'value' => !empty($widgetData['subTitle']) ? $widgetData['subTitle'] : null
        ]));

        $form->addField(new \Ip\Form\Field\Textarea([
            'name' => 'text',
            'label' => 'Text',
            'note' => 'Write your text here, it supports markdown!',
            'value' => !empty($widgetData['text']) ? $widgetData['text'] : null
        ]));

        $configFieldset = new \Ip\Form\Fieldset();
        $configFieldset->setLabel('Styling');
        $form->addFieldset($configFieldset);

        $form->addField(new \Ip\Form\Field\Checkbox([
            'name' => 'hasTransparentBackground',
            'label' => 'Use transparent background',
            'value' => !empty($widgetData['hasTransparentBackground']) ? true : false // Be explicit
        ]));

        return $form;
    }

    protected function sliderManagementForm($widgetData = []): Form
    {
        $form = $this->setupManagementForm('checkSliderForm');

        $slides = ['first', 'second', 'third'];

        foreach ($slides as $key => $slide) {
            $form = $this->addSliderView($slide, $key + 1, $form, $widgetData);
        }

        $form->addField(new Form\Field\Hidden([
            'name' => 'views',
            'value' => json_encode($slides)
        ]));

        return $form;
    }

    private function addSliderView(string $name, int $index, Form $form, array $widgetData): Form
    {
        $fieldset = new \Ip\Form\Fieldset();
        $fieldset->setLabel('Slide: ' . $index );
        $form->addFieldset($fieldset);

        $linkName = $name . 'Link';
        $form->addField(new \Ip\Form\Field\Url([
            'name' => $linkName,
            'label' => 'Redirect URL',
            'hint' => 'Link to where the user should go, if he/she clicks the button on the slide',
            'value' => !empty($widgetData[$linkName]) ? $widgetData[$linkName] : null,
        ]));

        $linkLabelName = $name . 'LinkLabel';
        $form->addField(new Form\Field\Text([
            'name' => $linkLabelName,
            'label' => 'Redirect URL Label',
            'hint' => 'The text which is displayed on the button',
            'value' => !empty($widgetData[$linkLabelName]) ? $widgetData[$linkLabelName] : null
        ]));

        $imageName = $name . 'Image';
        $form->addField(new \Ip\Form\Field\RepositoryFile([
            'name' => $imageName,
            'label' => 'Image',
            'hint' => 'Cover image for this slide',
            'validators' => ['Required'],
            'value' => !empty($widgetData[$imageName]) ? $widgetData[$imageName] : null,
            'preview' => 'thumbnails',
            'fileLimit' => 1, //optional. Limit file count that can be selected. -1 For unlimited
            'filterExtensions' => array('jpg', 'jpeg', 'png', 'gif', 'webm', 'ogg', 'svg') //optional
        ]));

        $titleName = $name . 'Title';
        $form->addField(new \Ip\Form\Field\Text([
            'name' => $titleName,
            'label' => 'Title',
            'value' => !empty($widgetData[$titleName]) ? $widgetData[$titleName] : null,
            'hint' => 'This items title. If omitted, will it hide the whole section!'
        ]));

        $bodyName = $name . 'Body';
        $form->addField(new \Ip\Form\Field\Text([
            'name' => $bodyName,
            'label' => 'Short text',
            'value' => !empty($widgetData[$bodyName]) ? $widgetData[$bodyName] : null
        ]));

        return $form;
    }

    private function setupManagementForm(string $validationMethodName, ?array $widgetData = []): Form
    {
        $form = new Form();

        $form->setEnvironment(Form::ENVIRONMENT_ADMIN);

        //setting hidden input field so that this form would be submitted to 'errorCheck' method of this controller. (http://www.impresspages.org/docs/controller)
        $form->addField(new Form\Field\Hidden(
            array(
                'name' => 'aa',
                'value' => 'GrooaWidgets.' . $validationMethodName
            )
        ));

        return $form;
    }
}
