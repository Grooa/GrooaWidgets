<?php

namespace Plugin\GrooaWidgets;


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
                $form = $this->managementForm($widgetData);
                break;
            default:
                return new \Ip\Response\Json([
                    'error' => 'Unknown widget',
                    'widget' => $widgetRecord
                ]);
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
    public function checkForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->managementForm();
        $data = $form->filterValues($data); //filter post data to remove any non form specific items
        $errors = $form->validate($data); //http://www.impresspages.org/docs/form-validation-in-php-3
        if ($errors) {
            //error
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
        } else {
            //success
            unset($data['aa']);
            unset($data['securityToken']);
            unset($data['antispam']);
            $data = array (
                'status' => 'ok',
                'data' => $data

            );
        }
        return new \Ip\Response\Json($data);
    }

    protected function managementForm($widgetData = array())
    {
        $form = new \Ip\Form();

        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        //setting hidden input field so that this form would be submitted to 'errorCheck' method of this controller. (http://www.impresspages.org/docs/controller)
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'aa',
                'value' => 'GrooaWidgets.checkForm'
            )
        );

        $form->addField($field); // Keep at top

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

}
